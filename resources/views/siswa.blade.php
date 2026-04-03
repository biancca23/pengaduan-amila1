@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Form Input Aspirasi -->
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white fw-bold text-primary">Input Aspirasi</div>
                <div class="card-body">
                    <!-- PENTING: Tambahkan enctype untuk upload foto -->
                    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="number" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                        </div>
                        <!-- INPUT NAMA/USERNAME YANG BARU -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Misal: Kelas 12 RPL"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto (Opsional)</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Pengaduan</label>
                            <textarea name="ket" class="form-control" rows="3" required
                                placeholder="Jelaskan detail masalah..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">Kirim Aspirasi</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Histori Aspirasi Siswa -->
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white fw-bold">Histori Aspirasi</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama / NIS</th>
                                    <th>Kategori</th>
                                    <th>Bukti Foto</th> <!-- Tambahkan baris ini -->
                                    <th>Status</th>
                                    <th>Feedback Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspirasis as $a)
                                    <tr>
                                        <td class="text-center">#{{ $a->id_aspirasi }}</td>
                                        <td>
                                            <strong>{{ $a->nama }}</strong><br>
                                            <small class="text-muted">{{ $a->nis }}</small>
                                        </td>
                                        <td>{{ $a->kategori->ket_kategori }}</td>

                                        <!-- KOLOM UNTUK MENAMPILKAN FOTO -->
                                        <td class="text-center">
                                            @if($a->foto)
                                                <a href="{{ asset('uploads/' . $a->foto) }}" target="_blank">
                                                    <img src="{{ asset('uploads/' . $a->foto) }}" width="50" height="50"
                                                        class="img-thumbnail" alt="Bukti">
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <span
                                                class="badge {{ $a->status == 'Selesai' ? 'bg-success' : ($a->status == 'Proses' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                                {{ $a->status }}
                                            </span>
                                        </td>
                                        <td>{{ $a->feedback ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection