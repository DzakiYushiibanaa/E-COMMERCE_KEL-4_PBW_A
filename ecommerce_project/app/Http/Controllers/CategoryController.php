<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Flasher\Notyf\Laravel\Facade\Notyf;
use Flasher\Notyf\Prime\Notyf as PrimeNotyf;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.home', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
        ]);

        Category::create($request->all());
        notyf()->success('Kategori berhasil ditambahkan!');
        return redirect()->back();
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {

        // Validasi input form
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string', // Deskripsi boleh kosong
        ]);

        // Update nama kategori dan deskripsi
        $category->name = $request->name;
        $category->description = $request->description; // Deskripsi bisa kosong

        // Simpan perubahan ke database
        $category->save();

        // Kirimkan notifikasi sukses dan arahkan kembali ke halaman kategori
        notyf()->success('Kategori berhasil diperbarui');
        return redirect()->route('categories.index');

        
    }

    public function destroy(Category $category)
    {
        $category->delete();
        notyf()->success('Kategori berhasil dihapus!');
        return redirect()->back();
    }

    public function show($id)
    {
        $category = Category::findOrFail($id); // Cari kategori berdasarkan ID
        $products = $category->products; // Asumsikan relasi kategori ke produk sudah dibuat
        return view('home.categories.show', compact('category', 'products'));
    }


}
