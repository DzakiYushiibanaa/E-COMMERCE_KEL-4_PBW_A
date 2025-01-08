<?php

namespace App\Http\Controllers;

use Flasher\Notyf\Laravel\Facade\Notyf;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(){
        // Memastikan user sudah login
        $user = Auth::user();  // Ini akan null jika pengguna belum login

        // Mengecek tipe pengguna dan redirect jika user adalah admin
        if ($user && $user->usertype === 'admin') {
            return redirect()->route('admin/dashboard');  // Redirect ke dashboard admin jika user adalah admin
        }

        // Variabel untuk jumlah item di keranjang
        $count = 0;

        // Jika user sudah login, hitung jumlah produk di keranjang
        if ($user) {
            // Ambil keranjang berdasarkan user_id
            $cart = Cart::where('user_id', $user->id)->first();

            if ($cart) {
                // Hitung total produk di dalam keranjang (jumlah setiap produk)
                $count = $cart->cartItems->sum('quantity');
            }
        }

        // Ambil semua produk untuk ditampilkan di halaman depan
        $products = Product::all();
        $promos = Promo::all();
        $categories = Category::all(); // Mengambil semua kategori dari database


        // Kirim data produk dan count (jumlah item di keranjang) ke view
        return view('home.index', compact('products', 'count', 'promos', 'categories'));
    }

    public function productDetail($id)
    {

        // Memastikan user sudah login
        $user = Auth::user();  // Ini akan null jika pengguna belum login

        // Mengecek tipe pengguna
        if ($user && $user->usertype === 'admin') {
            // Jika user adalah admin, arahkan ke halaman admin dashboard
            return redirect()->route('admin/dashboard');
        }

        // Jika user sudah login, ambil id user dan jumlah item di keranjang
        if ($user) {
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count(); // Menghitung jumlah item di keranjang
        } else {
            $count = 0; // Jika belum login, set jumlah keranjang ke 0
        }
        
        // Ambil data produk berdasarkan ID
        // $products = Product::findOrFail($id);
        // $category = Category::findOrFail($id);
        $products = Product::with('category')->findOrFail($id);


        // Kembalikan tampilan dengan data produk
        return view('home.product', compact('products', 'count'));
    }

    public function add_cart(Request $request, $id)
    {

        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            session(['url.intended' => url()->previous()]);
            return redirect()->route('login')->with('error', 'You must log in first to add a product to your cart.');
        }

        // Validasi input quantity
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);
        $user = Auth::user();
        $user_id = $user->id;
        $quantity = $request->quantity;

        // Cek apakah keranjang sudah ada untuk user ini, jika belum, buat keranjang baru
        $cart = Cart::firstOrCreate([
            'user_id' => $user_id,
        ]);

        // Cek apakah produk sudah ada di keranjang
        $existingCartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->first();

        if ($existingCartItem) {
            // Jika produk sudah ada, update jumlah produk di keranjang
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Jika produk belum ada di keranjang, tambahkan ke cart_items
            $cartItem = new CartItem;
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $id;
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        // Kirim notifikasi berhasil
        notyf()->success('Produk berhasil ditambahkan ke keranjang!');
        return redirect()->back();

    }

    // Menampilkan produk di keranjang pengguna
    public function show()
    {

        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id', $userid)->count();

        // Ambil semua cart yang terkait dengan user dan produk yang ada di dalam cartItems
        $carts = Cart::where('user_id', $user->id)
            ->with('cartItems.product')  // Memuat cartItems beserta produk terkait
            ->get();

        // Hitung total harga keranjang
        $total = $carts->sum(function ($cart) {
            return $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->product ? $cartItem->product->price * $cartItem->quantity : 0;
            });
        });

        return view('home.show', compact('count', 'carts', 'total'));
    }

     //Mengupdate jumlah produk dalam keranjang
     public function update(Request $request, $id)
     {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'action' => 'required|in:increase,decrease', // Validasi action yang diterima
        ]);
    
        // Temukan CartItem yang ingin diperbarui
        $cartItem = CartItem::findOrFail($id);

        // Pastikan CartItem milik user yang sedang login
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->route('home.cart.mycart')->with('error', 'Unauthorized action');
        }
    
        // Menambah atau mengurangi jumlah berdasarkan action
        if ($request->action == 'increase') {
            $cartItem->quantity++; // Tambah kuantitas
        } elseif ($request->action == 'decrease' && $cartItem->quantity > 1) {
            $cartItem->quantity--; // Kurangi kuantitas, dengan batasan min 1
        }
    
        // Simpan perubahan
        $cartItem->save();
    
        // Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('home/cart/mycart')->with('success', 'Cart updated successfully.');
     }
 
     //Menghapus produk dari keranjang
     public function remove($id)
     {
         // Cari item keranjang berdasarkan ID
        $cartItem = CartItem::find($id);

        // Pastikan item ada
        if ($cartItem) {
            // Hapus item
            $cartItem->delete();

            // Menambahkan pesan sukses
            Notyf::success('Produk berhasil dihapus dari keranjang');

            // Redirect ke halaman keranjang setelah penghapusan
            return redirect()->route('home/cart/mycart');
        }

        // Jika tidak ditemukan, beri pesan error
        Notyf::error('Produk tidak ditemukan di keranjang');
        return redirect()->route('home/cart/mycart');
     }

     // Menampilkan halaman checkout dengan produk yang dipilih
     public function checkout(Request $request)
     {
        $user = Auth::user();

        // Tampilkan halaman checkout dengan data produk yang dipilih
        return view('home.checkout', compact('cartItems', 'totalPrice'));
     }

     public function search(Request $request)
    {
        $query = $request->input('q');

        // Validasi input query
        if (!$query) {
            return redirect()->back()->with('error', 'Masukkan kata kunci pencarian.');
        }

        // Cari produk berdasarkan nama atau deskripsi
        $products = Product::where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%')
                    ->get();

        // Kirim hasil pencarian ke view
        return view('home.search', compact('products', 'query'));
    }

     
}
