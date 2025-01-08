@extends('layouts.home')

@section('title', 'List Transactions')

@section('content')

<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold text-center mb-8 text-gray-800" style="font-family: 'Inter', sans-serif;">Riwayat Transaksi Anda</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if($transactions->isEmpty())
            <div class="p-6 text-center">
                <p class="text-lg text-gray-600" style="font-family: 'Inter', sans-serif;">Anda belum memiliki transaksi.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Nomor Pesanan</th>
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Tanggal</th>
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Total Harga</th>
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Metode Pembayaran</th>
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Status Pembayaran</th>
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Status Pengiriman</th>
                            <th class="py-3 px-6 text-left" style="font-family: 'Inter', sans-serif;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($transactions as $transaction)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">{{ $transaction->order_number }}</td>
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">{{ $transaction->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">
                                    {{ optional($transaction->payment)->payment_method ?? 'Belum ada metode pembayaran' }}
                                </td>
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">
                                    <span class="px-2 py-1 text-white rounded-lg text-xs 
                                        {{ optional($transaction->payment)->payment_status === 'pending' ? 'bg-yellow-500' : (optional($transaction->payment)->payment_status === 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                                        {{ optional($transaction->payment)->payment_status ?? 'Belum ada status pembayaran' }}
                                    </span>
                                </td>
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">
                                    <span class="px-3 py-1 text-white rounded-lg text-xs {{ $transaction->status === 'pending' ? 'bg-yellow-500' : 'bg-green-500' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6" style="font-family: 'Inter', sans-serif;">
                                    <a href="{{ route('transaction.details', $transaction->id) }}" class="text-blue-600 hover:underline">Detail</a>
                                    @if(optional($transaction->payment)->payment_status === 'pending')
                                        <a href="{{ route('transactions.continue', $transaction->id) }}" class="ml-4 text-yellow-600 hover:underline">Lanjutkan Pembayaran</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
