{{-- <style>
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

@section('title', 'Update Product')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-0">Update Product</h1>
                <hr />
                
                <!-- Display Error Message -->
                @if(Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session('error') }}
                    </div>
                @endif

                <!-- Go Back Button -->
                <div class="text-end mb-4">
                    <a href="{{ route('admin/products') }}" class="btn btn-secondary">Go back</a>
                </div>

                <!-- Update Product Form -->
                <form action="{{ route('admin/products/edit', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" value="{{ $data->name }}" class="form-control" name="name" id="name" placeholder="Enter product name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ $data->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" value="{{ $data->price }}" class="form-control" name="price" id="price" placeholder="Enter price">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Stock -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" value="{{ $data->stock }}" class="form-control" name="stock" id="stock" placeholder="Enter stock">
                        @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div class="border p-2 rounded bg-light d-flex justify-content-center">
                            <img src="{{ asset('products/' . $data->image) }}" alt="Current Image" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    </div>

                    <!-- Upload New Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload New Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
@endsection --}}


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

@section('title', 'Update Product')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-0">Update Product</h1>
                <hr />
                
                <!-- Display Error Message -->
                @if(Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session('error') }}
                    </div>
                @endif

                <!-- Go Back Button -->
                <div class="text-end mb-4">
                    <a href="{{ route('admin/products') }}" class="btn btn-secondary">Go back</a>
                </div>

                <!-- Update Product Form -->
                <form action="{{ route('admin/products/edit', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" value="{{ $data->name }}" class="form-control" name="name" id="name" placeholder="Enter product name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ $data->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" value="{{ $data->price }}" class="form-control" name="price" id="price" placeholder="Enter price">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Stock -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" value="{{ $data->stock }}" class="form-control" name="stock" id="stock" placeholder="Enter stock">
                        @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="" disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div class="border p-2 rounded bg-light d-flex justify-content-center">
                            <img src="{{ asset('products/' . $data->image) }}" alt="Current Image" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    </div>

                    <!-- Upload New Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload New Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

