<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home')</title>
    <!-- Bootstrap CSS dan lainnya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="icon" href="{{ asset('images/RENZATI.SHOP (1).png') }}" type="image/png">


    @include('home.css')

</head>
<body>
    
    <header>
        <nav aria-label="Top" class="fixed top-0 inset-x-0 z-50 bg-white border-b border-gray-200 shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
              <!-- Bagian atas: Logo, Navigasi, dan Search -->
              <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                {{-- <div class="ml-4 flex lg:ml-0 m-3">
                  <a href="{{ route('home.index') }}">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="{{ asset('images/RENZATI.SHOP.png') }}" alt="Company Logo">
                  </a>
                </div> --}}

                <div class="ml-4 flex lg:ml-0 m-3">
                    <a href="{{ route('home.index') }}">
                        <span class="sr-only">Your Company</span>
                        <img class="h-12 w-12 object-cover rounded-full" src="{{ asset('images/RENZATI.SHOP (1).png') }}" alt="Company Logo">
                    </a>
                </div>
                
          
                <!-- Navigasi Kategori dengan Dropdown -->
                <div class="hidden lg:flex space-x-8 m-3 relative">
                  <div class="relative">
                    <button
                      id="categoryDropdownButton"
                      class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-300 flex items-center"
                      onclick="toggleDropdown()"
                    >
                      <i class="fas fa-th-large text-indigo-500 mr-1"></i> Kategori
                      <svg class="inline-block ml-1 h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </button>
                    <div
                      id="categoryDropdown"
                      class="absolute z-10 hidden mt-2 w-48 bg-white shadow-lg rounded-md border border-gray-200"
                    >
                      @foreach($categories as $category)
                        <a href="{{ route('category.show', $category->id) }}"
                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                          {{ $category->name }}
                        </a>
                      @endforeach
                    </div>
                  </div>
                </div>
          
                <!-- Search -->
                <div class="flex-grow flex justify-center">
                  <form action="{{ route('search') }}" method="GET" class="w-full max-w-lg">
                    <div class="relative">
                      <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        class="w-full py-2 px-4 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Search for products..."
                        required
                      />
                      <button type="submit" class="absolute inset-y-0 right-0 px-4 text-gray-500 hover:text-indigo-600">
                        <i class="fas fa-search text-indigo-500"></i>
                      </button>
                    </div>
                  </form>
                </div>
          
                <!-- Aksi (Desktop Only) -->
                <div class="hidden lg:flex space-x-6 items-center">
                  @auth

                    <!-- Profil Dropdown -->
                    <div class="relative group">
                        <!-- Tombol Profil -->
                        <button id="profileButton" class="flex items-center space-x-2 focus:outline-none">
                            <i class="fas fa-user text-blue-500 text-xl"></i>
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        </button>
                    
                        <!-- Dropdown Menu -->
                        <div
                        id="profileDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 shadow-lg rounded-lg opacity-0 invisible transition-opacity duration-300"
                        >
                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Edit Profil
                        </a>
                        <a
                            href="{{ route('transactions.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Lihat Transaksi
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                            type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                            Keluar
                            </button>
                        </form>
                        </div>
                    </div>
  

                    
                  @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-300">
                      <i class="fas fa-sign-in-alt text-indigo-500 mr-1"></i> Sign in
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-300">
                      <i class="fas fa-user-plus text-indigo-500 mr-1"></i> Create account
                    </a>
                  @endauth
          
                  <!-- Keranjang -->
                  <a href="{{ route('cart.index') }}" class="group flex items-center no-underline">
                    <i class="fas fa-shopping-cart text-green-500 text-lg"></i>
                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors duration-300">{{ $count }}</span>
                  </a>
                </div>
              </div>
            </div>
          </nav>
          

    <!-- Navigasi Bawah untuk Layar Kecil -->
<div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 lg:hidden h-16 z-50">
    <div class="flex justify-around items-center h-full">
      <!-- Kategori -->
      <button
        id="categoryButton"
        class="flex flex-col items-center text-sm font-medium text-gray-700 hover:text-indigo-600"
        onclick="toggleCategoryMenu()"
      >
        <i class="fas fa-th-large text-indigo-500 text-xl"></i>
        <span>Kategori</span>
      </button>
  
      <!-- Keranjang -->
      <a href="{{ route('cart.index') }}" class="flex flex-col items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
        <i class="fas fa-shopping-cart text-green-500 text-xl"></i>
        <span>Keranjang</span>
      </a>
  
      @auth
        <!-- Profil -->
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
          <i class="fas fa-user text-blue-500 text-xl"></i>
          <span>Profil</span>
        </a>
  
        <!-- Lihat Transaksi -->
        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
          <i class="fas fa-receipt text-orange-500 text-xl"></i>
          <span>Transaksi</span>
        </a>
      @else
        <!-- Login -->
        <a href="{{ route('login') }}" class="flex flex-col items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
          <i class="fas fa-sign-in-alt text-red-500 text-xl"></i>
          <span>Login</span>
        </a>
      @endauth
    </div>
  </div>
  

    <!-- Side Menu untuk Kategori -->
    <div
    id="categoryMenu"
    class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg z-50 transform -translate-x-full transition-transform duration-300"
    >
    <div class="p-4 border-b">
        <button
            onclick="closeCategoryMenu()"
            class="text-gray-500 hover:text-indigo-600"
        >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="p-4">
        <h2 class="text-lg font-medium text-gray-800">Kategori</h2>
        <ul class="mt-4 space-y-2">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('category.show', $category->id) }}" class="block text-sm text-gray-700 hover:bg-gray-100 p-2 rounded">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    </div>
