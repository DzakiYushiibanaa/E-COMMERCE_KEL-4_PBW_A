@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Manajemen Promo</h1>
<a href="{{ route('promos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Promo</a>

<table class="table-auto w-full mt-4">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Gambar</th>
            <th>Link</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promos as $promo)
        <tr>
            <td>{{ $promo->title }}</td>
            <td>
                <img src="{{ asset($promo->image) }}" alt="{{ $promo->title }}" width="100" class="rounded-md shadow-sm">
            <td>{{ $promo->link ?? '-' }}</td>
            <td>
                <form action="{{ route('promos.destroy', $promo) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
