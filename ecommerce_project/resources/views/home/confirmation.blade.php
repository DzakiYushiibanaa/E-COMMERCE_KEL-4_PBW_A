@extends('layouts.home')

@section('content')

<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold mb-6 text-center text-gray-800">Konfirmasi Pesanan</h1>

    <div class="bg-white p-6 border rounded-lg shadow-lg transition-transform ">
        <h3 class="text-2xl font-bold text-gray-800">Nomor Pesanan: <span class="text-blue-600">{{ $order->order_number }}</span></h3>
        <p class="mt-4 text-lg text-gray-600">Terima kasih telah berbelanja! Berikut adalah rincian pesanan Anda:</p>

        <!-- Alamat Pengiriman -->
        <div class="mt-4 p-4 border-l-4 border-blue-500 bg-blue-50">
            <h4 class="font-semibold text-gray-800">Alamat Pengiriman</h4>
            <p class="text-gray-700">{{ $order->shipping_address }}</p>
        </div>

        <!-- Rincian Produk -->
        <div class="mt-4">
            <h4 class="font-semibold text-gray-800">Rincian Produk</h4>
            <ul class="list-disc list-inside">
                @foreach($order->orderItems as $orderItem)
                    <li class="flex items-center space-x-4 mt-4 p-2 border-b border-gray-200">
                        <!-- Gambar Produk -->
                        <div class="w-16 h-16 flex-shrink-0">
                            <img src="{{ asset('products/' . $orderItem->product->image) }}" alt="{{ $orderItem->product->name }}" class="w-full h-full object-cover rounded-lg shadow-sm">
                        </div>
                        <!-- Detail Produk -->
                        <div class="flex-grow">
                            <h4 class="font-semibold text-lg text-gray-800">{{ $orderItem->product->name }}</h4>
                            <p class="text-sm text-gray-600">x{{ $orderItem->quantity }}</p>
                        </div>
                        <!-- Harga Produk -->
                        <span class="text-lg text-gray-800">Rp. {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <hr class="my-4 border-gray-300">
            <div class="flex justify-between text-lg font-semibold">
                <span>Total</span>
                <span>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- <!-- Pembayaran -->
        <div class="mt-4 p-4 border-l-4 border-green-500 bg-green-50">
            <h4 class="font-semibold text-gray-800">Metode Pembayaran</h4>
            <p class="text-gray-700">{{ ucfirst($order->payment->payment_method) }}</p>
            <p class="text-gray-700">Status Pembayaran: <span class="font-semibold">{{ ucfirst($order->payment->payment_status) }}</span></p>
        </div> --}}


        <!-- Pembayaran -->
        <div class="mt-4 p-4 border-l-4 border-green-500 bg-green-50">
            <h4 class="font-semibold text-gray-800">Metode Pembayaran</h4>
            @if($order->payment)
                <p class="text-gray-700">{{ ucfirst($order->payment->payment_method) }}</p>
                <p class="text-gray-700">Status Pembayaran: <span class="font-semibold">{{ ucfirst($order->payment->payment_status) }}</span></p>
            @else
                <p class="text-gray-700 text-red-500">Metode pembayaran tidak ditemukan.</p>
            @endif
        </div>


        <!-- Tombol Kembali -->
        <div class="mt-6 text-center">
            <a href="{{ route('home.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-200 transform hover:scale-105">
                Kembali ke Beranda
            </a>
        </div>

    </div>
</div>



@endsection
