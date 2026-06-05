@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .grid { display:flex; gap:25px; }
    .left { flex:2; }
    .right { width:420px; max-height:80vh; overflow-y:auto; }

    .card {
        background:#232634; border-radius:22px;
        padding:25px; margin-bottom:25px;
        box-shadow:0 10px 30px rgba(0,0,0,0.4);
    }
    .card h3 { font-weight:500; margin-bottom:15px; color:#cbd5e1; }

    .balance { font-size:44px; font-weight:600; margin-bottom:20px; }
    .row { display:flex; justify-content:space-between; }
    .small { font-size:14px; color:#94a3b8; }
    .income { color:#fff; }
    .expense { color:#B87A3A; font-weight:bold; }

    .chart-wrapper { display:flex; justify-content:center; align-items:center; height:200px; }

    .trans-header { display:flex; justify-content:space-between; margin-bottom:15px; }
    .lihat { font-size:13px; color:#cbd5e1; cursor:pointer; text-decoration:none; }
    .hari { font-size:14px; margin-bottom:15px; color:#cbd5e1; }

    .trans-item {
        background:linear-gradient(90deg,#22214c,#22214c);
        padding:14px 18px; border-radius:30px;
        margin-bottom:12px; display:flex;
        justify-content:space-between; align-items:center;
    }
    .trans-left { display:flex; gap:10px; align-items:center; }
    .icon-box {
        width:36px; height:36px; border-radius:10px;
        background:#3c3e43; display:flex;
        justify-content:center; align-items:center; color:#B87A3A;
    }
    .icon-img { width:20px; height:20px; object-fit:contain; }
    .trans-title { font-size:14px; }
    .trans-sub { font-size:12px; color:#94a3b8; }
    .amount { color:#fff; font-weight:bold; }
    .amount.minus { color:#B87A3A; }
    .action-wrapper { position:relative; display:flex; align-items:center; gap:10px; }
    .action-btn { cursor:pointer; font-size:20px; padding:5px 10px; border-radius:8px; }
    .action-btn:hover { background:rgba(255,255,255,0.1); }
    .dropdown {
        position:absolute; right:0; top:30px;
        background:#1e293b; border-radius:10px;
        overflow:hidden; display:none; min-width:120px; z-index:10;
    }
    .dropdown a, .dropdown button {
        display:block; width:100%; padding:10px;
        border:none; background:none; color:#fff;
        text-align:left; cursor:pointer; text-decoration:none; font-size:14px;
    }
    .dropdown a:hover, .dropdown button:hover { background:#B87A3A; }
    .amount.minus { color:#B87A3A; }
</style>
@endpush

@section('content')
<div class="grid">

    {{-- KIRI --}}
    <div class="left">

        {{-- SALDO --}}
        <div class="card">
            <h3>Total Saldo</h3>
            <div class="balance">Rp {{ number_format($saldo, 2, ',', '.') }}</div>
            <div class="row">
                <div>
                    <div class="small">Pemasukan</div>
                    <div class="income">Rp {{ number_format($pemasukan, 2, ',', '.') }}</div>
                </div>
                <div>
                    <div class="small">Pengeluaran</div>
                    <div class="expense">- Rp {{ number_format($pengeluaran, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- TARGET HARIAN --}}
        <div class="card">
            <h3>Target Hari Ini</h3>
            <div class="chart-wrapper">
                <canvas id="donutChart" width="150" height="150"></canvas>
            </div>
            <div class="small" style="text-align:center;margin-top:10px">
                Kamu sudah mengeluarkan {{ $persenTarget }}% dari target hari ini
            </div>
        </div>

    </div>

    {{-- KANAN — TRANSAKSI TERBARU --}}
    <div class="right">
        <div class="trans-header">
            <h3>Transaksi Terbaru</h3>
            <a href="{{ route('transaksi.index') }}" class="lihat">Lihat Semua</a>
        </div>

        @forelse($transaksiTerbaru as $t)
            <div class="trans-item">
                <div class="trans-left">
                    <div class="icon-box">
                        <img src="{{ asset('images/F&B.png') }}" alt="" class="icon-img">
                    </div>
                    <div>
                        <div class="trans-title">{{ $t->jenis }}</div>
                        <div class="trans-sub">{{ $t->keterangan }}</div>
                    </div>
                </div>

                <div class="action-wrapper">
                    <span class="amount {{ $t->jenis === 'Pengeluaran' ? 'minus' : '' }}">
                        {{ $t->jenis === 'Pemasukan' ? '+' : '-' }}
                        Rp {{ number_format($t->jumlah, 2, ',', '.') }}
                    </span>

                    <div class="action-btn" onclick="toggleMenu(this)">⋮</div>

                    <div class="dropdown">
                        <a href="{{ route('transaksi.edit', $t->id) }}">Edit</a>
                        <form method="POST" action="{{ route('transaksi.destroy', $t->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Hapus transaksi ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="color:#94a3b8;font-size:14px;">Belum ada transaksi.</p>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Terpakai', 'Sisa'],
        datasets: [{
            data: [{{ $persenTarget }}, {{ 100 - $persenTarget }}],
            backgroundColor: ['#B87A3A', '#e5e7eb'],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '70%',
        plugins: { legend: { display: false } }
    }
});
document.addEventListener('click', function(e) {
    if (!e.target.closest('.action-wrapper')) {
        document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');
    }
});

function toggleMenu(btn) {
    const dropdown = btn.nextElementSibling;
    const isOpen = dropdown.style.display === 'block';
    document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');
    dropdown.style.display = isOpen ? 'none' : 'block';
}
</script>
@endpush
