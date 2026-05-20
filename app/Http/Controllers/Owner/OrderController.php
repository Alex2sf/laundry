<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private function tenantId(): int
    {
        return Auth::user()->tenant_id;
    }

    public function index(Request $request)
    {
        $query = Order::where('tenant_id', $this->tenantId())
            ->with('user', 'customer');

        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('owner.orders.index', compact('orders'));
    }

    public function create()
    {
        $services = Service::where('tenant_id', $this->tenantId())->where('is_active', true)->get();
        $customers = Customer::where('tenant_id', $this->tenantId())->orderBy('name')->get();

        return view('owner.orders.create', compact('services', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'payment_method' => 'required|in:cash,qris,transfer',
            'payment_status' => 'required|in:lunas,dp,belum_bayar',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $tid = $this->tenantId();

        return DB::transaction(function () use ($request, $tid) {
            $subtotal = 0;
            $itemsData = [];
            $maxEstimatedHours = 0;

            foreach ($request->items as $item) {
                $service = Service::findOrFail($item['service_id']);
                abort_if((int) $service->tenant_id !== $tid, 403);

                $itemSubtotal = $service->price * $item['quantity'];
                $subtotal += $itemSubtotal;
                $maxEstimatedHours = max($maxEstimatedHours, $service->estimated_hours);

                $itemsData[] = [
                    'service_id' => $service->id,
                    'service_name' => $service->name . ' (' . ucfirst($service->speed) . ')',
                    'price' => $service->price,
                    'quantity' => $item['quantity'],
                    'unit' => $service->unit,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $total = $subtotal;
            $paidAmount = $request->paid_amount ?? 0;
            $changeAmount = max(0, $paidAmount - $total);

            $order = Order::create([
                'tenant_id' => $tid,
                'user_id' => Auth::id(),
                'customer_id' => $request->customer_id,
                'invoice_number' => Order::generateInvoiceNumber($tid),
                'subtotal' => $subtotal,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'status' => 'antrian',
                'estimated_done_at' => now()->addHours($maxEstimatedHours),
                'notes' => $request->notes,
            ]);

            foreach ($itemsData as $itemData) {
                $order->items()->create($itemData);
            }

            return redirect()->route('owner.orders.show', $order)
                ->with('success', 'Order berhasil dibuat! Invoice: ' . $order->invoice_number);
        });
    }

    public function show(Order $order)
    {
        abort_if((int) $order->tenant_id !== $this->tenantId(), 403);
        $order->load('items.service', 'customer', 'user');
        return view('owner.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_if((int) $order->tenant_id !== $this->tenantId(), 403);

        $request->validate([
            'status' => 'required|in:antrian,proses,selesai,diambil,batal',
        ]);

        $order->update(['status' => $request->status]);

        // If picked up and not paid, mark as lunas
        if ($request->status === 'diambil' && $order->payment_status !== 'lunas') {
            $order->update([
                'payment_status' => 'lunas',
                'paid_amount' => $order->total,
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function export(Request $request)
    {
        $query = Order::where('tenant_id', $this->tenantId())
            ->with(['user', 'customer', 'items']);

        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', "%{$request->search}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();
        $fileName = 'laporan_laundry_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $columns = ['No. Invoice', 'Tanggal', 'Kasir', 'Pelanggan', 'Layanan', 'Total', 'Dibayar', 'Status Bayar', 'Status Order', 'Catatan'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $services = $order->items->map(fn($i) => $i->service_name . ' (' . $i->quantity . ' ' . $i->unit . ')')->implode(', ');
                fputcsv($file, [
                    $order->invoice_number,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->user->name,
                    $order->customer->name ?? 'Umum',
                    $services,
                    $order->total,
                    $order->paid_amount,
                    ucfirst(str_replace('_', ' ', $order->payment_status)),
                    ucfirst($order->status),
                    $order->notes,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
