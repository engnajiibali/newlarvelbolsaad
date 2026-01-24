@extends('layouts.admin')

@section('title', 'Liiska Hubka ')

@section('content')
<div class="card">
    <h2 class="card-header"><i class="fa fa-warehouse"></i> Liiska Hubka </h2>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-success btn-sm" href="{{ route('keydin.create') }}">
                <i class="fa fa-plus"></i> Kudar Hub Cususb 
            </a>
        </div>

        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>NocaHubka</th>
                    <th>Fadhiga</th>
                    <th>Lambarka1</th>
                    <th>Lahansho</th>
                    <th>Status</th>
                    <th>Tarikhda</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
   

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('keydin.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: true },
            {
                data: 'keydin_image1',
                name: 'keydin_image1',
                orderable: false,
                searchable: false,
                render: function(data) {
                    if (!data) return '<span class="text-muted">No Image</span>';
                    return `<img src="${data}" class="img-thumbnail">`;
                }
            },
            { data: 'qaybta_hubka', name: 'qaybta_hubka' },
            { data: 'fadhiga', name: 'fadhiga' },
            { data: 'keydin_lambarka1', name: 'keydin_lambarka1' },
            { data: 'Lahansho', name: 'Lahansho' },
            { data: 'keydin_Xalada', name: 'keydin_Xalada' },
            { 
                data: 'keydin_CreateDate', 
                name: 'keydin_CreateDate',
                render: function(data) {
                    return data 
                        ? `<span class="text-truncate d-inline-block" style="max-width:150px;">${data}</span>`
                        : '<span class="text-muted">No Description</span>';
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Delete confirmation
    $('body').on('click', '.deleteKeydin', function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('keydin') }}/" + id,
                    success: function(){
                        table.draw();
                        Swal.fire('Deleted!','Keydin deleted','success');
                    },
                    error: function(){
                        Swal.fire('Error!','Something went wrong','error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
