@extends('layouts.admin')
@section('title', 'Akun Saya')
@section('crumb', 'Akun Saya')

@section('content')
    <h1 class="text-3xl font-bold">Akun saya</h1>
    <form method="POST" action="{{ route('admin.account.update') }}" class="mt-8 max-w-xl space-y-5 border border-line bg-white p-6">
        @csrf @method('PUT')
        <div>
            <label class="field-label" for="name">Nama</label>
            <input id="name" name="name" value="{{ old('name', $admin->name) }}" required class="field-input">
        </div>
        <div>
            <label class="field-label" for="email">Email login</label>
            <input id="email" type="email" name="email" value="{{ old('email', $admin->email) }}" required class="field-input">
            @error('email')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <hr class="border-line">
        <div>
            <label class="field-label" for="password">Password baru</label>
            <input id="password" type="password" name="password" autocomplete="new-password" class="field-input">
            <p class="field-help">Kosongkan jika tidak ingin mengganti. Minimal 8 karakter.</p>
            @error('password')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="field-label" for="password_confirmation">Ulangi password baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="field-input">
        </div>
        <hr class="border-line">
        <div>
            <label class="field-label" for="current_password">Password lama *</label>
            <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="field-input">
            <p class="field-help">Wajib diisi untuk menyimpan perubahan apa pun.</p>
            @error('current_password')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <button class="btn-primary">Simpan</button>
    </form>
@endsection
