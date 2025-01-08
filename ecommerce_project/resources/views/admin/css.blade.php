<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


<style>
    body {
        background-color: #f8f9fa;
    }

    /* Sidebar Styling */
   
    .sidebar {
    background-color: #1E3A8A; /* Biru Tua */
    min-height: 100vh;
    position: fixed;
    z-index: 1000;
    width: 250px;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
}

.sidebar.active {
    transform: translateX(0);
}

.sidebar h4 {
    color: #F1F5F9; /* Putih */
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
}

.sidebar a {
    color: #F1F5F9; /* Putih */
    text-decoration: none;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 5px;
    transition: background-color 0.2s, padding-left 0.2s;
}

.sidebar a:hover {
    background-color: #1E40AF; /* Biru Lebih Terang */
    padding-left: 20px;
}

.sidebar .menu-icon {
    font-size: 18px;
    transition: transform 0.2s;
}

.sidebar a:hover .menu-icon {
    transform: scale(1.1);
}



    .top-bar {
    height: 64px; /* Tinggi top bar */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
    background-color: #ffffff; /* Warna latar belakang putih */
    position: sticky; /* Posisi tetap di bagian atas */
    top: 0; /* Menempel di atas */
    z-index: 900; /* Z-index tinggi untuk menempatkan di atas elemen lain */
    color: #333333; /* Warna teks gelap untuk kontras yang baik */
}

.top-bar .search-box {
    max-width: 300px; /* Lebar maksimum untuk kotak pencarian */
}

.top-bar .user-icon {
    font-size: 1.5rem; /* Ukuran ikon pengguna */
    margin-right: 8px; /* Jarak kanan untuk ikon pengguna */
}

/* Tambahan untuk dropdown menu */
.top-bar .dropdown-menu {
    background-color: #ffffff; /* Warna latar belakang dropdown */
    border: none; /* Menghilangkan border pada dropdown */
}

.top-bar .dropdown-item {
    color: #333333; /* Warna teks item dropdown */
}

.top-bar .dropdown-item:hover {
    background-color: #f0f0f0; /* Warna latar belakang item dropdown saat hover */
}

    /* Content Styling */
    .content-wrapper {
        margin-left: 0;
        transition: margin-left 0.3s ease-in-out;
    }

    .content-wrapper.active {
        margin-left: 250px;
    }

    /* Cards Styling */
    .card h6 {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .card p {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Responsive Sidebar */
    @media (min-width: 768px) {
        .sidebar {
            transform: translateX(0);
        }
        .content-wrapper {
            margin-left: 250px;
        }
    }

</style>