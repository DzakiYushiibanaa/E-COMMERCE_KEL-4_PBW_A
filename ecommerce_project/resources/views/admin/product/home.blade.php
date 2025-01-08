<style>
    @media (max-width: 768px) {
        .btn {
            padding: .375rem .75rem; /* Menyesuaikan padding tombol untuk layar kecil */
        }
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa; /* Warna background saat hover */
    }
    .table td, .table th {
        vertical-align: middle; /* Membuat teks di tengah secara vertikal */
    }
    .img-fluid {
        width: auto; /* Mempertahankan rasio aspek gambar */
        max-width: 100%;
        height: auto;
    }
    .table {
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); /* Menambahkan bayangan */
    }

    .input-group {
    max-width: 300px;
    }

    .table-responsive {
    margin-top: 20px;
    }

    .table img {
        max-height: 100px;
        width: auto;
    }

    .pagination {
        margin-top: 20px;
    }
    
</style>

@extends('layouts.admin')

@section('title', 'Katalog Produk')

@section('content')



<h5 class="mb-4">Katalog Produk</h5>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <form method="GET" action="{{ route('admin/products') }}" class="flex-grow-1 mr-3" id="search-form">
        <div class="input-group mb-3">
            <!-- Pencarian berdasarkan nama produk -->
            <input type="text" name="search" class="form-control" placeholder="Cari produk..." aria-label="Cari produk" value="{{ request('search') }}" aria-describedby="button-addon2">

            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
        </div>

        <div class="input-group mb-3">
            <!-- Dropdown Kategori -->
            <select name="category_id" class="form-select" id="category-id">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        
    </form>

    <a href="{{ route('admin/products/create') }}" class="btn btn-primary text-white px-4 py-2 rounded">
        <i class="bi bi-plus-lg me-2"></i> Product
    </a>
</div>

<form action="{{ route('admin/products/bulkupdate') }}" method="POST">
    @csrf
    <div class="d-flex justify-content-between mb-3">
        <!-- Dropdown Kategori untuk Bulk Update -->
        <div class="form-group">
            <label for="category_id" class="form-label">Select Category</label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tombol Apply Category untuk produk terpilih -->
        <button type="submit" name="action" value="update" class="btn btn-success">
            Apply Category to Selected Products
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">
                        <input type="checkbox" id="select-all">
                    </th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Category</th>
                    <th scope="col">Product Images</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="selected_products[]" value="{{ $product->id }}">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>Rp{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category ? $product->category->name : 'No Category' }}</td>
                        <td class="text-center">
                            <img class="img-fluid" src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}">
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin/products/update', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="{{ route('admin/products/delete', $product->id) }}" class="btn btn-sm btn-outline-danger delete-btn" data-url="{{ route('admin/products/delete', $product->id) }}">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tombol untuk Bulk Delete dan Bulk Category Update -->
    <button type="submit" name="action" value="delete" class="btn btn-danger mt-3 delete-selected-btn">
        Delete Selected
    </button>
</form>

<div>
    <div>
        <!-- Pagination Links -->
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Untuk tombol dengan class .delete-btn
        const deleteButtons = document.querySelectorAll('.delete-btn, .delete-selected-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah tindakan default

                // Cek apakah elemen adalah <a> atau <button>
                const isLink = this.tagName === 'A';
                const url = this.getAttribute('data-url'); // URL jika <a>
                const form = this.closest('form'); // Form jika <button>

                swal({
                    title: "Apakah Anda yakin?",
                    text: isLink 
                        ? "Produk ini akan dihapus secara permanen!" 
                        : "Data yang dipilih akan dihapus secara permanen!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        if (isLink && url) {
                            // Redirect ke URL jika elemen adalah <a>
                            window.location.href = url;
                        } else if (form) {
                            // Submit form jika elemen adalah <button>
                            form.submit();
                        }
                    } else {
                        swal("Penghapusan dibatalkan!");
                    }
                });
            });
        });
    });


    // Menangani otomatis submit form berdasarkan pilihan kategori
    document.getElementById('category-id').addEventListener('change', function() {
        document.getElementById('search-form').submit();  // Submit form ketika kategori dipilih
    });

    document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const toggleButton = document.querySelector('.sidebar-toggle');

        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-hidden'); // Mengubah status sidebar
        });
    });
    

</script>

@endsection