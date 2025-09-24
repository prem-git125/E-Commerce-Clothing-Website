@extends('layouts.admin')

@section('content')
    <h3>Edit Product</h3>
    <hr>
   
@endsection

@push('admin-scripts')
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('productDesc', {
            height: 200,
            removeButtons: 'PasteFromWord'
        });
    </script>
@endpush
