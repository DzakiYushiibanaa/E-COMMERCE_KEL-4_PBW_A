<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payments;
use App\Models\Product;
use Flasher\Notyf\Laravel\Facade\Notyf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class CheckoutController extends Controller
{
     // Menampilkan halaman checkout
     public function index(Request $request)
     {
        
        $user = Auth::user();
        $userid = $user->id;

        // Mengambil semua keranjang pengguna yang sudah dipilih
        $carts = Cart::where('user_id', $userid)
            ->with('cartItems.product')
            ->get();

        // Mengambil total harga
        $total = $carts->sum(function ($cart) {
            return $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->product ? $cartItem->product->price * $cartItem->quantity : 0;
            });
        });

        // Mengambil alamat pengguna (misalnya, dari tabel User atau Address)
        $address = $user->address;

        return view('home.checkout', compact('carts', 'total', 'address'));

    
     }


    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'courier' => 'required|in:jne,tiki,pos',
            'payment_method' => 'required|in:cod,midtrans',
        ]);

        // Ambil data keranjang
        $carts = Cart::where('user_id', $user->id)
            ->with('cartItems.product')
            ->get();

        $total = $carts->sum(function ($cart) {
            return $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->product ? $cartItem->product->price * $cartItem->quantity : 0;
            });
        });

        if ($total <= 0) {
            return back()->withErrors('Keranjang Anda kosong.');
        }

        // Buat Order
        $order = Order::create([
            'user_id' => $user->id,
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'shipping_address' => $validated['shipping_address'],
            'total_price' => $total,
            'status' => 'pending',
            'courier' => $validated['courier'],
        ]);

        $items = []; // Untuk menampung detail produk

        // Tambahkan item ke order_items
        foreach ($carts as $cart) {
            foreach ($cart->cartItems as $cartItem) {
                $order->orderItems()->create([
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Tambahkan detail produk ke $items
                $items[] = [
                    'id' => $cartItem->product->id,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'name' => $cartItem->product->name,
                ];

                // Kurangi stok produk
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }
        }

        // Hapus keranjang
        Cart::where('user_id', $user->id)->delete();

        // Buat pembayaran awal
        $payment = Payments::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'amount' => $total,
        ]);

        if ($validated['payment_method'] === 'cod') {
            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Pesanan berhasil diproses. Lanjutkan pembayaran COD.');
        }

        // Midtrans Config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat Snap Token
        try {
            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $total,
                ],

                'customer_details' => [
                    'first_name' => $validated['full_name'], // Nama pelanggan
                    'email' => $user->email,                // Email pelanggan
                    'phone' => $validated['phone'],         // Nomor telepon
                    'billing_address' => [
                        'address' => $validated['shipping_address'], // Alamat
                    ],
                ],

                'shipping_address' => [
                    'first_name' => $validated['full_name'],    // Nama penerima
                    'last_name' => '',                         // Kosong jika tidak ada field last name
                    'email' => $user->email,                   // Email penerima
                    'phone' => $validated['phone'],            // Nomor telepon penerima
                    'address' => $validated['shipping_address'], // Alamat pengiriman
                    'city' => 'Jakarta',                       // Kota (bisa dinamis)
                    'postal_code' => '12345',                  // Kode pos (bisa dinamis)
                    'country_code' => 'IDN',                   // Kode negara Indonesia
                ],
                'item_details' => $items, // Tambahkan detail produk di sini
            ]);

            return view('home.transactions.snap', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            return back()->withErrors('Gagal memproses pembayaran Midtrans: ' . $e->getMessage());
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;

            $order = Order::findOrFail($orderId);

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $order->update(['status' => 'paid']);
                $order->payment->update(['payment_status' => 'paid']);
            } elseif ($transactionStatus === 'pending') {
                $order->update(['status' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'failed']);
                $order->payment->update(['payment_status' => 'failed']);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function confirmation($order)
    {
        $order = Order::findOrFail($order); // Ambil order berdasarkan ID
        return view('home.confirmation', compact('order'));
    }


}
