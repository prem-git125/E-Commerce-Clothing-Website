@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between">
        <h3>Categories List</h3>
        <a href="#" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#categoryModal">Create
            Category</a>

    </div>

    <div class="col-12">
        <table id="datatable" class="table my-4" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <td>Name</td>
                    <td>Slug</td>
                    <td>Actions</td>
                </tr>
            </thead>
        </table>
    </div>

    @include('components.admin.category.modal')

@endsection

@push('admin-scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.categories.data') }}",
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
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-outline-primary editBtn" data-id="${data}" data-name="${row.name}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form class="deleteForm d-inline" data-id="${data}">
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

            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                $('#categoryId').val(id);
                $('#categoryName').val(name);
                $('#modalLabel').text('Edit Category');
                $('#categoryModal').modal('show');
            })

            $(document).on('submit', '.deleteForm', function(e) {
                e.preventDefault();
                let form = $(this);
                let id = form.data('id');
                let url = "{{ route('admin.category.destroy', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                });
                                $('#datatable').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        })
    </script>
@endpush
