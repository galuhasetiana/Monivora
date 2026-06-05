@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@push('styles')
<style>
    .chart-card {
        background:#2B2B2B; border-radius:20px;
        padding:25px; margin-bottom:30px;
    }
    .chart-card h3 { margin-bottom:15px; color:#cbd5e1; }

    .section-title { margin-bottom:10px; font-size:14px; color:#cbd5e1; }

    .trans-item {
        background:linear-gradient(90deg,#22214c,#22214c);
        padding:18px; border-radius:30px;
        margin-bottom:15px; display:flex;
        justify-content:space-between; align-items:center;
    }
    .trans-left { display:flex; gap:15px; align-items:center; }
    .icon-box {
        width:45px; height:45px; border-radius:12px;
        background:#3c3e43; display:flex;
        justify-content:center; align-items:center;
    }
    .icon-img { width:24px; }
    .trans-title { font-size:15px; }
    .trans-sub { font-size:12px; color:#94a3b8; }
    .amount { font-weight:bold; color:#fff; }
    .amount.minus { color:#B87A3A; }

    /* Dropdown aksi */
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
</style>
@endpush

@section('content')

{{-- CHART MINGGUAN --}}
<div class="chart-card">
    <h3>Aktivitas Minggu Ini</h3>
    <canvas id="lineChart"></canvas>
</div>

{{-- DAFTAR TRANSAKSI --}}
@forelse($transaksi as $hari => $items)
    <div class="section-title">{{ $hari }}</div>

    @foreach($items as $t)
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
                Rp {{ number_format($t->jumlah, 0, ',', '.') }}
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
    @endforeach
@empty
    <p style="color:#94a3b8;text-align:center;margin-top:40px;">Belum ada riwayat transaksi.</p>
@endforelse

@endsection

@push('scripts')
<script>
// Tutup dropdown saat klik di luar
document.addEventListener('click', function(e) {
    if (!e.target.closest('.action-wrapper')) {
        document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');
    }
});

function toggleMenu(btn) {
    const dropdown = btn.nextElementSibling;
    const isOpen   = dropdown.style.display === 'block';
    document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');
    dropdown.style.display = isOpen ? 'none' : 'block';
}

// Chart
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Pemasukan',
                data: @json($pemasukan),
                borderColor: '#d4a057',
                backgroundColor: 'rgba(212,160,87,0.1)',
                tension: 0.4, fill: true
            },
            {
                label: 'Pengeluaran',
                data: @json($pengeluaran),
                borderColor: '#B87A3A',
                backgroundColor: 'rgba(184,122,58,0.1)',
                tension: 0.4, fill: true
            }
        ]
    },
    options: {
        plugins: { legend: { labels: { color:'#fff' } } },
        scales: {
            x: { ticks: { color:'#fff' } },
            y: { ticks: { color:'#fff' }, beginAtZero: true }
        }
    }
});
</script>
@endpush
