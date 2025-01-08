@extends('layouts.admin')

 @section('title', 'Admin | Dashboard')
 
 @section('content')
     <h5 class="mb-4">Dashboard</h5>
     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
 
         <!-- Menampilkan total produk -->
         <div class="card shadow-sm p-6 bg-white rounded-xl flex items-center justify-between hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-box-seam text-4xl text-blue-600"></i>
             <div class="ml-4">
                 <p class="text-sm font-medium text-gray-600">Total Produk</p>
                 <p class="text-2xl font-semibold">{{ $totalProducts }}</p>
             </div>
         </div>
 
         <!-- Menampilkan total kategori -->
         <div class="card shadow-sm p-6 bg-white rounded-xl flex items-center justify-between hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-tags text-4xl text-green-600"></i>
             <div class="ml-4">
                 <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                 <p class="text-2xl font-semibold">{{ $totalCategory }}</p>
             </div>
         </div>
 
         <!-- Menampilkan jumlah transaksi berhasil -->
         <div class="card shadow-sm p-6 bg-white rounded-xl flex items-center justify-between hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-check-circle text-4xl text-teal-600"></i>
             <div class="ml-4">
                 <p class="text-sm font-medium text-gray-600">Transaksi Berhasil</p>
                 <p class="text-2xl font-semibold">{{ $successfulTransactions }}</p>
             </div>
         </div>
 
         <!-- Menampilkan total produk terjual -->
         <div class="card shadow-sm p-6 bg-white rounded-xl flex items-center justify-between hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-cart-check text-4xl text-yellow-600"></i>
             <div class="ml-4">
                 <p class="text-sm font-medium text-gray-600">Produk Terjual</p>
                 <p class="text-2xl font-semibold">{{ $totalProductsSold }}</p>
             </div>
         </div>
 
         <!-- Menampilkan total pendapatan -->
         <div class="card shadow-sm p-6 bg-white rounded-xl flex items-center justify-between hover:shadow-md transition-shadow duration-300 col-span-2 sm:col-span-2 md:col-span-3 lg:col-span-4">
             <i class="bi bi-wallet2 text-4xl text-purple-600"></i>
             <div class="ml-4">
                 <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                 <p class="text-2xl font-semibold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
             </div>
         </div>
 
     </div>
 
     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
         <!-- Katalog Produk -->
         <div class="card bg-blue-50 rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-box-seam text-3xl text-blue-600"></i>
             <h6 class="mt-3 font-medium text-blue-700">Katalog Produk</h6>
             <p class="text-sm text-gray-600">Kelola produk dengan mudah.</p>
             <a href="{{ route('admin/products') }}" class="btn btn-primary btn-sm mt-3">Lihat</a>
         </div>
 
         <!-- Category -->
         <div class="card bg-green-50 rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-tags text-3xl text-green-600"></i>
             <h6 class="mt-3 font-medium text-green-700">Category</h6>
             <p class="text-sm text-gray-600">Kelola kategori dengan mudah.</p>
             <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm mt-3">Lihat</a>
         </div>
 
         <!-- Pembayaran -->
         {{-- <div class="card bg-yellow-50 rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-credit-card text-3xl text-yellow-600"></i>
             <h6 class="mt-3 font-medium text-yellow-700">Pembayaran</h6>
             <p class="text-sm text-gray-600">Kelola transaksi pembayaran.</p>
             <a href="#" class="btn btn-primary btn-sm mt-3">Lihat</a>
         </div> --}}
 
         <!-- Konfirmasi Pesanan -->
         <div class="card bg-teal-50 rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-check-circle text-3xl text-teal-600"></i>
             <h6 class="mt-3 font-medium text-teal-700">Konfirmasi Pesanan</h6>
             <p class="text-sm text-gray-600">Validasi pesanan pengguna.</p>
             <a href="{{ route('orders.list') }}" class="btn btn-primary btn-sm mt-3">Lihat</a>
         </div>
 
         <!-- Laporan Penjualan -->
         <div class="card bg-purple-50 rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow duration-300">
             <i class="bi bi-bar-chart-line text-3xl text-purple-600"></i>
             <h6 class="mt-3 font-medium text-purple-700">Laporan Penjualan</h6>
             <p class="text-sm text-gray-600">Kelola laporan penjualan.</p>
             <a href="{{ route('sales.report') }}" class="btn btn-primary btn-sm mt-3">Lihat</a>
         </div>

         <!-- Promo Management -->
         <div class="card bg-purple-50 rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow duration-300">
            <i class="bi bi-megaphone text-4xl text-purple-500"></i>
            <h6 class="mt-3 font-medium text-purple-700">Manajemen Promo</h6>
            <p class="text-sm text-gray-600">Kelola promo untuk halaman utama.</p>
            <a href="{{ route('promos.index') }}" class="btn btn-primary btn-sm mt-3">Kelola Promo</a>
        </div>


     </div>
 @endsection
 