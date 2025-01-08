@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Promo</h1>
<form action="{{ route('promos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Judul Promo</label>
        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
    </div>
    <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
        <input type="file" name="image" id="image" class="mt-1 block w-full" required>
    </div>
    <div class="mb-4">
        <label for="link" class="block text-sm font-medium text-gray-700">Link Promo (Opsional)</label>
        <input type="url" name="link" id="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan</button>
</form>

@endsection
