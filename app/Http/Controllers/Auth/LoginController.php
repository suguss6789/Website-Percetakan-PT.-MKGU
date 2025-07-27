<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = \App\Models\Admin::where('email', $credentials['email'])->first();
        $hashCheck = $user ? \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password) : null;
        $success = \Illuminate\Support\Facades\Auth::attempt(array_merge($credentials, ['role' => 'admin']), $request->filled('remember'));
        if ($success) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        // Debug info jika login gagal
        dd([
            'input' => $credentials,
            'user' => $user,
            'hash_check' => $hashCheck,
            'auth_attempt' => $success,
            'session_id' => session()->getId(),
            'session_driver' => config('session.driver'),
            'session_path' => storage_path('framework/sessions'),
        ]);
        return back()->withErrors([
            'email' => 'Hanya admin yang dapat login.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
