<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    // Menampilkan halaman laporan penjualan
    public function index(Request $request)
    {

        // Filter tanggal (default: bulan ini)
            $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : now()->startOfMonth();

        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date')) 
            : now()->endOfMonth();

        // Ambil data transaksi berdasarkan rentang tanggal
        $transactions = Order::with('payment')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'completed');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Persiapkan data grafik penjualan (penjualan per hari)
        $salesData = [];
        $dates = collect();
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dates->push($currentDate->format('Y-m-d'));
            $salesData[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        foreach ($transactions as $transaction) {
            $date = $transaction->created_at->format('Y-m-d');
            if (isset($salesData[$date])) {
                $salesData[$date] += $transaction->total_price;
            }
        }

        $chartLabels = $dates->toArray();
        $chartData = array_values($salesData);

        // Kirim data ke view
        return view('admin.laporan.index', [
            'transactions' => $transactions,
            'totalRevenue' => $transactions->sum('total_price'),
            'totalTransactions' => $transactions->count(),
            'totalProductsSold' => OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })->sum('quantity'),
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'averageRevenue' => $transactions->count() > 0 ? $transactions->sum('total_price') / $transactions->count() : 0
        ]);
    }
}
