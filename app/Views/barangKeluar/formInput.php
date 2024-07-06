<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Input Transaction Outgoing Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/barangKeluar/data')">
    <i class=" fa fa-backward"></i> Back
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">No. Invoice</label>
            <input type="text" name="nofaktur" class="form-control" id="nofaktur" value="<?= $nofaktur ?>" readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">Date Invoice</label>
            <input type="date" name="tglfaktur" class="form-control" id="tglfaktur" value="<?= date('d-m-Y') ?>">
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="">Search Customer</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Customer Name" name="namecustomer" id="namecustomer" readonly>
                <input type="hidden" name="idcustomer" id="idcustomer">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="buttonSearchCustomer" title="Search Customer"><i class="fa fa-search"></i></button>
                    <button class="btn btn-outline-success" type="button" id="buttonAddCustomer" title="Add Customer"><i class="fa fa-plus-square"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Code Product</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="codeproduct" id="codeproduct">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="buttonSearchProduct" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Name Product</label>
            <input type="text" name="nameproduct" id="nameproduct" class="form-control" readonly>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Seilling Price (Rp)</label>
            <input type="text" name="sellprice" id="sellprice" class="form-control" readonly>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Qty</label>
            <input type="number" name="jml" id="jml" class="form-control" value="1">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">#</label>
            <div class="input-group mb-3">
                <button type="button" class="btn btn-success" title="Save item" id="buttonSaveItem">
                    <i class="fa fa-save"></i>
                </button>&nbsp;
                <button type="button" class="btn btn-info" title="End Transaction" id="buttonEndTransaction">End Transaction</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 showDataTemp">

    </div>
</div>
<div class="viewmodal" style="display:none;"></div>
<script>
    function kosong() {
        $('#codeproduct').val('');
        $('#sellprice').val('');
        $('#nameproduct').val('');
        $('#jml').val('0');
        $('#codeproduct').focus();


    }

    function saveItem() {
        let nofaktur = $('#nofaktur').val();
        let codeproduct = $('#codeproduct').val();
        let nameproduct = $('#nameproduct').val();
        let sellprice = $('#sellprice').val();
        let jml = $('#jml').val();
        $('#codeproduct').focus();

        if (codeproduct.length == 0) {
            Swal.fire('Error', 'Product code must be entered', 'error');
            kosong();
        } else {
            $.ajax({
                type: "post",
                url: "/barangkeluar/saveItem",
                data: {
                    nofaktur: nofaktur,
                    codeproduct: codeproduct,
                    nameproduct: nameproduct,
                    sellprice: sellprice,
                    jml: jml
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error');
                        kosong();
                    }
                    if (response.success) {
                        Swal.fire('success', response.success, 'success');
                        showDataTemp();
                        kosong();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    }

    function ambilDataProduct() {
        let codeproduct = $('#codeproduct').val();
        if (codeproduct.length == 0) {
            Swal.fire('Error', 'Product code must be entered', 'error');
            kosong();
        } else {
            $.ajax({
                type: "post",
                url: "/barangKeluar/ambilDataProduct",
                data: {
                    codeproduct: codeproduct
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error');
                        kosong();
                    }
                    if (response.success) {
                        let data = response.success;
                        $('#nameproduct').val(data.nameproduct);
                        $('#sellprice').val(data.sellprice);
                        $('#jml').focus();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    }

    function showDataTemp() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/showDataTemp",
            data: {
                nofaktur: nofaktur
            },
            dataType: "json",
            beforeSend: function() {
                $('.showDataTemp').html("<i class='fa fa-spin fa-spinner'></i>");
            },
            success: function(response) {
                if (response.data) {
                    $('.showDataTemp').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function buatNoFaktur() {
        let tanggal = $('#tglfaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/buatNoFaktur",
            data: {
                tanggal: tanggal
            },
            dataType: "json",
            success: function(response) {
                $('#nofaktur').val(response.nofaktur);
                showDataTemp();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        showDataTemp();
        $('#tglfaktur').change(function(e) {
            buatNoFaktur();
        });

        $('#buttonAddCustomer').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/pelanggan/formTambah",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalAddCustomer').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#buttonSearchCustomer').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/pelanggan/modalData",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalDataCustomer').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#codeproduct').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                ambilDataProduct();
            }
        });

        $('#buttonSaveItem').click(function(e) {
            e.preventDefault();
            saveItem();
        });
        $('#buttonSearchProduct').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/barangKeluar/modalSearchProduct",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalSearchProduct').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#buttonEndTransaction').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/barangkeluar/modalPayment",
                data: {
                    nofaktur: $('#nofaktur').val(),
                    tglfaktur: $('#tglfaktur').val(),
                    idcustomer: $('#idcustomer').val(),
                    totalprice: $('#totalprice').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire('error', response.error, 'error');
                    }

                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalPayment').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

        });
    });
</script>

<?= $this->endSection('isi'); ?>