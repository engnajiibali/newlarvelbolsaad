@extends('layouts.admin')

@section('content')

<style>
    /* ===== POLICE BLUE MODERN THEME ===== */
    .card {
        border-radius: 14px;
        transition: 0.3s ease;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        background: rgba(13, 110, 253, 0.12);
    }

    /* Counter Number */
    .count {
        font-weight: bold;
    }
</style>

<h3 class="text-primary fw-bold mb-4">📊 Warbixin Kooban – Dashboard</h3>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="row g-3 mb-3">

    {{-- Fadhiyada --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-center p-4 bg-light">
            <div class="icon-wrapper mb-2">
                <i class="fas fa-building fa-2x text-primary"></i>
            </div>
            <h5 class="fw-semibold">Tirada Fadhiyad</h5>
            <h2 class="count" data-target="{{ $fadhiyada }}">0</h2>
        </div>
    </div>

    {{-- Waxyaha --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-center p-4 bg-light">
            <div class="icon-wrapper mb-2">
                <i class="fas fa-box fa-2x text-success"></i>
            </div>
            <h5 class="fw-semibold">Tirada Waxyaha</h5>
            <h2 class="count" data-target="{{ $totalItems }}">0</h2>
        </div>
    </div>

    {{-- Qandaraasyada --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-center p-4 bg-light">
            <div class="icon-wrapper mb-2">
                <i class="fas fa-file-contract fa-2x text-warning"></i>
            </div>
            <h5 class="fw-semibold">Tirada Qandaraasyada</h5>
            <h2 class="count" data-target="{{ $Keydin }}">0</h2>
        </div>
    </div>

    {{-- Hubka Mas'uuliyiinta --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-center p-4 bg-light">
            <div class="icon-wrapper mb-2">
                <i class="fas fa-shield-alt fa-2x text-danger"></i>
            </div>
            <h5 class="fw-semibold">Hubka Mas'uuliyiinta</h5>
            <h2 class="count" data-target="{{ $shaqsiyadka }}">0</h2>
        </div>
    </div>
</div>

{{-- ================= SECOND ROW ================= --}}
<div class="row g-3 mb-3">

    {{-- Askarta --}}
    <div class="col-md-3">
        <div class="card text-center p-4 bg-light">
            <div class="icon-wrapper mb-2"><i class="fas fa-user-tie fa-2x text-primary"></i></div>
            <h5 class="fw-semibold">Tirada Askarta</h5>
            <h2 class="count" data-target="{{ $Askari }}">0</h2>
        </div>
    </div>

    {{-- Shaya --}}
    <div class="col-md-3">
        <div class="card text-center p-4 bg-light">
            <div class="icon-wrapper mb-2"><i class="fas fa-boxes fa-2x text-success"></i></div>
            <h5 class="fw-semibold">Tirada Shaya</h5>
            <h2 class="count" data-target="{{ $totalItems }}">0</h2>
        </div>
    </div>

    {{-- Users --}}
    <div class="col-md-3">
        <div class="card text-center p-4 bg-light">
            <div class="icon-wrapper mb-2"><i class="fas fa-users fa-2x text-warning"></i></div>
            <h5 class="fw-semibold">Isticmaaleyaal</h5>
            <h2 class="count" data-target="32">0</h2>
        </div>
    </div>

    {{-- Maqasin --}}
    <div class="col-md-3">
        <div class="card text-center p-4 bg-light">
            <div class="icon-wrapper mb-2"><i class="fas fa-warehouse fa-2x text-danger"></i></div>
            <h5 class="fw-semibold">Maqasinka</h5>
            <h2 class="count" data-target="8">0</h2>
        </div>
    </div>

</div>

{{-- ================= THIRD ROW ================= --}}
<div class="row g-3 mb-3">

    {{-- Hubka Guud --}}
    <div class="col-md-3">
        <div class="card p-4 text-center bg-light">
            <div class="icon-wrapper mb-2"><i class="fas fa-gun fa-2x text-primary"></i></div>
            <h5 class="fw-semibold">Hubka Guud</h5>
            <h2 class="count" data-target="{{ $KeydinItems->sum('Count') }}">0</h2>
        </div>
    </div>

    {{-- Dynamic Xaalada Labels --}}
    @foreach($xaladaLabels as $value => $label)
        @php
            $count = $xaladaCounts[$value] ?? 0;
        @endphp

        <div class="col-md-3">
            <div class="card p-4 text-center bg-light">
                <div class="icon-wrapper mb-2">
                    <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                </div>
                <h5 class="fw-semibold">{{ $label }}</h5>
                <h2 class="count" data-target="{{ $count }}">0</h2>
            </div>
        </div>
    @endforeach
</div>

<hr>

{{-- ====================== CHARTS ====================== --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-4 shadow-sm">
            <h5 class="text-center fw-semibold">🚘 Tirada Hubka ee Xaladahooda</h5>
            <canvas id="carStatusChart" height="200"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 shadow-sm">
            <h5 class="text-center fw-semibold">🔑 Xaaladda Guud ee Hubka</h5>
            <canvas id="ownershipChart" height="100"></canvas>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 p-4 mb-4">
    <h5 class="text-center fw-semibold">📦 Tirada Hubka ee Keydin kasta</h5>
    <canvas id="itemsKeydinChart" height="200"></canvas>
</div>

{{-- ====================== SCRIPTS ====================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ===== COUNTER ANIMATION =====
    document.querySelectorAll('.count').forEach(el => {
        const target = +el.getAttribute('data-target');
        let value = 0;
        const speed = target / 40;

        const update = () => {
            if (value < target) {
                value += speed;
                el.innerText = Math.floor(value);
                requestAnimationFrame(update);
            } else {
                el.innerText = target;
            }
        };
        update();
    });

    document.addEventListener('DOMContentLoaded', function() {

        const carStatusData = @json($carStatusData);
        const ownershipData = @json($ownershipData);
        const keydinItems = @json($KeydinItems->pluck('Count'));
        const keydinLabels = @json($KeydinItems->pluck('ItemName'));

   const xLabels = {
    1: "Hubka Baxay",
    2: "Hubka Yala",
    3: "Lumay",
    4: "La burburiyay",
    5: "Baafin",
    6: "La Qabtay"
};

// Assign a unique color to each Xaalada
const colors = {
    1: '#0d6efd', // Baxay - Blue
    2: '#198754', // Yala - Green
    3: '#ffc107', // Lumay - Yellow
    4: '#dc3545', // La burburiyay - Red
    5: '#6f42c1', // Baafin - Purple
    6: '#fd7e14'  // La Qabtay - Orange
};

// ===== CAR STATUS CHART =====
new Chart(document.getElementById('carStatusChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(carStatusData).map(k => xLabels[k] ?? k),
        datasets: [{
            label: 'Tirada',
            data: Object.values(carStatusData),
            backgroundColor: Object.keys(carStatusData).map(k => colors[k] ?? '#999'),
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

        // ===== OWNERSHIP CHART =====
        new Chart(document.getElementById('ownershipChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(ownershipData).map(k => k == 0 ? 'Yala' : 'Baxay' ),
                datasets: [{
                    data: Object.values(ownershipData),
                    backgroundColor: ['#0d6efd','#ffc107']
                }]
            }
        });

        // ===== KEYDIN ITEMS CHART =====
        new Chart(document.getElementById('itemsKeydinChart'), {
            type: 'bar',
            data: {
                labels: keydinLabels,
                datasets: [{
                    label: 'Tirada',
                    data: keydinItems,
                    backgroundColor: keydinItems.map(c => c>0?'#0d6efd':'#dc3545'),
                    borderRadius: 6
                }]
            }
        });

    });
</script>

@endsection
