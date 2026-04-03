@extends('layouts.app')

@section('content')
<div class="card shadow border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <span class="fw-bold text-primary"><i class="bi bi-person-badge"></i> Daftar Semua Aspirasi (Admin)</span>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-danger shadow-sm">Logout</a>
    </div>
    <div class="card-body">
        
        <!-- KODE BARU: Form Filter Kategori & Tanggal -->
        <div class="bg-light p-3 rounded mb-4 border">
            <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Filter Data Pengaduan</h6>
            <form action="{{ route('admin.index') }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <label class="small fw-bold">Pilih Kategori:</label>
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->ket_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Pilih Tanggal:</label>
                    <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-5 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-sm btn-primary px-4">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.index') }}" class="btn btn-sm btn-secondary px-4">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Info Pengirim</th>
                        <th>Detail Pengaduan & Bukti</th>
                        <th>Status</th>
                        <th style="width: 220px;">Aksi & Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspirasis as $a)
                    <tr>
                        <td>
                            Nama: <strong>{{ $a->nama }}</strong><br>
                            NIS: <small class="text-muted">{{ $a->nis }}</small><br>
                            Tgl: <small class="text-muted text-primary">{{ $a->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <strong>{{ $a->kategori->ket_kategori }}</strong> ({{ $a->lokasi }})<br>
                            <p class="mb-2 text-muted" style="font-size: 0.9rem;">{{ $a->ket }}</p>
                            
                            @if($a->foto)
                                <div class="mt-2">
                                    <label class="d-block small fw-bold text-dark">Foto Bukti:</label>
                                    <a href="{{ asset('uploads/' . $a->foto) }}" target="_blank">
                                        <img src="{{ asset('uploads/' . $a->foto) }}" width="100" class="img-thumbnail shadow-sm border-primary" alt="Bukti">
                                    </a>
                                    <br>
                                    <small class="text-info" style="font-size: 10px;">*Klik gambar untuk memperbesar</small>
                                </div>
                            @else
                                <span class="badge bg-light text-dark border fw-normal" style="font-size: 10px;">Tanpa Foto</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $a->status == 'Selesai' ? 'bg-success' : ($a->status == 'Proses' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.update', $a->id_aspirasi) }}" method="POST">
                                @csrf
                                <div class="mb-1">
                                    <label class="small fw-bold">Update Status:</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="Menunggu" {{ $a->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Proses" {{ $a->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ $a->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <label class="small fw-bold">Feedback:</label>
                                    <input type="text" name="feedback" class="form-control form-control-sm" placeholder="Isi feedback..." value="{{ $a->feedback }}">
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark w-100 shadow-sm mt-1">Update Data</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($aspirasis->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="bi bi-search d-block mb-2 shadow-sm" style="font-size: 2rem;"></i>
                            Data tidak ditemukan atau belum ada aspirasi yang masuk.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection