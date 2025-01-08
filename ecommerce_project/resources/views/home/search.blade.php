<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results</title>
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
            gap: 20px;
            padding: 30px;
        }

        .product-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 280px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eaeaea;
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 18px;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 10px;
        }

        .view-details-btn {
            display: block;
            text-align: center;
            background-color: #27ae60;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .view-details-btn:hover {
            background-color: #2ecc71;
        }
    </style>

    @extends('layouts.home')
</head>
<body>
    @section('content')

        <div class="bg-gray-50 py-10">
            <div class="container mx-auto px-4">
                <h1 class="text-2xl font-bold text-center mb-6">Hasil Pencarian: "{{ $query }}"</h1>
                
                @if ($products->isEmpty())
                    <p class="text-center text-gray-500">Tidak ada produk yang ditemukan.</p>
                @else
                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        @foreach ($products as $product)
                        <div class="group relative bg-white rounded-lg overflow-hidden transition-transform transform hover:scale-105 shadow-md hover:shadow-2xl">
                            <img src="{{ asset('products/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-48 sm:h-64 object-cover group-hover:opacity-80 transition-opacity duration-300">
    
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <a href="{{ route('home/productdetail', $product->id) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>{{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">{{ Str::limit($product->description, 80) }}</p>
                                <p class="mt-2 text-lg font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endsection

    @include('home.js')
</body>
</html>
