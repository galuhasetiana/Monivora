@extends('layouts.app')

@section('title', 'Profil')

@push('styles')
<style>
    .profil-wrapper {
        max-width: 480px;
        margin: 0 auto;
        padding-top: 10px;
    }

    /* ── JUDUL ── */
    .profil-judul {
        text-align: center;
        font-size: 22px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 35px;
        letter-spacing: 1px;
    }

    /* ── FOTO PROFIL ── */
    .foto-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
    }

    .foto-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin-bottom: 18px;
        cursor: pointer;
    }

    .foto-profil {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #B87A3A;
        background: #1e293b;
    }

    /* Icon user default (SVG inline) */
    .foto-default {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #B87A3A;
        background: #1e293b;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .foto-default svg {
        width: 70px;
        height: 70px;
        stroke: #fff;
        fill: none;
        stroke-width: 1.5;
    }

    /* Overlay kamera saat hover */
    .foto-overlay {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 32px;
        height: 32px;
        background: #B87A3A;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.4);
    }

    .foto-overlay svg {
        width: 16px;
        height: 16px;
        stroke: #fff;
        fill: none;
        stroke-width: 2;
    }

    /* Input file tersembunyi */
    #inputFoto { display: none; }

    .nama-user {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        text-align: center;
    }

    .email-user {
        font-size: 13px;
        color: #94a3b8;
        text-align: center;
        margin-top: 4px;
    }

    /* ── DIVIDER ── */
    .divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.1);
        margin: 25px 0;
    }

    /* ── MENU CARD ── */
    .menu-card {
        background: #2B2B2B;
        border-radius: 22px;
        overflow: hidden;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px 24px;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        color: #fff;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .menu-item:last-child { border-bottom: none; }
    .menu-item:hover { background: rgba(184,122,58,0.15); }

    /* Icon bulat gold */
    .menu-icon-wrap {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #B87A3A;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
    }

    .menu-icon-wrap svg {
        width: 24px;
        height: 24px;
        stroke: #fff;
        fill: none;
        stroke-width: 1.8;
    }

    .menu-label {
        font-size: 16px;
        font-weight: 500;
    }

    /* Hapus data — warna merah */
    .menu-item.danger .menu-icon-wrap { background: #B87A3A; }
    .menu-item.danger .menu-label { color: #fff; }
    .menu-item.danger:hover { background: rgba(239,68,68,0.1); }
    .menu-item.danger:hover .menu-label { color: #f87171; }
    .menu-item.danger:hover .menu-icon-wrap { background: #ef4444; }
</style>
@endpush

@section('content')
<div class="profil-wrapper">

    <div class="profil-judul">Akun</div>

    {{-- ── FOTO & NAMA ── --}}
    <div class="foto-section">

        {{-- Form upload foto (submit otomatis saat pilih file) --}}
        <form method="POST" action="{{ route('profil.foto') }}"
              enctype="multipart/form-data" id="formFoto">
            @csrf
            <input type="file" name="foto" id="inputFoto"
                   accept="image/jpg,image/jpeg,image/png"
                   onchange="document.getElementById('formFoto').submit()">
        </form>

        {{-- Foto / default icon --}}
        <div class="foto-container" onclick="document.getElementById('inputFoto').click()">
            @if(auth()->user()->foto)
                <img src="{{ Storage::url(auth()->user()->foto) }}"
                     alt="Foto Profil" class="foto-profil">
            @else
                <div class="foto-default">
                    {{-- Icon user SVG --}}
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>
            @endif

            {{-- Tombol kamera --}}
            <div class="foto-overlay">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
            </div>
        </div>

        <div class="nama-user">{{ auth()->user()->name }}</div>
        <div class="email-user">{{ auth()->user()->email }}</div>

    </div>

    <hr class="divider">

    {{-- ── MENU ── --}}
    <div class="menu-card">

        {{-- Target Harian --}}
        <a href="#" class="menu-item">
            <div class="menu-icon-wrap">
                {{-- Icon target/circle --}}
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10"/>
                    <circle cx="12" cy="12" r="6"/>
                    <circle cx="12" cy="12" r="2"/>
                </svg>
            </div>
            <span class="menu-label">Target Harian</span>
        </a>

        {{-- Ekspor Data --}}
        <a href="{{ route('ekspor.index') }}" class="menu-item">
            <div class="menu-icon-wrap">
                {{-- Icon download --}}
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
            </div>
            <span class="menu-label">Ekspor Data</span>
        </a>

        {{-- Hapus Semua Data --}}
        <div class="menu-item danger" onclick="konfirmasiHapus()">
            <div class="menu-icon-wrap">
                {{-- Icon trash --}}
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>
            <span class="menu-label">Hapus Semua Data</span>
        </div>

    </div>

    {{-- Form hapus data (tersembunyi, di-submit lewat JS) --}}
    <form method="POST" action="{{ route('profil.hapusData') }}" id="formHapus">
        @csrf
        @method('DELETE')
    </form>

</div>
@endsection

@push('scripts')
<script>
function konfirmasiHapus() {
    if (confirm('Yakin ingin menghapus SEMUA data transaksi? Tindakan ini tidak bisa dibatalkan.')) {
        document.getElementById('formHapus').submit();
    }
}
</script>
@endpush
