@extends('layouts.app')

@section('title', 'Ekspor Data')

@push('styles')
<style>
    .export-box { max-width:500px; margin:40px auto 0; }
    .export-box h2 { margin-bottom:25px; color:#cbd5e1; font-size:22px; }

    .input-box {
        background:#2B2B2B; padding:20px; border-radius:18px;
        margin-bottom:20px; display:flex;
        justify-content:space-between; align-items:center;
    }
    .input-box span { color:#cbd5e1; font-size:14px; }
    .input-box input {
        background:transparent; border:none; color:#fff;
        outline:none; font-size:14px; font-family:'Poppins',sans-serif;
    }
    .error-msg { color:#f87171; font-size:12px; margin:-15px 0 15px 5px; }

    .export-actions { display:flex; justify-content:center; gap:40px; margin-top:40px; }
    .btn-export {
        background:transparent; border:none; color:#B87A3A;
        font-size:18px; cursor:pointer; transition:0.3s;
        font-family:'Poppins',sans-serif;
    }
    .btn-export:hover { color:#d4a15a; }
</style>
@endpush

@section('content')
<div class="export-box">
    <h2>Ekspor Data Transaksi</h2>

    @error('start') <div class="error-msg">{{ $message }}</div> @enderror
    @error('end')   <div class="error-msg">{{ $message }}</div> @enderror

    {{-- FORM PDF --}}
    <form method="POST" action="{{ route('ekspor.pdf') }}" id="formPdf">
        @csrf
        <div class="input-box">
            <span>Waktu Mulai</span>
            <input type="date" name="start" id="startDate"
                   value="{{ old('start') }}" required>
        </div>
        <div class="input-box">
            <span>Waktu Selesai</span>
            <input type="date" name="end" id="endDate"
                   value="{{ old('end') }}" required>
        </div>
    </form>

    {{-- FORM EXCEL (pakai field yang sama) --}}
    <form method="POST" action="{{ route('ekspor.excel') }}" id="formExcel">
        @csrf
        <input type="hidden" name="start" id="startExcel">
        <input type="hidden" name="end"   id="endExcel">
    </form>

    <div class="export-actions">
        <button class="btn-export" onclick="submitPdf()">Ekspor PDF</button>
        <button class="btn-export" onclick="submitExcel()">Ekspor Excel</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function submitPdf() {
    document.getElementById('formPdf').submit();
}
function submitExcel() {
    document.getElementById('startExcel').value = document.getElementById('startDate').value;
    document.getElementById('endExcel').value   = document.getElementById('endDate').value;
    document.getElementById('formExcel').submit();
}
</script>
@endpush
