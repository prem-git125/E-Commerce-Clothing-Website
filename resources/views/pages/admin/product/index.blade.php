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
                    <td>Price</td>
                    <td>Type</td>
                    <td>Stock</td>
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

            $('#datatable').DataTable({
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
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render(data, type, row) {
                           let url = "{{ route('admin.product.edit', ':id') }}".replace(':id', data);
                            return `
                                <a href="${url}" class="btn btn-sm btn-outline-primary editBtn">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
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
        })
    </script>
@endpush
