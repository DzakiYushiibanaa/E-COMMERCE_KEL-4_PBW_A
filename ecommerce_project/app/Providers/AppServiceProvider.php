<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // // Menyediakan jumlah keranjang ke setiap view
        // View::composer('*', function ($view) {
        //     $count = 0;
        //     $user = Auth::user();

        //     if ($user) {
        //         // Ambil keranjang berdasarkan user_id
        //         $cart = Cart::where('user_id', $user->id)->first();
        //         if ($cart) {
        //             // Hitung total produk di dalam keranjang
        //             $count = $cart->cartItems->sum('quantity');
        //         }
        //     }

        //     // Bagikan count (jumlah keranjang) ke setiap view
        //     $view->with('count', $count);
        // });


        // Menyediakan jumlah keranjang ke setiap view hanya untuk pengguna yang login
        View::composer('*', function ($view) {
            $count = 0;
            $user = Auth::user(); // Cek apakah ada pengguna yang login

            // Jika pengguna sudah login, ambil jumlah item dalam keranjang
            if ($user) {
                // Ambil keranjang berdasarkan user_id
                $cart = Cart::where('user_id', $user->id)->first();
                
                if ($cart) {
                    // Hitung jumlah produk dalam keranjang
                    $count = $cart->cartItems->sum('quantity');
                }
            }

            // Bagikan count (jumlah produk di keranjang) ke setiap view
            $view->with('count', $count);
        });

        View::composer('*', function ($view) {
            $categories = Category::all(); // Ambil semua kategori
            $view->with('categories', $categories); // Kirim ke semua view
        });
    }
}
