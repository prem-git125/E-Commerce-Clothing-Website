@extends('layouts.admin')

@section('content')
    <div class="col-12">
        <h3>Users List</h3>
    </div>
    <div class="col-12">
        <table id="datatable" class="table my-4" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Role</td>
                    <td>Status</td>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('admin-scripts')
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'status', name: 'status' },
        ],
        order: [[0, 'desc']],
        pageLength: 10
    });
});
</script>
@endpush

