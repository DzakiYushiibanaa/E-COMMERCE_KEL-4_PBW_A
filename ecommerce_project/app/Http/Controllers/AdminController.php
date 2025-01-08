<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payments;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{

    public function dashboard()
    {
        // Hitung total produk
    $totalProducts = Product::count();

    // Hitung total kategori
    $totalCategory = Category::count();

    // Hitung total produk terjual
    $totalProductsSold = OrderItem::sum('quantity');

    // Hitung total pendapatan dari transaksi dengan status 'completed'
    $totalRevenue = Payments::where('payment_status', 'completed')->sum('amount');

    // Hitung jumlah transaksi yang berhasil
    $successfulTransactions = Order::where('status', 'processed')->count();

    // Kirim data ke view
    return view('admin.dashboard', compact('successfulTransactions', 'totalProducts', 'totalCategory', 'totalRevenue', 'totalProductsSold'));
    }

    // Menampilkan daftar pesanan untuk konfirmasi
    public function orderList()
    {
        // Ambil semua pesanan dengan informasi pembayaran dan status pengiriman
        $orders = Order::with('payment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function showOrder($id)
    {
        // Ambil detail pesanan beserta item dan produk
        $order = Order::with('orderItems.product', 'payment')->findOrFail($id);

        return view('admin.orders.detail', compact('order'));
    }

    public function updateOrderStatus($id, Request $request)
    {
        // Validasi input status pengiriman
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,delivered',
        ]);

        // Ambil pesanan berdasarkan ID
        $order = Order::findOrFail($id);

        // Ambil nama pengguna yang melakukan perubahan (misalnya, pengguna yang sedang login)
        $adminName = Auth::user()->name;  // Pastikan pengguna sudah login dan memiliki nama

        // Ambil nama pelanggan
        $customerName = $order->full_name;

        // Perbarui status pengiriman
        $order->status = $request->status;
        $order->save();

        // Notifikasi dengan informasi yang lebih lengkap
        notyf()->success("Status pengiriman untuk pesanan $order->order_number milik $customerName telah diperbarui oleh $adminName menjadi " . ucfirst($request->status));

        // Redirect kembali ke halaman daftar pesanan dengan notifikasi sukses
        return redirect()->route('orders.list');
    }

}
