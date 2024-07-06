<div class="modal fade" id="modalPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Payment Facture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('barangkeluar/savePayment', ['class' => 'frmpembayaran']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">No. Facture</label>
                    <input type="text" name="nofaktur" id="nofaktur" class="form-control" value="<?= $nofaktur; ?>" readonly>
                    <input type="hidden" name="tglfaktur" value="<?= $tglfaktur; ?>">
                    <input type="hidden" name="idcustomer" value="<?= $idcustomer; ?>">
                </div>
                <div class="form-group">
                    <label for="">Total Price</label>
                    <input type="text" name="totalpayment" id="totalpayment" class="form-control" value="<?= $totalprice; ?>" readonly>

                </div>
                <div class="form-group">
                    <label for="">Amount Payment</label>
                    <input type="text" name="jumlahuang" id="jumlahuang" class="form-control" autocomplete="false">
                </div>
                <div class="form-group">
                    <label for="">Amount Balance</label>
                    <input type="text" name="sisauang" id="sisauang" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsave">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
</div>

<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#totalpayment').autoNumeric('init', {
            mDec: 0, //desimal
            aDec: ',',
            aSep: '.',
        });
        $('#jumlahuang').autoNumeric('init', {
            mDec: 0, //desimal
            aDec: ',',
            aSep: '.',
        });
        $('#sisauang').autoNumeric('init', {
            mDec: 0, //desimal
            aDec: ',',
            aSep: '.',
        });

        $('#jumlahuang').keyup(function(e) {
            let totalpayment = $('#totalpayment').autoNumeric('get');
            let jumlahuang = $('#jumlahuang').autoNumeric('get');

            let sisauang;

            if (parseInt(jumlahuang) < parseInt(totalpayment)) {
                sisauang = 'kurang';
            } else if (parseInt(jumlahuang) == parseInt(totalpayment)) {
                sisauang = 'balance';
            } else {
                sisauang = parseInt(jumlahuang) - parseInt(totalpayment);
            }

            if (sisauang === 'balance') {
                $('#sisauang').val('balance');
            } else if (sisauang === 'kurang') {
                $('#sisauang').val('Minus');
            } else {
                $('#sisauang').autoNumeric('set', sisauang);
            }
        });

        $('.frmpembayaran').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.btnsave').prop('disabled', true);
                    $('.btnsave').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsave').prop('disabled', false);
                    $('.btnsave').html('Save');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Print Invoice",
                            text: response.success + " ,Print Invoice?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, Print it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let windowPrint = window.open(response.printfaktur, "Print Invoice Outgoing Transaction", "width=200,height=400");

                                windowPrint.focus();
                                window.location.reload();
                            } else {
                                window.location.reload();

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