<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Tenant;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();
        $totalUsers = User::where('role', '!=', 'super_admin')->count();
        $totalRevenue = Order::whereIn('status', ['selesai', 'diambil'])->sum('total');
        $recentTenants = Tenant::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTenants', 'activeTenants', 'totalUsers',
            'totalRevenue', 'recentTenants'
        ));
    }
}
