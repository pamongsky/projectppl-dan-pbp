<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\DashboardController;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('id', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); //session setelah login
            
            // Cek jumlah role
            $roles = $user->roles;
            

            if ($roles->count() > 1) {
                // Redirect ke halaman pilih role
                return view('auth.choose-role', ['roles' => $roles]);
            } else {
                // Redirect ke dashboard role tunggal
                $role = $roles->first();
                // session(['role' => $role->name]);
                session(['selected_role' => $role->name]);
                return $this->redirectToDashboard($role->name);
            }
        }
        return back()->withErrors(['error' => 'ID atau Password salah!']);
    }

    public function redirectToDashboard($roleName)
    {
        $roleName = strtolower(str_replace(' ', '_', $roleName)); // Mengganti spasi dengan underscore dan mengubah ke lowercase
        return redirect()->route("dashboard.{$roleName}");
    }  

    // untuk pengalihan ke dashboard dan pemilihan role dari role-role yang dimiliki user
    // dipanggil di choose-role.blade.php menggunakan nama set-role, dimana nama set-role telah diinisialisasi di web.php menggunakan nama set-role fungsi setRole
    public function setRole(Request $request)
    {
        // Validasi role
        $request->validate([
            'role' => 'required|exists:roles,id', // Pastikan role yang dipilih ada di tabel roles
        ]);

        // Ambil ID role yang dipilih
        $roleId = $request->input('role');
        $role = Role::find($roleId);
        
        if ($role) {
            $roleName = strtolower(str_replace(' ', '_', $role->name)); // Mengganti spasi dengan underscore dan mengubah ke lowercase
            $user = Auth::user();
            if ($user && $user->roles->contains('id', $role->id)) {
                session(['selected_role' => $role->name]);
                // Redirect ke dashboard berdasarkan nama role
                return redirect()->route("dashboard.{$roleName}");
            }

            return back()->withErrors(['error' => 'Anda tidak memiliki akses ke role ini.']);
        }

        return back()->withErrors(['error' => 'Role tidak valid!']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('message', 'You have been logged out.');
    }
}
