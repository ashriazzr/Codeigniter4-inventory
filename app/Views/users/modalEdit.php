<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('users/update', ['class' => 'frmsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="iduser">ID User</label>
                    <input type="text" class="form-control" id="iduser" name="iduser" placeholder="ID User" autocomplete="off" value="<?= $iduser; ?>" readonly="true">
                    <div class="invalid-feedback" id="msg-iduser"></div>
                </div>
                <div class="form-group">
                    <label for="namalengkap">Nama Lengkap</label>
                    <input type="text" name="namalengkap" id="namalengkap" class="form-control" autocomplete="off" value="<?= $namalengkap; ?>">
                </div>
                <div class="form-group">
                    <label for="level">Level User</label>
                    <select name="level" id="level" class="form-control form-control-sm">
                        <option value="">-Pilih-</option>
                        <?php foreach ($datalevel->getResultArray() as $x) : ?>
                            <?php if ($level == $x['levelid']) : ?>
                                <option selected value="<?= $x['levelid'] ?>"><?= $x['levelnama']; ?></option>
                            <?php else :  ?>
                                <option value="<?= $x['levelid'] ?>"><?= $x['levelnama']; ?></option>
                            <?php endif;  ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Status User</label>
                    <input type="checkbox" id="status" name="status" <?= ($status == '1') ? 'checked' : ''; ?> data-toggle="toggle" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger" data-width="150" class="chStatus">
                </div>
                <div class="form-group viewResetPassword" style="display: none;">
                    <label for="">Password Baru Anda :</label>
                    <br>
                    <h3 class=passReset></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-purple btnreset">
                        <i class="fa fa-recycle">Reset Password</i>
                    </button>
                    <button type="button" class="btn btn-danger btnhapus">
                        <i class="fa fa-trash-alt">Hapus</i>
                    </button>
                    <button type="submit" class="btn btn-success btnsimpan">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btnreset').click(function(e) {
                e.preventDefault();
                let iduser = $('#iduser').val();
                Swal.fire({
                    title: "Reset Password",
                    html: `Yakin iduser <strong>${iduser}</strong> ingin Reset Password ?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, reset!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "/users/resetPassword",
                            data: {
                                iduser: iduser
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success == '') {
                                    $('.viewResetPassword').show();
                                    $('.passReset').html(response.passwordBaru);
                                }
                            }
                        });
                    }
                });
            });

            $('.btnhapus').click(function(e) {
                e.preventDefault();
                let iduser = $('#iduser').val();
                Swal.fire({
                    title: "Hapus user",
                    html: `Yakin iduser <strong>${iduser}</strong> ini dihapus ?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "/users/hapus",
                            data: {
                                iduser: iduser
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.success,
                                    }).then(() => {
                                        location.reload(); // Reload the page immediately after deletion
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $('.chStatus').change(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/users/updateStatus",
                    data: {
                        iduser: $('#iduser').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == '') {
                            dataUser.ajax.reload();
                        }
                    }
                });
            });

            $('form.frmsimpan').submit(function(e) {
                e.preventDefault();

                // Ensure status is included in form data
                var status = $('#status').is(':checked') ? '1' : '0';

                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize() + '&status=' + status,
                    dataType: "json",
                    cache: false,
                    beforeSend: function() {
                        $('.btnsimpan').prop('disabled', true);
                        $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.btnsimpan').prop('disabled', false);
                        $('.btnsimpan').html('Update');
                    },
                    success: function(response) {
                        if (response.success) {
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