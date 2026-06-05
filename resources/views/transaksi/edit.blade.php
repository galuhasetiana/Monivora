@extends('layouts.app')

@section('title', 'Edit Transaksi')

@push('styles')
<style>
    .form-card {
        background:#2B2B2B; border-radius:22px;
        padding:35px; max-width:550px; margin:0 auto;
        box-shadow:0 10px 30px rgba(0,0,0,0.4);
    }
    .form-card h2 { margin-bottom:25px; font-size:22px; color:#cbd5e1; }
    .toggle-wrap { display:flex; gap:12px; margin-bottom:25px; }
    .toggle-btn {
        flex:1; padding:12px; border-radius:20px; border:2px solid #B87A3A;
        background:transparent; color:#B87A3A; font-size:15px;
        cursor:pointer; transition:0.3s; font-family:'Poppins',sans-serif;
    }
    .toggle-btn.active { background:#B87A3A; color:#fff; }
    .form-group { margin-bottom:20px; }
    .form-group label { display:block; font-size:13px; color:#94a3b8; margin-bottom:8px; }
    .form-group input, .form-group select {
        width:100%; padding:12px 15px; border-radius:12px;
        border:1px solid #3c3e43; background:#1e293b;
        color:#fff; font-size:15px; outline:none; font-family:'Poppins',sans-serif;
    }
    .form-group input:focus, .form-group select:focus { border-color:#B87A3A; }
    .error-msg { color:#f87171; font-size:12px; margin-top:4px; }
    .btn-submit {
        width:100%; padding:14px; border:none; border-radius:20px;
        background:#B87A3A; color:#fff; font-size:16px;
        cursor:pointer; margin-top:10px; transition:0.3s; font-family:'Poppins',sans-serif;
    }
    .btn-submit:hover { background:#a0692f; }
    .btn-back {
        display:inline-block; margin-bottom:20px; color:#94a3b8;
        text-decoration:none; font-size:14px;
    }
    .btn-back:hover { color:#fff; }
</style>
@endpush

@section('content')
<a href="{{ route('transaksi.index') }}" class="btn-back">← Kembali ke Riwayat</a>

<div class="form-card">
    <h2>Edit Transaksi</h2>

    <form method="POST" action="{{ route('transaksi.update', $transaksi->id) }}">
        @csrf
        @method('PUT')

        <div class="toggle-wrap">
            <button type="button" id="btnPemasukan"
                class="toggle-btn {{ old('jenis', $transaksi->jenis) === 'Pemasukan' ? 'active' : '' }}">
                Pemasukan
            </button>
            <button type="button" id="btnPengeluaran"
                class="toggle-btn {{ old('jenis', $transaksi->jenis) === 'Pengeluaran' ? 'active' : '' }}">
                Pengeluaran
            </button>
        </div>
        <input type="hidden" name="jenis" id="jenisInput"
               value="{{ old('jenis', $transaksi->jenis) }}">

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal"
                   value="{{ old('tanggal', $transaksi->tanggal->format('Y-m-d')) }}" required>
            @error('tanggal') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                @foreach(['Makanan & Minuman','Transport','Belanja','Hiburan','Tagihan','Kesehatan','Pendidikan','Lainnya'] as $kat)
                    <option value="{{ $kat }}"
                        {{ old('kategori', $transaksi->kategori) === $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="keterangan"
                   value="{{ old('keterangan', $transaksi->keterangan) }}" required>
            @error('keterangan') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Jumlah (Rp)</label>
            <input type="number" name="jumlah"
                   value="{{ old('jumlah', $transaksi->jumlah) }}" min="1" required>
            @error('jumlah') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-submit">Perbarui Transaksi</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
const btnPemasukan   = document.getElementById('btnPemasukan');
const btnPengeluaran = document.getElementById('btnPengeluaran');
const jenisInput     = document.getElementById('jenisInput');
btnPemasukan.onclick = () => {
    btnPemasukan.classList.add('active');
    btnPengeluaran.classList.remove('active');
    jenisInput.value = 'Pemasukan';
};
btnPengeluaran.onclick = () => {
    btnPengeluaran.classList.add('active');
    btnPemasukan.classList.remove('active');
    jenisInput.value = 'Pengeluaran';
};
</script>
@endpush
