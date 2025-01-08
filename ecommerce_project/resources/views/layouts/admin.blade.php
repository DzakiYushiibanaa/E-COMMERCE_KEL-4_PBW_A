<!DOCTYPE html>
@include('admin.css')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Online Store')</title>
    <!-- Bootstrap CSS dan lainnya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
</head>
<body>

    @include('partials.sidebar')
    <!-- Flasher Container -->
    
    
    <div class="content-wrapper" id="content">
            <!-- Konten top bar -->
        <header class="top-bar d-flex justify-content-between align-items-center px-4">
            <button class="btn btn-dark d-lg-none" id="menu-toggle">☰</button>
            <div class="flex-grow-1 d-none d-md-block"></div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="user-icon bi bi-person-circle"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>
        
        <main class="content bg-white shadow-sm mt-3 mx-3 rounded p-4">
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('content');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        contentWrapper.classList.toggle('active');  // Agar konten bergeser
    });
});
    
    document.getElementById('select-all').addEventListener('click', function(event) {
    var allCheckboxes = document.querySelectorAll('input[type="checkbox"][name="selected_products[]"]');
    for (var checkbox of allCheckboxes) {
        checkbox.checked = this.checked;
    }
});


</script>
</body>
</html>
