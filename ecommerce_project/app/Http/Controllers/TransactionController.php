<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi pelanggan
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi pelanggan saat ini
        $transactions = Order::with('payment')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home.transactions.index', compact('transactions'));
    }

    // Menampilkan detail transaksi tertentu
    public function details($id)
    {
        $user = Auth::user();

        // Ambil transaksi berdasarkan ID
        $transaction = Order::with('orderItems.product', 'payment')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('home.transactions.details', compact('transaction'));
    }

    public function handleWebhook(Request $request)
    {
        $notification = json_decode($request->getContent(), true);

        // Validasi signature key
        $signatureKey = hash('sha512', $notification['order_id'] . $notification['status_code'] . $notification['gross_amount'] . config('midtrans.server_key'));
        if ($signatureKey !== $notification['signature_key']) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil order ID dan status
        $orderId = $notification['order_id'];
        $paymentStatus = $notification['transaction_status']; // Status Midtrans

        // Cari pembayaran berdasarkan order_id
        $payment = Payments::where('order_id', $orderId)->first();

        if ($payment) {
            // Pemetaan status Midtrans ke ENUM Anda
            switch ($paymentStatus) {
                case 'pending':
                    $payment->payment_status = 'pending';
                    break;
                case 'settlement':
                    $payment->payment_status = 'completed'; // Mapping settlement ke completed
                    break;
                case 'expire':
                case 'cancel':
                case 'deny':
                    $payment->payment_status = 'failed';
                    break;
                case 'refund':
                    $payment->payment_status = 'refunded';
                    break;
            }

            // Simpan perubahan ke database
            $payment->save();
        }

        return response()->json(['message' => 'Notification handled'], 200);
    }

    public function continuePayment($orderId)
    {
        $user = Auth::user();

        // Cari pesanan berdasarkan ID dan user_id
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->with('payment')
            ->firstOrFail();

        // Pastikan status pembayaran adalah 'pending'
        if ($order->payment->payment_status !== 'pending') {
            return redirect()->route('transactions.index')->withErrors('Pembayaran sudah selesai atau tidak dapat dilanjutkan.');
        }

        // Midtrans Config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Buat Snap Token ulang
        $snapToken = \Midtrans\Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->full_name,
                'email' => $user->email,
                'phone' => $order->phone,
            ],
            'item_details' => $order->orderItems->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            })->toArray(),
        ]);
        

        // Redirect ke halaman pembayaran
        return view('home.transactions.snap', compact('snapToken', 'order'));
    }


}
