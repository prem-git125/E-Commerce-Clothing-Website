@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between">
        <h3>Products List</h3>
        <a href="{{ route('admin.product.create') }}" class="btn btn-outline-dark">Create
            Product</a>
    </div>

    <div class="col-12">
        <table id="datatable" class="table my-4" style="width:100%">
            <thead class="table-dark">
                <tr class="text-center">
                    <td>Name</td>
                    <td>Slug</td>
                    <td>Type</td>
                    <td>Actions</td>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('admin-scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.product.data') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render(data, type, row) {
                            let url = "{{ route('admin.product.edit', ':id') }}".replace(':id', data);
                            let urlDelete = "{{ route('admin.product.destroy', ':id') }}".replace(':id',
                                data);
                            return `
                            <a href="${url}" class="btn btn-sm btn-outline-primary editBtn">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="${urlDelete}" method="POST" class="deleteForm d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        `;
                        },
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10
            });

            $(document).on('submit', '.deleteForm', function(e) {
                e.preventDefault();
                let form = $(this);
                let deleteUrl = form.attr('action');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the product!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response?.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                table.ajax.reload(null, false);
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
