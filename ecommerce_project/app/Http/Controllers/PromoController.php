<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage; 


class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:1048', // Validasi file gambar
            'link' => 'nullable|url',
        ]);

        // Buat instance promo baru
        $promo = new Promo();
        $promo->title = $request->input('title');
        $promo->link = $request->input('link');

        // Tangani upload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension(); // Nama unik
            $image->move(public_path('promo'), $imagename); // Simpan di folder public/promo
            $promo->image = 'promo/' . $imagename; // Simpan path relatif di database
        }

        // Simpan data promo ke database
        $promo->save();

        // Notifikasi sukses
        notyf()->success('Promo berhasil ditambahkan!');
        return redirect()->route('promos.index');
    }

    public function destroy(Promo $promo)
    {
        // Hapus file gambar dari folder public jika ada
        if (File::exists(public_path($promo->image))) {
            File::delete(public_path($promo->image));
        }

        // Hapus data promo dari database
        $promo->delete();

        notyf()->success("promo berhasil dihapus.");


        // Redirect dengan pesan sukses
        return redirect()->route('promos.index');
    }
}
