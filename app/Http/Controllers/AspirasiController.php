<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;

class AspirasiController extends Controller
{
    // Tampilan untuk Siswa (Halaman Depan)
    public function index()
    {
        // Mengambil semua kategori untuk dropdown di form
        $kategoris = Kategori::all();

        // Mengambil data aspirasi terbaru dengan relasi kategori (Eager Loading agar cepat)
        $aspirasis = Aspirasi::with('kategori')->latest()->get();

        return view('siswa', compact('kategoris', 'aspirasis'));
    }

    // Fungsi menyimpan aspirasi baru dari Siswa
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|numeric',
            'nama' => 'required|string|max:100', // Validasi Nama
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'ket' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Validasi Foto (max 2MB)
        ]);

        // Logika Upload Foto
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads'), $namaFoto); // Simpan ke folder public/uploads
        }

        // Pastikan Siswa Terdaftar (seperti sebelumnya)
        $siswa = \App\Models\Siswa::find($request->nis);
        if (!$siswa) {
            \App\Models\Siswa::create(['nis' => $request->nis, 'kelas' => '12 RPL']);
        }

        \App\Models\Aspirasi::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
            'foto' => $namaFoto,
            'status' => 'Menunggu',
        ]);

        return redirect()->back()->with('success', 'Aspirasi berhasil dikirim!');
    }

    // Tampilan untuk Admin
    public function adminIndex(Request $request)
    {
        $query = \App\Models\Aspirasi::with('kategori');

        // Filter berdasarkan Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter berdasarkan Tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('created_at', $request->tanggal);
        }

        $aspirasis = $query->latest()->get();
        $kategoris = \App\Models\Kategori::all(); // Diperlukan untuk dropdown filter

        return view('admin', compact('aspirasis', 'kategoris'));
    }

    // Fungsi Admin memberikan feedback dan merubah status (Poin III di PDF)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'feedback' => 'nullable|string'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback
        ]);

        return redirect()->route('admin.index')->with('success', 'Status/Feedback berhasil diperbarui!');
    }
}