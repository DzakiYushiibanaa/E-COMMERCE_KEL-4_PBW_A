@extends('layouts.admin')

@section('title', 'Admin | Laporan Penjualan')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6 text-gray-700">Laporan Penjualan</h1>

    <!-- Filter Rentang Tanggal -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
        <form method="GET" action="{{ route('sales.report') }}" class="flex flex-col sm:flex-row gap-4 items-center">
            <label for="start-date" class="font-medium text-gray-700">Dari Tanggal:</label>
            <input type="date" name="start_date" id="start-date" value="{{ request('start_date') }}" 
                class="border rounded-lg p-2 w-full sm:w-auto">

            <label for="end-date" class="font-medium text-gray-700">Hingga Tanggal:</label>
            <input type="date" name="end_date" id="end-date" value="{{ request('end_date') }}" 
                class="border rounded-lg p-2 w-full sm:w-auto">

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Ringkasan Laporan Penjualan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <i class="bi bi-wallet2 text-4xl text-purple-500"></i>
            <div class="text-right">
                <p class="text-lg font-medium text-gray-700">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Jumlah Transaksi -->
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <i class="bi bi-check-circle text-4xl text-green-500"></i>
            <div class="text-right">
                <p class="text-lg font-medium text-gray-700">Jumlah Transaksi</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTransactions }}</p>
            </div>
        </div>

        <!-- Produk Terjual -->
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <i class="bi bi-cart-check text-4xl text-blue-500"></i>
            <div class="text-right">
                <p class="text-lg font-medium text-gray-700">Produk Terjual</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalProductsSold }}</p>
            </div>
        </div>

        <!-- Rata-rata Pendapatan -->
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <i class="bi bi-graph-up text-4xl text-yellow-500"></i>
            <div class="text-right">
                <p class="text-lg font-medium text-gray-700">Rata-rata Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($averageRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Grafik Penjualan</h2>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <!-- Tabel Rincian Penjualan -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Rincian Penjualan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-left">
                        <th class="border border-gray-300 px-4 py-2">Nomor Pesanan</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Pelanggan</th>
                        <th class="border border-gray-300 px-4 py-2">Total Harga</th>
                        <th class="border border-gray-300 px-4 py-2">Metode Pembayaran</th>
                        <th class="border border-gray-300 px-4 py-2">Status Pembayaran</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->order_number }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->full_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->payment->payment_method ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <span class="px-2 py-1 rounded-lg text-white text-sm 
                                {{ $transaction->payment->payment_status === 'completed' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                {{ ucfirst($transaction->payment->payment_status ?? '-') }}
                            </span>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan Penjualan',
                data: chartData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
