<!-- Sidebar -->
<nav class="sidebar d-flex flex-column p-3 text-white" id="sidebar">
    <h4 class="text-center py-3">Admin Panel</h4>
    <a href="{{ url('admin/dashboard') }}" class="d-flex align-items-center">
        <i class="menu-icon bi bi-house-door"></i>
        Dashboard
    </a>

    <!-- Dropdown for Katalog Produk -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <i class="menu-icon bi bi-box-seam"></i>
            Katalog Produk
        </a>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">
            <li>
                <a class="dropdown-item" href="{{ route('admin/products/create') }}">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('admin/products') }}">
                    <i class="bi bi-eye"></i> Lihat Produk
                </a>
            </li>
        </ul>
    </div>

    <a href="{{ route('categories.index') }}" class="d-flex align-items-center">
        <i class="menu-icon bi bi-tags"></i>
        Category
    </a>

    <a href="{{ route('orders.list') }}" class="d-flex align-items-center">
        <i class="menu-icon bi bi-check-circle"></i>
        Konfirmasi Pesanan
    </a>
    <a href="{{ route('sales.report') }}" class="d-flex align-items-center">
        <i class="menu-icon bi bi-bar-chart-line"></i>
        Laporan Penjualan
    </a>

    <a href="{{ route('promos.index') }}" class="d-flex align-items-center">
        <i class="menu-icon bi bi-megaphone"></i>
        Manajemen Promo
    </a>




    <div class="mt-auto">
        <a href="#" class="d-flex align-items-center">
            <i class="menu-icon bi bi-gear"></i>
            Pengaturan
        </a>
    </div>
</nav>
