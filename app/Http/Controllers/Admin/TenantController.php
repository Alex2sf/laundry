<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::withCount('users', 'orders')->latest()->paginate(15);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant)
    {
        $tenant->loadCount('users', 'orders', 'customers', 'services');
        $recentOrders = $tenant->orders()->with('customer')->latest()->take(10)->get();
        return view('admin.tenants.show', compact('tenant', 'recentOrders'));
    }

    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update([
            'status' => $tenant->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', "Status toko {$tenant->name} berhasil diubah menjadi " . strtoupper($tenant->status));
    }
}
