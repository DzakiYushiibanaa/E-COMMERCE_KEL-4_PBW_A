<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold">Keranjang Belanja Anda</h2>
        @if($cart && $cart->items->count())
            <ul>
                @foreach($cart->items as $item)
                    <li>
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" width="50">
                        {{ $item->product->name }} - {{ $item->quantity }} x Rp {{ number_format($item->product->price, 2) }}
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">
                <a href="{{ route('checkout') }}" class="btn btn-primary">Lanjutkan ke Checkout</a>
            </div>
        @else
            <p>Keranjang Anda kosong.</p>
        @endif
    </div>
@endsection
