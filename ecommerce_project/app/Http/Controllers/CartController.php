<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Flasher\Notyf\Laravel\Facade\Notyf;

class CartController extends Controller
{
    // Menampilkan produk di keranjang pengguna
    public function index()
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

    // Memperbarui jumlah produk di dalam keranjang
    public function update(Request $request, $cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem) {
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();
            Notyf::success('Jumlah produk berhasil diperbarui!');
        }

        return redirect()->route('cart.index');
    }

    // Update quantity secara AJAX
    public function updateQuantity(Request $request, $cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;  // Update quantity
            $cartItem->save();

            return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found']);
    }

    // Menghapus item dari keranjang
    public function remove($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem) {
            $cartItem->delete();
            Notyf::success('Produk berhasil dihapus dari keranjang!');
        }

        return redirect()->route('cart.index');
    }

}
