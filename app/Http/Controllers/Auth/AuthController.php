<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Akun Anda dinonaktifkan.');
            }

            return $this->redirectByRole($user);
        }

        return back()->with('error', 'Email atau password salah.')->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'store_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Create tenant
        $tenant = Tenant::create([
            'name' => $request->store_name,
            'slug' => Str::slug($request->store_name) . '-' . Str::random(4),
            'phone' => $request->phone,
            'status' => 'active',
            'plan' => 'free',
        ]);

        // Create owner user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'owner',
            'tenant_id' => $tenant->id,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('owner.dashboard')->with('success', 'Selamat datang! Toko Laundry Anda berhasil didaftarkan. 🎉');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole($user)
    {
        return match ($user->role) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'owner', 'kasir' => redirect()->route('owner.dashboard'),
            default => redirect('/'),
        };
    }
}
