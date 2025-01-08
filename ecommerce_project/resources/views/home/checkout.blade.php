@extends('layouts.home')

@section('content')

<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold mb-6 text-center text-gray-800">Checkout</h1>

    <!-- Form Pengiriman -->
    <form action="{{ route('cart.checkout.process') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Nama Lengkap -->
            <div>
                <label for="full_name" class="block text-lg font-medium text-gray-700">Nama Lengkap</label>
                {{-- <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required class="w-full p-3 border border-gray-300 rounded-md"> --}}
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->name ?? '') }}" required class="w-full p-3 border border-gray-300 rounded-md">
                @error('full_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            {{-- NO HP --}}
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  maxlength="12"
                required>
            </div>
            
            <!-- Alamat Pengiriman -->
            <div>
                <label for="shipping_address" class="block text-lg font-medium text-gray-700">Alamat Pengiriman</label>
                <textarea id="shipping_address" name="shipping_address" required class="w-full p-3 border border-gray-300 rounded-md">{{ old('shipping_address') }}</textarea>
                @error('shipping_address')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <!-- Pilih Kurir -->
            <div>
                <label for="courier" class="block text-lg font-medium text-gray-700">Pilih Kurir</label>
                <select id="courier" name="courier" required class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="jne" {{ old('courier') == 'jne' ? 'selected' : '' }}>JNE</option>
                    <option value="tiki" {{ old('courier') == 'tiki' ? 'selected' : '' }}>TIKI</option>
                    <option value="pos" {{ old('courier') == 'pos' ? 'selected' : '' }}>POS</option>
                </select>
                @error('courier')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <!-- Metode Pembayaran -->
            <div>
                <label for="payment_method" class="block text-lg font-medium text-gray-700">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method" required class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Bayar di Tempat (COD)</option>
                    <option value="midtrans" {{ old('payment_method') == 'midtrans' ? 'selected' : '' }}>Pembayaran Online</option>
                </select>
                @error('payment_method')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="bg-white p-6 mt-8 border rounded-lg shadow-md">
            <h3 class="text-2xl font-bold text-gray-800">Ringkasan Pesanan</h3>
            <ul>
                @php
                    $totalPrice = 0;
                @endphp
                @foreach($carts as $cart)
                    @foreach($cart->cartItems as $cartItem)
                        @if($cartItem->product) <!-- Pastikan ada produk -->
                            @php
                                $itemTotal = $cartItem->product->price * $cartItem->quantity;
                                $totalPrice += $itemTotal;
                            @endphp
                            <li class="flex items-center space-x-4 mt-4">
                                <!-- Gambar Produk -->
                                <div class="w-16 h-16 flex-shrink-0">
                                    <img src="{{ asset('products/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <!-- Detail Produk -->
                                <div class="flex-grow">
                                    <h4 class="font-semibold text-lg text-gray-800">{{ $cartItem->product->name }}</h4>
                                    <p class="text-sm text-gray-600">x{{ $cartItem->quantity }} Rp. {{ number_format($cartItem->product->price, 0, ',', '.') }}</p>
                                </div>
                                <!-- Harga Total Item -->
                                <span class="text-right text-lg text-gray-800">Rp. {{ number_format($itemTotal, 0, ',', '.') }}</span>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>

            <!-- Menampilkan Total Harga -->
            <div class="mt-4 flex justify-between text-lg text-gray-800 font-semibold">
                <span>Total Harga</span>
                <span>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tombol Checkout -->
        <div class="mt-8 flex justify-center">
            <button type="submit" class="bg-green-500 text-white py-3 px-8 rounded-lg text-lg hover:bg-green-600 transition duration-300">Proses Pembayaran</button>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">{{ implode(', ', $errors->all()) }}</span>
            </div>
        @endif

    </form>
</div>






<script>
    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.addEventListener('click', function() {
        submitButton.disabled = true;
        submitButton.textContent = 'Memproses...';
    });

    document.getElementById('phone').addEventListener('input', function(e) {
        let input = e.target.value;
        if (input.length > 12) {
            e.target.value = input.slice(0, 12); // Potong ke 12 karakter
        }
    });
</script>




@endsection
