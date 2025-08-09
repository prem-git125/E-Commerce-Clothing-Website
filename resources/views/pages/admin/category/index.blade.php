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
                    <td></td>
                </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="categoryName" value="{{ old('name') }}" placeholder="Category Name">
                            @error('name')
                                <span class="invalid-feedback d-block small error-name">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
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

            // $('#datatable').DataTable({
            //     processing: true,
            //     serverSide: true,
            // });
        })
    </script>
@endpush
