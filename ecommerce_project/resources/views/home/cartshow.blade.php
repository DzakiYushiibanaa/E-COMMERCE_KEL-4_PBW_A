@extends('layouts.home')

@section('content')

<div class="container mt-5">
    <h2>Keranjang Belanja</h2>

    <!-- Menampilkan notifikasi jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Cek jika keranjang kosong -->
    @if($carts->isEmpty())
        <div class="alert alert-warning">
            Keranjang Anda kosong.
        </div>
    @else
        <form action="{{ route('cart.checkout') }}" method="POST">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                            @foreach($cart->cartItems as $cartItem)
                                <tr>
                                    <td>
                                        <img src="{{ asset('products/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}" width="50">
                                        {{ $cartItem->product->name }}
                                    </td>
                                    <td>@currency($cartItem->product->price)</td>
                                    <td>@currency($cartItem->product->price * $cartItem->quantity)</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h4>Total: @currency($total)</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-primary">Lanjutkan ke Checkout</button>
                </div>
            </div>
        </form>
    @endif
</div>

    
    
    
@endsection

@include('home.js')
