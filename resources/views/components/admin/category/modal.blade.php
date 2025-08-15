<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Create Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="categoryId">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" id="categoryName"
                            placeholder="Category Name">

                        <span class="invalid-feedback d-block small error-name"></span>
                    </div>

                    <div class="mb-3">
                        <input type="file" name="img" class="form-control" id="categoryImg"
                            placeholder="Category Image">

                        <span class="invalid-feedback d-block small error-img"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary closeBtn">Close</button>
                    <button type="submit" class="btn btn-outline-dark">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('admin-scripts')
    <script>
        $(document).on('submit', '#categoryForm', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let category_id = $('#categoryId').val();

            let url = category_id ? "{{ route('admin.category.update', ':id') }}".replace(':id',
                    category_id) :
                "{{ route('admin.category.store') }}";

            let method = category_id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    console.log(response.message);
                    $('#categoryModal').modal('hide');
                    $('#categoryForm')[0].reset();
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function(xhr, error) {
                    let errors = xhr.responseJSON.errors;
                    $('.error-name').text(errors.name[0]);
                    $('.error-img').text(errors.img ? errors.img[0] : '');
                }
            });
        })

        $(document).on('click', '.closeBtn', function() {
            $('#categoryModal').modal('hide');
            $('#categoryForm')[0].reset();
            $('#categoryId').val('');
            $('#modalLabel').text('Create Category');
            $('.error-name').text('');
            $('.error-img').text('');
        })
    </script>
@endpush
