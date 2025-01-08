@extends('layouts.home')

@section('title', 'My Cart')

@section('content')

<div class="container mx-auto p-4 sm:p-8">
    <h1 class="text-3xl sm:text-4xl font-extrabold mb-4 text-center text-gray-800">Keranjang Belanja</h1>

    <!-- Menampilkan jumlah item dalam keranjang -->
    <p class="text-lg mb-4 text-center text-gray-600">Jumlah Item: <span class="font-bold text-gray-800">{{ $count }}</span></p>

    @if($count > 0)
        <div class="space-y-4">
            @foreach($carts as $cart)
                @foreach($cart->cartItems as $cartItem)
                    @if($cartItem->product) <!-- Pastikan ada produk -->
                        <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white border border-gray-300 rounded-lg shadow-md">
                            <!-- Produk Details -->
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('products/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                <div>
                                    <h4 class="text-lg sm:text-xl font-semibold text-gray-800">{{ $cartItem->product->name }}</h4>
                                    <p class="text-gray-500 text-sm">{{ $cartItem->product->description }}</p>
                                </div>
                            </div>

                            <!-- Harga Produk -->
                            <div class="text-lg font-semibold text-gray-800 mt-2 sm:mt-0">
                                {{ 'Rp. '. number_format($cartItem->product->price, 0, ',', '.') }}
                            </div>

                            <!-- Update Quantity -->
                            <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                                <!-- Tombol Minus -->
                                <button class="text-xl text-gray-600 hover:text-gray-800" onclick="updateQuantity({{ $cartItem->id }}, 'decrease')">-</button>
                                <!-- Quantity Input (read-only) -->
                                <input id="quantity-{{ $cartItem->id }}" type="number" value="{{ $cartItem->quantity }}" min="1" max="99" class="w-12 p-1 text-center border rounded-md" readonly>
                                <!-- Tombol Plus -->
                                <button class="text-xl text-gray-600 hover:text-gray-800" onclick="updateQuantity({{ $cartItem->id }}, 'increase')">+</button>
                            </div>

                            <!-- Hapus Item -->
                            <div class="mt-2 sm:mt-0">
                                <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST" class="ml-0 sm:ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition duration-200">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>

        <!-- Total Harga -->
        <div class="bg-white p-4 mt-6 border rounded-lg shadow-md">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Total: <span class="text-green-600">Rp. {{ number_format($total, 0, ',', '.') }}</span></h3>
        </div>

        <!-- Tombol Lanjut ke Checkout -->
        <div class="mt-6 flex justify-center">
            <a href="{{ route('cart.checkout') }}" class="bg-green-500 text-white py-2 px-6 rounded-lg text-lg hover:bg-green-600 transition duration-300">Lanjutkan ke Checkout</a>
        </div>

    @else
        <p class="mt-6 text-lg text-center text-gray-600">Keranjang Anda kosong. <a href="{{ route('home.index') }}" class="text-blue-500 hover:text-blue-700">Kembali ke Belanja</a></p>
    @endif
</div>

<!-- Tambahkan Script untuk AJAX -->
<script>
    // Fungsi untuk update quantity
    function updateQuantity(cartItemId, action) {
        const quantityInput = document.getElementById(`quantity-${cartItemId}`);
        let currentQuantity = parseInt(quantityInput.value);

        if (action === 'increase') {
            currentQuantity++;
        } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--;
        }

        // Update nilai input
        quantityInput.value = currentQuantity;

        // Kirimkan data ke server untuk update quantity menggunakan AJAX
        fetch(`/cart/update/${cartItemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: currentQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optionally: tampilkan pesan sukses
                console.log("Quantity updated successfully!");
            } else {
                // Optionally: tampilkan pesan error
                console.log("Failed to update quantity.");
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
        });
    }
</script>


@endsection
