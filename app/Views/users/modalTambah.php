<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('users/simpan', ['class' => 'frmsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="iduser">ID User</label>
                    <input type="text" class="form-control" id="iduser" name="iduser" placeholder="ID User" autocomplete="off" required>
                    <div class="invalid-feedback" id="msg-iduser"></div>
                </div>
                <div class="form-group">
                    <label for="namalengkap">Nama Lengkap</label>
                    <input type="text" name="namalengkap" id="namalengkap" class="form-control" autocomplete="off" required>
                    <div class="invalid-feedback" id="msg-namalengkap"></div>
                </div>
                <div class="form-group">
                    <label for="level">Level User</label>
                    <select name="level" id="level" class="form-control form-control-sm">
                        <option value="" selected>-Pilih-</option>
                        <?php foreach ($datalevel->getResultArray() as $x) : ?>
                            <option value="<?= $x['levelid'] ?>"><?= $x['levelnama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback" id="msg-level"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('form.frmsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $('.btnsimpan').prop('disabled', true);
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpan').prop('disabled', false);
                    $('.btnsimpan').html('Save');
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;
                        if (err.iduser) {
                            $('#iduser').addClass('is-invalid');
                            $('#msg-iduser').html(err.iduser);
                        } else {
                            $('#iduser').removeClass('is-invalid');
                            $('#iduser').addClass('is-valid');
                            $('#msg-iduser').html('');
                        }
                        if (err.namalengkap) {
                            $('#namalengkap').addClass('is-invalid');
                            $('#msg-namalengkap').html(err.namalengkap);
                        } else {
                            $('#namalengkap').removeClass('is-invalid');
                            $('#namalengkap').addClass('is-valid');
                            $('#msg-namalengkap').html('');
                        }
                        if (err.level) {
                            $('#level').addClass('is-invalid');
                            $('#msg-level').html(err.level);
                        } else {
                            $('#level').removeClass('is-invalid');
                            $('#level').addClass('is-valid');
                            $('#msg-level').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Reload the page
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