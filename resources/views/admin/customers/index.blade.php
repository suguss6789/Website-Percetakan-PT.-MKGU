<!-- @extends('layouts.admin')

@section('title', 'Daftar Pelanggan')
@section('page-title', 'Pelanggan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-brand-teal">Daftar Pelanggan</h2>
    <a href="{{ route('admin.customers.create') }}" class="bg-brand-teal text-white px-4 py-2 rounded hover:bg-teal-700 transition">Tambah Pelanggan</a>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded shadow text-sm">
        <thead>
            <tr class="bg-brand-teal text-white">
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Nama</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">No HP</th>
                <th class="py-2 px-4">Jumlah Order</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $i => $customer)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $customers->firstItem() + $i }}</td>
                <td class="py-2 px-4">{{ $customer->customer_name }}</td>
                <td class="py-2 px-4">{{ $customer->customer_email }}</td>
                <td class="py-2 px-4">{{ \App\Models\Order::where('customer_email', $customer->customer_email)->first()->customer_phone ?? '-' }}</td>
                <td class="py-2 px-4">{{ \App\Models\Order::where('customer_email', $customer->customer_email)->count() }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.customers.show', $customer->customer_email) }}" class="text-brand-teal hover:underline mr-2">Detail</a>
                    <a href="{{ route('admin.customers.edit', $customer->customer_email) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.customers.destroy', $customer->customer_email) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $customers->links() }}</div>
</div>
@endsection  -->