<style>
    .form-control {
        border-radius: 0.375rem;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.075);
    }
    .btn-primary {
        background-color: #4a69bd; /* Custom primary color */
        border: none;
    }
    .btn-primary:hover {
        background-color: #1e3799; /* Darker on hover */
    }
    
</style>

@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-0">Add Product</h1>
                <hr />
                @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session('error') }}
                </div>
                @endif

                <div class="text-end mb-4">
                    <a href="{{ route('admin/products') }}" class="btn btn-secondary">Go back</a>
                </div>

                <form action="{{ route('admin/products/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name Product</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Laptop">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter product description"></textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Rp12,000,000">
                        @error('price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" placeholder="20">
                        @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection