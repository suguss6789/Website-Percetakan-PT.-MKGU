<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.account.edit', ['admin' => $request->user()]);
    }

    public function update(Request $request)
    {
        $admin = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:100', Rule::unique('admins', 'email')->ignore($admin->id)],
            'current_password' => ['required', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password lama tidak sesuai.',
        ], ['current_password' => 'password lama', 'password' => 'password baru']);

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        if (! empty($data['password'])) {
            $admin->password = $data['password'];
        }
        $admin->save();

        return back()->with('status', 'Akun diperbarui.');
    }
}
