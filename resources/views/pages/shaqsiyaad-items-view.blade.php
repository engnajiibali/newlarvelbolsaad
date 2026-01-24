@extends('layouts.app')

@section('title', 'Shaqsiyaadka & Keydin Viewer')

@section('content')
<div class="card shadow-lg">
    <h2 class="card-header bg-primary text-white"><i class="fa-solid fa-eye"></i> Shaqsiyaadka & Keydin Viewer</h2>
    <div class="card-body">
        <div class="row mb-4">
            <!-- Shaqsiyaadka Select -->
            <div class="col-md-6">
                <label for="shaqsiSelect" class="form-label">Select Shaqsiyaad</label>
                <select id="shaqsiSelect" class="form-control select2" style="width:100%"></select>
            </div>

            <!-- Keydin Select -->
            <div class="col-md-6">
                <label for="keydinSelect" class="form-label">Select Keydin</label>
                <select id="keydinSelect" class="form-control select2" style="width:100%"></select>
            </div>
        </div>

        <div class="row">
            <!-- Shaqsiyaad Details -->
            <div class="col-md-6">
                <div class="card border-info mb-3 shadow-sm">
                    <div class="card-header bg-info text-white"><i class="fa fa-user"></i> Shaqsiyaad Details</div>
                    <div class="card-body" id="shaqsiDetails">
                        <p class="text-muted text-center">Select a Shaqsi to view details...</p>
                    </div>
                </div>
            </div>

            <!-- Keydin Details -->
            <div class="col-md-6">
                <div class="card border-success mb-3 shadow-sm">
                    <div class="card-header bg-success text-white"><i class="fa fa-box"></i> Keydin Details</div>
                    <div class="card-body" id="keydinDetails">
                        <p class="text-muted text-center">Select a Keydin to view details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Shaqsiyaadka Select2
    $('#shaqsiSelect').select2({
        placeholder: 'Search Shaqsiyaad...',
        ajax: {
            url: "{{ route('shaqsiyaadka.search') }}",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(obj => ({ id: obj.ShaqsiyaadkaId, text: obj.magacaShaqsiga }))
            }),
            cache: true
        }
    });

    // Keydin Select2
    $('#keydinSelect').select2({
        placeholder: 'Search Keydin...',
        ajax: {
            url: "{{ route('keydin.search') }}",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(obj => ({ id: obj.id, text: obj.keydin_lambarka1 }))
            }),
            cache: true
        }
    });

    // Show Shaqsiyaad Details
    $('#shaqsiSelect').on('change', function () {
        const id = $(this).val();
        if(id){
            $.get("{{ url('shaqsiyaadka') }}/" + id, function(data){
                let html = `
                    <div class="text-center mb-3">
                        ${data.SawirkaShaqsiga ? `<img src="/${data.SawirkaShaqsiga}" class="img-fluid rounded-circle shadow" width="130" height="130">` : `<i class="fa fa-user-circle fa-5x text-muted"></i>`}
                    </div>
                    <h5 class="text-center">${data.magacaShaqsiga}</h5>
                    <p class="text-center text-muted">${data.Jagada ?? '—'}</p>
                    <hr>
                    <p><strong>Talefan:</strong> ${data.TalefanLambarka ?? '—'}</p>
                    <p><strong>Address:</strong> ${data.Addresska ?? '—'}</p>
                    <p><strong>Faahfaahin:</strong> ${data.Description ?? '—'}</p>
                    ${data.KaarkaShaqsiga ? `<a href="/${data.KaarkaShaqsiga}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fa fa-id-card"></i> View Kaarka Shaqsiga</a>` : ''}
                `;
                $('#shaqsiDetails').html(html);
            });
        }
    });

    // Show Keydin Details
    $('#keydinSelect').on('change', function () {
        const id = $(this).val();
        if(id){
            $.get("{{ url('keydin') }}/" + id, function(data){
                let html = `
                    <h5><i class="fa fa-box"></i> ${data.keydin_lambarka1}</h5>
                    <p><strong>Name:</strong> ${data.name ?? '—'}</p>
                    <p><strong>Fadhi:</strong> ${data.FadhiIdRelation?.name ?? '—'}</p>
                    <p><strong>Qaybta Hubka:</strong> ${data.QaybtaHubkaRelation?.name ?? '—'}</p>
                    <p><strong>Description:</strong> ${data.description ?? '—'}</p>
                `;
                $('#keydinDetails').html(html);
            });
        }
    });

});
</script>
@endpush
