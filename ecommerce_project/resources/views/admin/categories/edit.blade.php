@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<div class="container">
    <h1>Edit Category</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
    
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>


@endsection