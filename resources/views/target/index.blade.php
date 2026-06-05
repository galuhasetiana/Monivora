@extends('layouts.app')

@section('title', 'Target Harian')

@push('styles')
<style>
    .target-wrapper {
        max-width: 820px;
        margin: 0 auto;
        padding-top: 10px;
    }

    /* ── FORM CARD ── */
    .target-card {
        background: #2B2B2B;
        border-radius: 22px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    /* Header gold */
    .target-card-header {
        background: #B87A3A;
        padding: 22px 30px;
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.5px;
    }

    /* Input area */
    .target-card-body {
        padding: 30px;
    }

    .input-nominal {
        width: 100%;
        padding: 18px 20px;
        background: #1e293b;
        border: none;
        border-radius: 14px;
        color: #fff;
        font-size: 18px;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: border 0.2s;
        border: 2px solid transparent;
    }

    .input-nominal:focus {
        border-color: #B87A3A;
    }

    .input-nominal::placeholder {
        color: #94a3b8;
    }

    .error-msg {
        color: #f87171;
        font-size: 13px;
        margin-top: 8px;
    }

    /* ── TOMBOL SIMPAN ── */
    .btn-simpan {
        display: block;
        width: 100%;
        max-width: 820px;
        margin: 0 auto;
        padding: 18px;
        background: #B87A3A;
        border: none;
        border-radius: 50px;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: 0.3s;
        letter-spacing: 0.5px;
    }

    .btn-simpan:hover {
        background: #a0692f;
        transform: translateY(-1px);
    }

    /* ── INFO TARGET AKTIF ── */
    .info-target {
        background: rgba(184,122,58,0.12);
        border: 1px solid rgba(184,122,58,0.3);
        border-radius: 14px;
        padding: 16px 22px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-target span { color: #94a3b8; font-size: 14px; }
    .info-target strong { color: #B87A3A; font-size: 18px; }

    /* ── ALERT ── */
    .alert-success {
        background: #14532d; color: #86efac;
        padding: 14px 20px; border-radius: 12px;
        margin-bottom: 20px; font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="target-wrapper">

    {{-- Flash success --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Info target yang sedang aktif --}}
    @if($targetHarian > 0)
        <div class="info-target">
            <span>Target harian saat ini</span>
            <strong>Rp {{ number_format($targetHarian, 0, ',', '.') }}</strong>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('target.simpan') }}">
        @csrf

        <div class="target-card">
            <div class="target-card-header">
                Nominal Target Per Hari
            </div>
            <div class="target-card-body">
                <input
                    type="number"
                    name="target_harian"
                    id="target_harian"
                    class="input-nominal"
                    placeholder="Rp 0"
                    value="{{ old('target_harian', $targetHarian > 0 ? $targetHarian : '') }}"
                    min="1000"
                    required>

                @error('target_harian')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-simpan">Simpan</button>
    </form>

</div>
@endsection

@push('scripts')
<script>
    // Format angka saat user mengetik (opsional — tampilkan Rp di placeholder)
    const input = document.getElementById('target_harian');

    input.addEventListener('focus', function () {
        this.placeholder = '0';
    });

    input.addEventListener('blur', function () {
        this.placeholder = 'Rp 0';
    });
</script>
@endpush