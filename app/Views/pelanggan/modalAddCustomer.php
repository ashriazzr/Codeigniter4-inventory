<div class="modal fade" id="modalAddCustomer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('Pelanggan/save', ['class' => 'formSave']) ?>
                <div class="form-group">
                    <label for="namecust">Input Name Customer</label>
                    <input type="text" name="namecust" id="namecust" class="form-control">
                    <div class="invalid-feedback errorNameCustomer">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telp">Contact Number</label>
                    <input type="text" name="telp" id="telp" class="form-control">
                    <div class="invalid-feedback errorTelp">
                    </div>
                </div>
                <div class="form-group">
                    <label for="savebutton"></label>
                    <button type="submit" class="btn btn-block btn-success" id="savebutton" name="savebutton"> Save </button>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.formSave').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#savebutton').prop('disabled', true);
                    $('#savebutton').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#savebutton').prop('disabled', false);
                    $('#savebutton').html('Save');
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;
                        if (err.errNameCustomer) {
                            $('#namecust').addClass('is-invalid');
                            $('.errorNameCustomer').html(err.errNameCustomer);
                        }

                        if (err.errTelp) {
                            $('#telp').addClass('is-invalid');
                            $('.errorTelp').html(err.errTelp);
                        }
                    }

                    if (response.success) {
                        Swal.fire({
                            title: "Success",
                            text: response.success,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#namecustomer').val(response.namecustomer);
                                $('#idcustomer').val(response.idcustomer);
                                $('#modalAddCustomer').modal('hide');
                            } else {
                                $('#modalAddCustomer').modal('hide');

                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
            return false;
        });
    });
</script>