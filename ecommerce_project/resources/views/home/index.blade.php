<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Renzati Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- style --}}
    <style>

    .btn-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    transform: scale(1.05);
    transition: transform 0.3s ease;
    }

    #carousel {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
    }

    .carousel-slide {
        flex: 0 0 100%;
        width: 100%;
    }


    .slider-image-container {
      width: 100%;
      max-height: 400px; /* Batasi tinggi maksimum */
      overflow: hidden; /* Potong bagian gambar yang melebihi kontainer */
    }

    .slider-image-container img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Pastikan gambar terpotong secara proporsional */
    }

    @media (min-width: 1200px) {
      .slider-image-container {
        max-height: 500px; /* Tinggi lebih besar untuk layar besar */
      }
    }


    </style>


@extends('layouts.home')
</head>
<body>
@section('content')

  <section class="slider-section">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <!-- Indicators -->
      <div class="carousel-indicators">
        @foreach ($promos as $index => $promo)
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
        @endforeach
      </div>
      
      <!-- Slides -->
      <div class="carousel-inner">
        @foreach ($promos as $index => $promo)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="background-color: {{ $promo->background_color ?? '#f8f9fa' }};">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="col-12">
              <div class="slider-image-container">
                <img src="{{ asset($promo->image) }}" class="img-fluid rounded-lg shadow-md" alt="{{ $promo->title }}">
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
  
      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  
<div class="bg-gray-50"> <!-- Menggunakan latar belakang abu-abu sangat muda -->
  <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24">
    <h2 class="text-3xl font-bold tracking-tight text-gray-900 text-center mb-8">Produk Lain yang Mungkin Anda Suka</h2>

    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
      @foreach ($products as $product)
      <div class="group relative bg-white rounded-lg overflow-hidden transition-transform transform hover:scale-105 shadow-md hover:shadow-2xl"> <!-- Menambahkan efek hover scale dan shadow -->
        {{-- <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover group-hover:opacity-80 transition-opacity duration-300 lg:aspect-auto lg:h-72"> --}}
        <img src="{{ asset('products/' . $product->image) }}" 
     alt="{{ $product->name }}" 
     class="w-full h-48 sm:h-64 object-cover group-hover:opacity-80 transition-opacity duration-300" loading="lazy">

        
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800">
            <a href="{{ route('home/productdetail', $product->id) }}">
              <span aria-hidden="true" class="absolute inset-0"></span>{{ $product->name }}
            </a>
          </h3>
          <p class="mt-1 text-sm text-gray-600">{{ $product->description }}</p>
          <p class="mt-2 text-lg font-bold text-gray-900">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>


<section class="product-thumb-slider section-padding bg-light py-5">
  <div class="container">
    <div class="text-center pb-4">
      <h3 class="mb-3 h3 fw-bold text-primary">What We Offer!</h3>
      <p class="mb-0 text-muted">Discover the unique services we provide for your convenience</p>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <div class="col d-flex">
        <div class="card depth border-0 rounded shadow-sm w-100 text-center hover-transform">
          <div class="card-body">
            <div class="h1 fw-bold my-3 text-primary">
              <i class="fas fa-truck"></i>
            </div>
            <h5 class="fw-bold">Free Delivery</h5>
            <p class="text-muted">Enjoy free delivery for all orders, no minimum purchase required!</p>
          </div>
        </div>
      </div>
      <div class="col d-flex">
        <div class="card depth border-0 rounded shadow-sm w-100 text-center hover-transform">
          <div class="card-body">
            <div class="h1 fw-bold my-3 text-danger">
              <i class="fas fa-credit-card"></i>
            </div>
            <h5 class="fw-bold">Secure Payment</h5>
            <p class="text-muted">Your transactions are safe with our advanced security systems.</p>
          </div>
        </div>
      </div>
      <div class="col d-flex">
        <div class="card depth border-0 rounded shadow-sm w-100 text-center hover-transform">
          <div class="card-body">
            <div class="h1 fw-bold my-3 text-success">
              <i class="fas fa-undo"></i>
            </div>
            <h5 class="fw-bold">Free Returns</h5>
            <p class="text-muted">Hassle-free returns within 30 days for all products.</p>
          </div>
        </div>
      </div>
      <div class="col d-flex">
        <div class="card depth border-0 rounded shadow-sm w-100 text-center hover-transform">
          <div class="card-body">
            <div class="h1 fw-bold my-3 text-warning">
              <i class="fas fa-headset"></i>
            </div>
            <h5 class="fw-bold">24/7 Support</h5>
            <p class="text-muted">We're here to help anytime, anywhere, with our dedicated support team.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>





@endsection


    
@include('home.js')

<!-- JavaScript Slideshow -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
      const carousel = document.getElementById('carousel');
      const slides = carousel.children;
      const totalSlides = slides.length;
      let currentSlide = 0; // Menyimpan slide aktif
      let slideInterval;
  
      // Fungsi untuk menampilkan slide
      function showSlide(index) {
          currentSlide = index; // Perbarui slide aktif
          carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
      }
  
      // Fungsi untuk pindah ke slide berikutnya
      function nextSlide() {
          currentSlide = (currentSlide + 1) % totalSlides; // Kembali ke awal setelah slide terakhir
          showSlide(currentSlide);
      }
  
      // Fungsi untuk pindah ke slide sebelumnya
      function prevSlide() {
          currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; // Kembali ke akhir setelah slide pertama
          showSlide(currentSlide);
      }
  
      // Menangani tombol navigasi
      document.getElementById('next').addEventListener('click', () => {
          clearInterval(slideInterval); // Hentikan auto-slide saat tombol ditekan
          nextSlide();
          startAutoSlide(); // Mulai auto-slide lagi
      });
  
      document.getElementById('prev').addEventListener('click', () => {
          clearInterval(slideInterval);
          prevSlide();
          startAutoSlide();
      });
  
      // Fungsi Auto-Slide
      function startAutoSlide() {
          slideInterval = setInterval(() => {
              nextSlide();
          }, 3000); // Ganti slide setiap 3 detik
      }
  
      // Jalankan auto-slide saat halaman dimuat
      startAutoSlide();
  });
  </script>
  
  
  
</body>
</html>