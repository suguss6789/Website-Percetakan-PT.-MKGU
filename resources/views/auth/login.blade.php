

@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="container mx-auto max-w-md py-12">
    <h2 class="text-3xl font-bold mb-6 text-center">Login Admin</h2>
    <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-8 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="email" class="block font-semibold mb-2">Email</label>
            <input type="email" name="email" id="email" required class="w-full border px-4 py-2 rounded" autofocus>
        </div>
        <div class="mb-6">
            <label for="password" class="block font-semibold mb-2">Password</label>
            <input type="password" name="password" id="password" required class="w-full border px-4 py-2 rounded">
        </div>
        <button type="submit" class="w-full bg-brand-teal text-white py-2 rounded font-bold hover:bg-opacity-90 transition">Login</button>
    </form>
    <div class="mt-4 text-center">
        <span class="text-gray-400 text-sm">Login hanya untuk admin. User biasa tidak dapat login.</span>
    </div>
</div>
@endsection
