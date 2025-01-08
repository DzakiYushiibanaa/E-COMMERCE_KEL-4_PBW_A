<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus semua data yang ada
        Product::truncate();

        // Pastikan folder gambar tujuan ada
        $destinationPath = public_path('products');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Gambar dummy
        $imageFiles = File::files(storage_path('app/seeder_images')); // Ambil gambar dari storage/app/seeder_images

        // Periksa apakah folder kosong
        if (empty($imageFiles)) {
            $this->command->error('Folder seeder_images kosong. Tambahkan gambar sebelum menjalankan seeder.');
            return;
        }

        // Menambahkan data baru
        for ($i = 1; $i <= 10; $i++) {
            $imageFile = $imageFiles[array_rand($imageFiles)]; // Pilih gambar secara acak

            // Salin gambar ke public/products
            $imageName = 'product_' . $i . '.' . pathinfo($imageFile, PATHINFO_EXTENSION);
            File::copy($imageFile, public_path('products/' . $imageName));

            Product::create([
                'name' => 'Produk ' . $i,
                'description' => 'Deskripsi Produk ' . $i,
                'price' => 100000 + ($i * 1000), // Menambahkan harga unik untuk tiap produk
                'stock' => 50 + $i,
                'image' => $imageName // Simpan nama file gambar di database
            ]);
        }
    }
}
