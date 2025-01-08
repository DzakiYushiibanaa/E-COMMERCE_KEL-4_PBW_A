@extends('layouts.home')

@section('title', $category->name)

@section('content')

<div class="bg-gray-50 py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold text-center mb-6">Kategori: {{ $category->name }}</h1>
        <p class="text-center text-gray-500 mb-8">{{ $category->description }}</p>

        @if($products->isEmpty())
            <p class="text-center text-gray-500">Tidak ada produk dalam kategori ini.</p>
        @else
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach($products as $product)
                    <div class="group relative bg-white rounded-lg overflow-hidden transition-transform transform hover:scale-105 shadow-md hover:shadow-2xl">
                        <img src="{{ asset('products/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-48 sm:h-64 object-cover group-hover:opacity-80 transition-opacity duration-300">
                        
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('home/productdetail', $product->id) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>{{ $product->name }}
                                </a>
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('home/productdetail', $product->id) }}" 
                               class="mt-2 block text-indigo-600 hover:text-indigo-800">
                               Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
