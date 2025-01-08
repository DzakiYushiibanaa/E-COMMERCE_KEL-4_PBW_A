<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    
    {{-- style --}}
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
    }

    .product-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 900px;
        margin: 0 auto;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-container:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        max-width: 100%;
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .product-image img {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .product-info {
        flex: 2;
        padding-left: 30px;
    }

    .product-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    .product-description {
        font-size: 16px;
        color: #666;
        margin: 15px 0;
    }

    .product-details p {
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    .product-price {
        font-size: 20px;
        font-weight: bold;
        color: #27ae60;
        margin-bottom: 20px;
    }

    .discount {
        text-decoration: line-through;
        color: #e74c3c;
        font-size: 16px;
        margin-left: 10px;
    }

    .add-to-cart-btn {
        background-color: #27ae60;
        color: white;
        padding: 12px 25px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn:hover {
        background-color: #2ecc71;
    }

    </style>

    @extends('layouts.home')
</head>
<body>
  @section('content')

 <!-- Container for the Product Details -->
 <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 bg-white shadow-lg rounded-lg overflow-hidden py-6">
    <div class="flex flex-col lg:flex-row justify-center items-start lg:space-x-8 space-y-6 lg:space-y-0">
        
        <!-- Product Image with Padding on top -->
        <div class="product-image flex-shrink-0 mt-6 lg:mt-0">
            <img src="{{ asset('products/' . $products->image) }}" alt="Product Image" class="w-full h-auto object-cover rounded-lg shadow-md">
        </div>

        <!-- Product Information -->
        <div class="product-info flex-1 space-y-6 mt-6 lg:mt-0 px-4 lg:px-6">
            <h1 class="text-2xl font-semibold text-gray-800">{{ $products->name }}</h1>
            <p class="text-lg text-gray-600">
                {{ $products->description }}
            </p>
            <div class="product-details text-gray-500">
                <p class="text-sm">Kategori: {{ $products->category ? $products->category->name : 'No Category' }}</p>
                <p class="text-sm">Stok: {{ $products->stock }}</p>
            </div>
            <div class="product-price flex items-center space-x-4">
                <span class="text-xl font-bold text-green-600">Rp. {{ number_format($products->price, 0, ',', '.') }}</span>
            </div>

            @auth
            <form action="{{ route('addCart/product', $products->id) }}" method="POST">
                @csrf
                <div class="flex items-center space-x-4 mt-4">
                    <input type="number" name="quantity" min="1" max="{{ $products->stock }}" value="1" class="w-20 text-center border border-gray-300 rounded-md p-2" />
                    <button type="submit" class="w-full py-3 bg-green-600 text-white text-lg font-semibold rounded-md hover:bg-green-700 transition-colors">
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-warning">Login untuk membeli</a>
            @endauth
        </div>
    </div>
</div>
  
  @endsection


    
    @include('home.js')
</body>
</html>

