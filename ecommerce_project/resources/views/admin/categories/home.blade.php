@extends('layouts.admin')

@section('title', 'Category')

@section('content')

<div class="container">
    <h1>Categories</h1>
    {{-- <a href="{{ route('admin/products/create') }}" class="btn btn-primary text-white px-4 py-2 rounded"> <i class="bi bi-plus-lg me-2"></i> Product</a> --}}
    <a href="{{ route('categories.create') }}" class="btn btn-primary text-white px-4 py-2 rounded"> <i class="bi bi-plus-lg me-2"></i>Add Category</a>
    @if ($categories->count())
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No categories found.</p>
    @endif
</div>



@endsection