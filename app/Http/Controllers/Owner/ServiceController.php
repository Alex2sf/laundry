<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    private function tenantId(): int
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        $services = Service::where('tenant_id', $this->tenantId())->latest()->get();
        return view('owner.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kiloan,satuan',
            'speed' => 'required|in:reguler,express,kilat',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:10',
            'estimated_hours' => 'required|integer|min:1',
        ]);

        Service::create([
            'tenant_id' => $this->tenantId(),
            ...$request->only('name', 'type', 'speed', 'price', 'unit', 'estimated_hours'),
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan! 🎉');
    }

    public function update(Request $request, Service $service)
    {
        abort_if($service->tenant_id !== $this->tenantId(), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kiloan,satuan',
            'speed' => 'required|in:reguler,express,kilat',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:10',
            'estimated_hours' => 'required|integer|min:1',
        ]);

        $service->update($request->only('name', 'type', 'speed', 'price', 'unit', 'estimated_hours'));
        return back()->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        abort_if($service->tenant_id !== $this->tenantId(), 403);
        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus!');
    }

    public function toggleActive(Service $service)
    {
        abort_if($service->tenant_id !== $this->tenantId(), 403);
        $service->update(['is_active' => !$service->is_active]);
        return back()->with('success', 'Status layanan berhasil diubah!');
    }
}
