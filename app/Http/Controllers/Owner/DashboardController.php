<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function tenantId(): int
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        $tid = $this->tenantId();
        $today = today();

        // Stats
        $todayOrders = Order::where('tenant_id', $tid)->whereDate('created_at', $today)->count();
        $todayRevenue = Order::where('tenant_id', $tid)->whereDate('created_at', $today)->whereIn('status', ['selesai', 'diambil'])->sum('total');
        $pendingOrders = Order::where('tenant_id', $tid)->whereIn('status', ['antrian', 'proses'])->count();
        $totalCustomers = Customer::where('tenant_id', $tid)->count();
        $monthRevenue = Order::where('tenant_id', $tid)->whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->whereIn('status', ['selesai', 'diambil'])->sum('total');
        $monthExpenses = Expense::where('tenant_id', $tid)->whereMonth('expense_date', $today->month)->whereYear('expense_date', $today->year)->sum('amount');
        $unpaidOrders = Order::where('tenant_id', $tid)->where('payment_status', 'belum_bayar')->whereNotIn('status', ['batal'])->count();

        // Recent orders
        $recentOrders = Order::where('tenant_id', $tid)
            ->with('customer', 'user')
            ->latest()
            ->take(8)
            ->get();

        return view('owner.dashboard', compact(
            'todayOrders', 'todayRevenue', 'pendingOrders', 'totalCustomers',
            'monthRevenue', 'monthExpenses', 'unpaidOrders', 'recentOrders'
        ));
    }
}
