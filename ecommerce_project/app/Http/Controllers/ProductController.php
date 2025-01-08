<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Flasher\Laravel\Facade\Flasher;
use Flasher\Notyf\Laravel\Facade\Notyf;
use Flasher\Notyf\Prime\Notyf as PrimeNotyf;
use Flasher\SweetAlert\Prime\SweetAlert;


use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian dan kategori yang dipilih
        $query = $request->input('search');
        $category_id = $request->input('category_id');

        $categories = \App\Models\Category::all();

        $products = Product::when($query, function ($queryBuilder, $query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('price', 'like', '%' . $query . '%')
                    ->orWhere('stock', 'like', '%' . $query . '%');
            })
            ->when($category_id, function ($queryBuilder, $category_id) {
                $queryBuilder->where('category_id', $category_id);
            })
            ->paginate(5);

        return view('admin.product.home', compact('products', 'categories'));
    }

    public function create(){
        $categories = Category::all(); // Ambil semua kategori dari database
        return view('admin.product.create', compact('categories')); // Kirim ke view
    }

        public function update($id)
        {
            $data = Product::find($id);
            return view('admin.product.update', compact('data'));
        }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:512', // Validasi ukuran file maksimum 500KB
        ]);

        // Proses penyimpanan data
        $data = new Product();
        $data->fill($request->only(['name', 'description', 'price', 'stock', 'category_id']));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $data->image = $imagename;
        }

        $data->save();

        notyf()->success('Produk berhasil ditambahkan!');
        return redirect()->route('admin/products');
    }


    public function edit(Request $request,$id)
    {
        $data = Product::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->category_id = $request->category_id; // Update kategori produk
        $image = $request->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename); // Simpan file di folder public/products
            $data->image = $imagename; // Simpan nama file di database
        }
        $data->save();
        notyf()->success('Produk berhasil diperbarui');
        return redirect('admin/products');
    }

    public function delete($id)
    {
        $data = Product::find($id);
        
        if (!$data) {
            // Jika produk tidak ditemukan, kembali dengan pesan error
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
    
        // Pastikan kolom image tidak kosong
        if (!empty($data->image)) {
            $image_path = public_path('products/' . $data->image); // Path lengkap file gambar
            
            // Periksa apakah file gambar benar-benar ada dan bukan direktori
            if (file_exists($image_path) && is_file($image_path)) {
                unlink($image_path); // Hapus file gambar
            }
        }

        $data->delete();
        notyf()->success('Produk berhasil dihapus');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {

        $ids = $request->input('selected_products', []); // Ambil ID produk yang dipilih
        if (empty($ids)) {
            notyf()->error('Tidak ada produk yang dipilih untuk dihapus.');
            return redirect()->back();
        }

        $products = Product::whereIn('id', $ids)->get();

        foreach ($products as $product) {
            // Hapus gambar jika ada
            if ($product->image) {
                $image_path = public_path('products/' . $product->image);
                if (file_exists($image_path)) {
                    unlink($image_path); // Hapus gambar
                }
            }
        }

        // Hapus produk setelah gambar dihapus
        $deletedCount = Product::destroy($ids); // Gunakan destroy untuk menghapus produk

        // Tentukan pesan sukses berdasarkan jumlah produk yang dihapus
        notyf()->success("$deletedCount produk berhasil dihapus.");
        return redirect()->back();
    }

    public function bulkCategoryUpdate(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'selected_products' => 'required|array|min:1',  // Pastikan ada produk yang dipilih
            'selected_products.*' => 'exists:products,id',   // Validasi ID produk
        ]);
    
        $categoryId = $request->category_id;
        $productIds = $request->selected_products;
    
        // Update kategori untuk produk yang dipilih
        $updatedCount = Product::whereIn('id', $productIds)
        ->update(['category_id' => $categoryId]);
    
        // Menampilkan notifikasi setelah update kategori
        notyf()->success("$updatedCount produk berhasil dipindahkan ke kategori yang dipilih.");
    
        return redirect()->route('admin/products');
    }

    public function bulkUpdate(Request $request)
    {
        // Cek aksi yang dipilih (delete atau update category)
        if ($request->action === 'delete') {
            // Bulk delete
            return $this->bulkDelete($request);
        } elseif ($request->action === 'update') {
            // Bulk category update
            return $this->bulkCategoryUpdate($request);
        }
        
        // Jika aksi tidak dikenali
        return redirect()->back()->with('error', 'Invalid action.');
    }

    public function show($id)
    {
        $products = Product::findOrFail($id);  // Fetch the product by its ID
        return view('product.show', compact('products'));
    }

}
