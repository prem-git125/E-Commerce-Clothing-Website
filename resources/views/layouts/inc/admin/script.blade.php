<!-- Jquery -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#select2').select2({
            placeholder: "Select Sizes",
            allowClear: true,
            width: '100%'
        });
    });

    $(document).ready(function() {
    let sizesSelected = [];

    $('#select2').change(function() {
        let selected = $(this).val() || [];
        let container = $('#priceStockContainer');

        container.find('.size-input').each(function() {
            let sizeId = $(this).data('size-id').toString();
            if (!selected.includes(sizeId)) {
                $(this).remove();
                sizesSelected = sizesSelected.filter(id => id !== sizeId);
            }
        });

        selected.forEach(function(sizeId) {
            if (!sizesSelected.includes(sizeId)) {
                sizesSelected.push(sizeId);
                let sizeName = $('#size_id option[value="' + sizeId + '"]').text();
                let html = `
                    <div class="size-input mb-3" data-size-id="${sizeId}">
                        <h5>${sizeName}</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Price</label>
                                <input type="number" name="prices[${sizeId}]" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stocks[${sizeId}]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                `;
                container.append(html);
            }
        });
    });
});
</script>
