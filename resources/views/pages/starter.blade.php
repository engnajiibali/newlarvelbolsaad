@extends('layouts.admin')

@section('content')

{{-- ================= STYLES ================= --}}
<style>
    body { background: #f4f6f9; }

    .card {
        border-radius: 16px;
        transition: .3s ease;
    }
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0,0,0,.15);
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        background: rgba(13,110,253,.15);
    }

    .count {
        font-weight: 800;
        letter-spacing: 1px;
    }

    .chart-card {
        border-left: 5px solid #0d6efd;
    }
</style>

<h3 class="fw-bold text-primary mb-4">📊 Warbixin Kooban – Dashboard</h3>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="row g-3 mb-4">
@php
$cards = [
    ['Fadhiyada', $fadhiyada, 'building', 'primary'],
    ['Waxyaha', $totalItems, 'box', 'success'],
    ['Qandaraasyada', $Keydin, 'file-contract', 'warning'],
    ['Hubka Mas\'uuliyiinta', $shaqsiyadka, 'shield-alt', 'danger'],
];
@endphp

@foreach($cards as [$title,$count,$icon,$color])
<div class="col-md-3">
    <div class="card text-center p-4 bg-light">
        <div class="icon-wrapper mb-2">
            <i class="fas fa-{{ $icon }} fa-2x text-{{ $color }}"></i>
        </div>
        <h6 class="fw-semibold">{{ $title }}</h6>
        <h2 class="count" data-target="{{ $count }}">0</h2>
    </div>
</div>
@endforeach
</div>

{{-- ================= SECOND ROW ================= --}}
<div class="row g-3 mb-4">
@php
$cards2 = [
    ['Askarta', $Askari, 'user-tie', 'primary'],
    ['Shaya', $totalItems, 'boxes', 'success'],
    ['Isticmaaleyaal', 32, 'users', 'warning'],
    ['Maqasin', 8, 'warehouse', 'danger'],
];
@endphp

@foreach($cards2 as [$title,$count,$icon,$color])
<div class="col-md-3">
    <div class="card text-center p-4 bg-light">
        <div class="icon-wrapper mb-2">
            <i class="fas fa-{{ $icon }} fa-2x text-{{ $color }}"></i>
        </div>
        <h6 class="fw-semibold">{{ $title }}</h6>
        <h2 class="count" data-target="{{ $count }}">0</h2>
    </div>
</div>
@endforeach
</div>

{{-- ================= THIRD ROW ================= --}}
<div class="row g-3 mb-4">
<div class="col-md-3">
    <div class="card text-center p-4 bg-light">
        <div class="icon-wrapper mb-2">
            <i class="fas fa-gun fa-2x text-primary"></i>
        </div>
        <h6 class="fw-semibold">Hubka Guud</h6>
        <h2 class="count" data-target="{{ $KeydinItems->sum('Count') }}">0</h2>
    </div>
</div>

@foreach($xaladaLabels as $value => $label)
<div class="col-md-3">
    <div class="card text-center p-4 bg-light">
        <div class="icon-wrapper mb-2">
            <i class="fas fa-clipboard-list fa-2x text-primary"></i>
        </div>
        <h6 class="fw-semibold">{{ $label }}</h6>
        <h2 class="count" data-target="{{ $xaladaCounts[$value] ?? 0 }}">0</h2>
    </div>
</div>
@endforeach
</div>

{{-- ================= CHARTS ================= --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card chart-card p-4">
            <h6 class="text-center fw-semibold">🚔 Tirada Hubka ee Xaladahooda</h6>
            <canvas id="carStatusChart" height="220"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card chart-card p-4">
            <h6 class="text-center fw-semibold">🔑 Xaaladda Guud ee Hubka</h6>
            <canvas id="ownershipChart" height="220"></canvas>
        </div>
    </div>
</div>

<div class="card chart-card p-4 mb-4">
    <h6 class="text-center fw-semibold">📦 Tirada Hubka ee Keydin kasta</h6>
    <canvas id="itemsKeydinChart" height="260"></canvas>
</div>

<small class="text-muted d-block text-end">
    🕒 Last updated: {{ now()->format('d M Y - H:i') }}
</small>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
/* ===== COUNTER ===== */
document.querySelectorAll('.count').forEach(el=>{
    const target=+el.dataset.target;
    let i=0, step=target/40;
    (function animate(){
        if(i<target){ i+=step; el.innerText=Math.floor(i); requestAnimationFrame(animate); }
        else el.innerText=target;
    })();
});

/* ===== DATA ===== */
const carStatusData=@json($carStatusData);
const ownershipData=@json($ownershipData);
const keydinItems=@json($KeydinItems->pluck('Count'));
const keydinLabels=@json($KeydinItems->pluck('ItemName'));

const xLabels={1:"Baxay",2:"Yala",3:"Lumay",4:"Burbur",5:"Baafin",6:"La Qabtay"};
const colors={1:"#0d6efd",2:"#198754",3:"#ffc107",4:"#dc3545",5:"#6f42c1",6:"#fd7e14"};

/* ===== BAR STATUS ===== */
new Chart(carStatusChart,{
    type:'bar',
    data:{
        labels:Object.keys(carStatusData).map(k=>xLabels[k]),
        datasets:[{
            data:Object.values(carStatusData),
            backgroundColor:Object.keys(carStatusData).map(k=>colors[k]),
            borderRadius:8
        }]
    },
    options:{
        plugins:{ legend:false, datalabels:{anchor:'end',align:'top',font:{weight:'bold'}}},
        scales:{ y:{beginAtZero:true}}
    },
    plugins:[ChartDataLabels]
});

/* ===== DOUGHNUT ===== */
new Chart(ownershipChart,{
    type:'doughnut',
    data:{
        labels:['Yala','Baxay','Shaqsiyaad'],
        datasets:[{data:Object.values(ownershipData),backgroundColor:['#0d6efd','#ffc107','#198754']}]
    }
});

/* ===== KEYDIN ===== */
new Chart(itemsKeydinChart,{
    type:'bar',
    data:{
        labels:keydinLabels,
        datasets:[{
            data:keydinItems,
            backgroundColor:'#0d6efd',
            borderRadius:8
        }]
    },
    options:{
        plugins:{ datalabels:{anchor:'end',align:'top',font:{weight:'bold'}}},
        scales:{ y:{beginAtZero:true}}
    },
    plugins:[ChartDataLabels]
});
</script>

@endsection
