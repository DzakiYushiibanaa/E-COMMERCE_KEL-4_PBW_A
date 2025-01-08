@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold text-center mb-8 text-gray-800" style="font-family: 'Inter', sans-serif;">Detail Pesanan</h1>

    <div class="bg-white p-8 border border-gray-200 rounded-lg shadow-lg">
        <!-- Nomor Pesanan -->
        <div class="mb-4 flex justify-between">
            <h2 class="text-2xl font-semibold text-gray-800" style="font-family: 'Inter', sans-serif;">Nomor Pesanan:</h2>
            <span class="text-blue-600">{{ $order->order_number }}</span>
        </div>

        <!-- Nama Pelanggan -->
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Nama Pelanggan:</p>
            <span class="font-medium">{{ $order->full_name }}</span>
        </div>

        <!-- Alamat Pengiriman -->
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Alamat Pengiriman:</p>
            <span class="font-medium">{{ $order->shipping_address }}</span>
        </div>

        <!-- Status Pembayaran -->
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Status Pembayaran:</p>
            <span class="px-3 py-1 text-white rounded-lg text-sm {{ $order->payment && $order->payment->payment_status === 'pending' ? 'bg-yellow-500' : ($order->payment && $order->payment->payment_status === 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                {{ $order->payment ? ucfirst($order->payment->payment_status) : 'Belum Ada Status' }}
            </span>
        </div>

        <!-- Status Pengiriman -->
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Status Pengiriman:</p>
            <span class="px-3 py-1 text-white rounded-lg text-sm {{ $order->status === 'pending' ? 'bg-yellow-500' : ($order->status === 'shipped' ? 'bg-blue-500' : 'bg-green-500') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <!-- Nomor Resi -->
        @if($order->tracking_number)
            <div class="mb-4 flex justify-between">
                <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Nomor Resi:</p>
                <span class="font-medium">{{ $order->tracking_number }}</span>
            </div>
        @endif

        <!-- Metode Pembayaran -->
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Metode Pembayaran:</p>
            <span class="font-medium">{{ $order->payment ? ucfirst($order->payment->payment_method) : 'Tidak Ada Pembayaran' }}</span>
        </div>

        <!-- Total Harga -->
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Total Harga:</p>
            <span class="font-bold text-lg">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <!-- Produk dalam Pesanan -->
        <h3 class="mt-6 font-semibold text-lg text-gray-800" style="font-family: 'Inter', sans-serif;">Produk:</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
            @foreach($order->orderItems as $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 flex items-center">
                    <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                    <div>
                        <h4 class="font-semibold text-lg text-gray-800">{{ $item->product->name }}</h4>
                        <p class="text-gray-600">Jumlah: <span class="font-medium">x{{ $item->quantity }}</span></p>
                        <p class="text-gray-600">Harga: <span class="font-bold">Rp. {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span></p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tombol Kembali ke Daftar Pesanan -->
        <div class="mt-6">
            <a href="{{ route('orders.list') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>

@endsection
