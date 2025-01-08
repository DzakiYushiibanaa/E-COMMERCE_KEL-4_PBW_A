@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')

<h1 class="text-3xl font-bold mb-6">Daftar Pesanan</h1>

<div class="bg-white p-6 border rounded-lg shadow-lg">
    @if($orders->isEmpty())
        <p class="text-center text-gray-600">Belum ada pesanan.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border border-gray-200 px-4 py-2">Nomor Pesanan</th>
                        <th class="border border-gray-200 px-4 py-2">Nama Pelanggan</th>
                        <th class="border border-gray-200 px-4 py-2">Total Harga</th>
                        <th class="border border-gray-200 px-4 py-2">Metode Pembayaran</th>
                        <th class="border border-gray-200 px-4 py-2">Status Pembayaran</th>
                        <th class="border border-gray-200 px-4 py-2">Status Pengiriman</th>
                        <th class="border border-gray-200 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-2">{{ $order->order_number }}</td>
                            <td class="px-4 py-2">{{ $order->full_name }}</td>
                            <td class="px-4 py-2">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>

                            <!-- Periksa apakah relasi payment tidak null -->
                            <td class="px-4 py-2">
                                {{ $order->payment ? ucfirst($order->payment->payment_method) : 'Tidak Ada Pembayaran' }}
                            </td>

                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-white rounded-lg text-sm 
                                    {{ $order->payment && $order->payment->payment_status === 'pending' ? 'bg-yellow-500' : 
                                       ($order->payment && $order->payment->payment_status === 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                                    {{ $order->payment ? ucfirst($order->payment->payment_status) : 'Belum Ada Status' }}
                                </span>
                            </td>

                            <td class="px-4 py-2">
                                <form action="{{ route('orders.update', $order->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="border border-gray-300 rounded-lg px-2 py-1 w-32">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Processed</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                    <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-1 rounded-lg">Update</button>
                                </form>
                            </td>

                            <td class="px-4 py-2">
                                <a href="{{ route('orders.details', $order->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