</header>


    <main class="container mx-auto pt-20 pb-20">
        @yield('content')
    </main>

    
    

    <!-- Footer -->
    <footer class="bg-gray-100 text-black py-10 mt-10">
        <div class="container mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
    
                <!-- Kolom 1: Tentang Kami -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-black">Tentang Kami</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-black transition no-underline">Tentang Perusahaan</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">Blog</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">Karir</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">Hak Kekayaan Intelektual</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">Promo Hari Ini</a></li>
                    </ul>
                </div>
    
                <!-- Kolom 2: Layanan Pembelian -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-black">Beli</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-black transition no-underline">Tagihan & Top Up</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">COD</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">Bebas Ongkir</a></li>
                    </ul>
                    <h3 class="text-lg font-semibold mt-6 mb-4 text-black">Jual</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-black transition no-underline">Pusat Edukasi Seller</a></li>
                        <li><a href="#" class="hover:text-black transition no-underline">Daftar Official Store</a></li>
                    </ul>
                </div>
    
                <!-- Kolom 3: Keamanan & Privasi -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-black">Keamanan & Privasi</h3>
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="https://via.placeholder.com/100x50" alt="PCI DSS Compliant" class="h-10">
                        <img src="https://via.placeholder.com/100x50" alt="ISO Certification" class="h-10">
                    </div>
                    <h3 class="text-lg font-semibold mb-4 text-black">Ikuti Kami</h3>
                    <div class="flex space-x-6">
                        <a href="#" class="hover:text-black transition no-underline"><i class="fab fa-facebook text-3xl"></i></a>
                        <a href="#" class="hover:text-black transition no-underline"><i class="fab fa-twitter text-3xl"></i></a>
                        <a href="#" class="hover:text-black transition no-underline"><i class="fab fa-instagram text-3xl"></i></a>
                        <a href="#" class="hover:text-black transition no-underline"><i class="fab fa-pinterest text-3xl"></i></a>
                    </div>
                </div>
    
                <!-- Kolom 4: Aplikasi -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-black">Download Aplikasi</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="transition transform hover:scale-110 no-underline"><img src="https://via.placeholder.com/150x50" alt="Google Play"></a>
                        <a href="#" class="transition transform hover:scale-110 no-underline"><img src="https://via.placeholder.com/150x50" alt="App Store"></a>
                        <a href="#" class="transition transform hover:scale-110 no-underline"><img src="https://via.placeholder.com/150x50" alt="App Gallery"></a>
                    </div>
                </div>
            </div>
    
            <!-- Copyright -->
            <div class="text-center text-gray-500 mt-8 text-sm">
                &copy; {{ date('Y') }} Renzati Shop. All rights reserved.
            </div>
        </div>
    </footer>
    
    
    
    
    <!-- Scripts -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const toggleButton = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        toggleButton.addEventListener('click', () => {
            // Toggle mobile menu visibility with animation
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('opacity-0', 'scale-95');
                    mobileMenu.classList.add('opacity-100', 'scale-100');
                }, 10); // Small delay before adding the transition class
            } else {
                mobileMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 500); // Hide after the animation completes
            }
        });


        document.getElementById('profileDropdownMobile').addEventListener('click', function () {
        var dropdown = document.getElementById('dropdownMenuMobile');
        dropdown.classList.toggle('hidden');
    });


    // Fungsi untuk toggle dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('categoryDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Tutup dropdown jika klik di luar
    window.addEventListener('click', (event) => {
        const dropdown = document.getElementById('categoryDropdown');
        const dropdownButton = document.getElementById('categoryDropdownButton');
        if (dropdown && dropdownButton) {
            if (!dropdown.contains(event.target) && !dropdownButton.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });




    function toggleCategoryMenu() {
        const menu = document.getElementById('categoryMenu');
        menu.classList.toggle('-translate-x-full');
    }

    function closeCategoryMenu() {
        const menu = document.getElementById('categoryMenu');
        menu.classList.add('-translate-x-full');
    }

    // Tutup side menu jika klik di luar
    window.addEventListener('click', (event) => {
        const menu = document.getElementById('categoryMenu');
        const button = document.getElementById('categoryButton');
        if (!menu.contains(event.target) && !button.contains(event.target)) {
            menu.classList.add('-translate-x-full');
        }
    });


    


    document.addEventListener('DOMContentLoaded', () => {
    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');

    // Tampilkan/ Sembunyikan dropdown saat tombol diklik
    profileButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Mencegah penutupan langsung
      profileDropdown.classList.toggle('opacity-0');
      profileDropdown.classList.toggle('invisible');
    });

    // Sembunyikan dropdown saat klik di luar
    document.addEventListener('click', () => {
      profileDropdown.classList.add('opacity-0');
      profileDropdown.classList.add('invisible');
    });
  });

    </script>
</body>
</html>