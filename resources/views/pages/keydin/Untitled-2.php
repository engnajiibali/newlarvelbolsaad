<!DOCTYPE html>
<html>
<head>
    <title>Faahfaahinta Keydin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .badge { font-size: 0.9em; }
        .img-thumbnail { max-height: 120px; margin-right: 10px; margin-bottom: 10px; }
        .card-header { background-color: #0d6efd; color: #fff; font-weight: bold; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .section-title { font-size: 1.2em; font-weight: 600; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <h4 class="card-header">
            <i class="fa fa-info-circle"></i> Faahfaahinta Hubka
        </h4>
        <div class="card-body">

            <!-- Keydin Info -->
            <div class="section-title">Keydin Info</div>
            <p><strong>ID:</strong> {{ $keydin->keydin_ID }}</p>
            <p><strong>Xaalada:</strong> 
                @if($keydin->keydin_Xalada == 0)
                    <span class="badge bg-secondary">La keydiyay</span>
                @else
                    <span class="badge bg-success">Firfircoon</span>
                @endif
            </p>
            <p><strong>Taariikhda:</strong> {{ $keydin->keydin_CreateDate }}</p>
            <p><strong>Fadhiga:</strong> {{ $keydin->FadhiIdRelation->name ?? '-' }}</p>
            <p><strong>Qaybta Hubka:</strong> {{ $keydin->QaybtaHubkaRelation->ItemName ?? '-' }}</p>
            <p><strong>Lambarka Taxanaha:</strong> {{ $keydin->keydin_lambarka1 }}</p>
            <p><strong>Calamada Dawlada:</strong> {{ $keydin->Calamaden }}</p>
            <p><strong>Lahansho:</strong> {{ $keydin->Lahansho }}</p>
            <p><strong>Shaqeyn Kara:</strong> {{ $keydin->ShaqeynKara == 1 ? 'Wuu shaqeynaya' : 'Ma shaqeynayo' }}</p>
            <p><strong>Faahfaahin:</strong> {{ $keydin->Describ }}</p>

            <!-- Sawirada -->
            <div class="section-title">Sawirada Hubka</div>
            <div class="d-flex flex-wrap">
                @if($keydin->keydin_image1)
                    @foreach(explode(',', $keydin->keydin_image1) as $img)
                        @php $imageUrl = Storage::disk('s3')->url($img); @endphp
                        <img src="{{ $imageUrl }}" class="img-thumbnail">
                    @endforeach
                @else
                    <p><i>No images uploaded.</i></p>
                @endif
            </div>

            <!-- Last Record -->
            <div class="section-title">Last Record</div>
            @if($lastRecord)
                @if($keydin->keydin_Xalada == 0)
                    <!-- AssignHubToStore -->
                    <p><strong>AssignHubToStore ID:</strong> {{ $lastRecord->ashtst_ID }}</p>
                    <p><strong>Store:</strong> {{ $lastRecord->store->name ?? 'N/A' }}</p>
                    <p><strong>Qori Number:</strong> {{ $lastRecord->QoriNum }}</p>
                    <p><strong>Create Date:</strong> {{ $lastRecord->CreateDate }}</p>
                    <p><strong>Finish Date:</strong> {{ $lastRecord->ashtst_FinishDate }}</p>
                    <p><strong>Status:</strong>
                        @if($lastRecord->ashtst_Status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>
                @else
                    <!-- Assignhub -->
                    <p><strong>Assignhub ID:</strong> {{ $lastRecord->assignhubId }}</p>
                    <p><strong>Askari:</strong> {{ $lastRecord->askari->MagacaQofka ?? 'N/A' }}</p>
                    <p><strong>Item:</strong> {{ $lastRecord->item->ItemName ?? 'N/A' }}</p>
                    <p><strong>Qori Number:</strong> {{ $lastRecord->QoriNumber }}</p>
                    <p><strong>Create Date:</strong> {{ $lastRecord->CreateDate }}</p>
                    <p><strong>Finish Date:</strong> {{ $lastRecord->FinishDate }}</p>
                    <p><strong>Status:</strong>
                        @if($lastRecord->Status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>
                    @if($lastRecord->sawirka)
                        <p><strong>Sawirka:</strong></p>
                        <img src="{{ Storage::disk('s3')->url($lastRecord->sawirka) }}" class="img-thumbnail" style="max-height:150px;">
                    @endif
                @endif
            @else
                <p><i>No record found.</i></p>
            @endif

            <div class="mt-3">
                <a href="{{ route('keydin.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

        </div>
    </div>
</div>
</body>
</html>
