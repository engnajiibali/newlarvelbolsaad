<!DOCTYPE html>
<html>
<head>
    <title>Faahfaahinta Keydin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .table th { background: #f8f9fa; }
        .badge { font-size: 0.9em; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <h4 class="card-header">
            <i class="fa fa-info-circle"></i> Faahfaahinta Hubka
        </h4>
        <div class="card-body">

            <!-- Info guud -->
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $keydin->keydin_ID }}</td>
                </tr>
                <tr>
                    <th>Xaalada</th>
                    <td>
                        @if($keydin->keydin_Xalada == 0)
                            <span class="badge bg-secondary">La keydiyay</span>
                        @else
                            <span class="badge bg-success">Firfircoon</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Taariikhda</th>
                    <td>{{ $keydin->keydin_CreateDate }}</td>
                </tr>
                <tr>
                    <th>Fadhiga</th>
                    <td>{{ $keydin->FadhiIdRelation->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Qaybta Hubka</th>
                    <td>{{ $keydin->QaybtaHubkaRelation->ItemName ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Lambarka Taxanaha</th>
                    <td>{{ $keydin->keydin_lambarka1 }}</td>
                </tr>
                <tr>
                    <th>Calamada Dawlada</th>
                    <td>{{ $keydin->Calamaden }}</td>
                </tr>
                <tr>
                    <th>Lahansho</th>
                    <td>{{ $keydin->Lahansho }}</td>
                </tr>
                <tr>
                    <th>Shaqeyn Kara</th>
                    <td>
                        {{ $keydin->ShaqeynKara == 1 ? 'Wuu shaqeynaya' : 'Ma shaqeynayo' }}
                    </td>
                </tr>
                <tr>
                    <th>Faahfaahin</th>
                    <td>{{ $keydin->Describ }}</td>
                </tr>
            </table>

            <!-- Sawirada -->
            <h5 class="mt-4">Sawirada Hubka</h5>
            <div class="d-flex flex-wrap">
                @if($keydin->keydin_image1)
                    @foreach(explode(',', $keydin->keydin_image1) as $img)
                        @php $imageUrl = Storage::disk('s3')->url($img); @endphp
                        <img src="{{ $imageUrl }}" class="img-thumbnail me-2 mb-2" style="max-height:120px;">
                    @endforeach
                @else
                    <p><i>No images uploaded.</i></p>
                @endif
            </div>

            <!-- Assignhub records -->
            <h5 class="mt-4">Assignhub Records (Status = 1)</h5>
            <p>Total Found: {{ $assignhubs->count() }}</p>

            @if($assignhubs->count())
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Askari ID</th>
                            <th>Item ID</th>
                            <th>Qori Number</th>
                            <th>Create Date</th>
                            <th>Update Date</th>
                            <th>Finish Date</th>
                            <th>Store ID</th>
                            <th>Sharaxaad</th>
                            <th>Sawirka</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignhubs as $assign)
                            <tr>
                                <td>{{ $assign->assignhubId }}</td>
                                <td>{{ $assign->AskariId }}</td>
                                <td>{{ $assign->ItemId }}</td>
                                <td>{{ $assign->QoriNumber }}</td>
                                <td>{{ $assign->CreateDate }}</td>
                                <td>{{ $assign->UpdateDate }}</td>
                                <td>{{ $assign->FinishDate }}</td>
                                <td>{{ $assign->StoreId }}</td>
                                <td>{{ $assign->descrip }}</td>
                                <td>
                                    @if($assign->sawirka)
                                        <img src="{{ Storage::disk('s3')->url($assign->sawirka) }}" 
                                             style="max-height:80px;" class="img-thumbnail">
                                    @else
                                        <i>No Image</i>
                                    @endif
                                </td>
                                <td>
                                    @if($assign->Status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p><i>No Assignhub records found with Status = 1</i></p>
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
