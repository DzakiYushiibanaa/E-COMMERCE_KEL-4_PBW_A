@extends('layouts.home')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold text-center mb-8 text-gray-800" style="font-family: 'Inter', sans-serif;">Detail Transaksi</h1>

    <div class="bg-white p-8 border border-gray-200 rounded-lg shadow-lg">
        <div class="mb-4 flex justify-between">
            <h2 class="text-2xl font-semibold text-gray-800" style="font-family: 'Inter', sans-serif;">
                Nomor Pesanan:
            </h2>
            <span class="text-blue-600">{{ $transaction->order_number }}</span>
        </div>
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Tanggal:</p>
            <span class="font-medium">{{ $transaction->created_at->format('d M Y') }}</span>
        </div>
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Status:</p>
            <span class="px-3 py-1 text-white rounded-lg text-sm {{ $transaction->status === 'pending' ? 'bg-yellow-500' : 'bg-green-500' }}">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Total:</p>
            <span class="font-bold text-lg">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Metode Pembayaran:</p>
            <span class="font-medium">{{ ucfirst($transaction->payment->payment_method) }}</span>
        </div>
        <div class="mb-4 flex justify-between">
            <p class="text-gray-600" style="font-family: 'Inter', sans-serif;">Alamat Pengiriman:</p>
            <span class="font-medium">{{ $transaction->shipping_address }}</span>
        </div>

        <h3 class="mt-6 font-semibold text-lg text-gray-800" style="font-family: 'Inter', sans-serif;">Produk:</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
            @foreach($transaction->orderItems as $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 flex items-center" style="font-family: 'Inter', sans-serif;">
                    <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                    <div>
                        <h4 class="font-semibold text-lg text-gray-800">{{ $item->product->name }}</h4>
                        <p class="text-gray-600">Jumlah: <span class="font-medium">x{{ $item->quantity }}</span></p>
                        <p class="text-gray-600">Harga: <span class="font-bold">Rp. {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection