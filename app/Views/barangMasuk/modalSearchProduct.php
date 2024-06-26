<div class="modal fade" id="modalSearchProduct" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Please search for product data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Please search for items by code or name" id="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="btnSearch"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="row viewdetaildata"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function searchDataProduct() {
        let search = $('#search').val();
        $.ajax({
            type: "post",
            url: "/barangMasuk/detailSearchProduct",
            data: {
                search: search
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewdetaildata').html('<i class=" fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.viewdetaildata').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    }
    $(document).ready(function() {
        $('#btnSearch').click(function(e) {
            e.preventDefault();
            searchDataProduct();

        });

        $('#search').keydown(function(e) {
            if (e.keyCode == '13') {
                e.preventDefault();
                searchDataProduct();
            }
        });
    });
</script>