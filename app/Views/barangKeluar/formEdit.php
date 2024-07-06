<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Edit Transaction Outgoing Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/barangKeluar/data')">
    <i class=" fa fa-backward"></i> Back
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<style>
    table#datadetail tbody tr:hover {
        cursor: pointer;
        background-color: palevioletred;
        color: #fff;
    }
</style>

<table class="table table-striped table-sm">
    <tr>
        <input type="hidden" name="" id="nofaktur" value="<?= $nofaktur; ?>">
        <td style="width: 20%;">No. Invoice</td>
        <td style="width: 2%;">:</td>
        <td style="width: 28%;"><?= $nofaktur; ?></td>
        <td rowspan="3" style="width: 50%; font-weight:bold; text-align:center; vertical-align:middle; color:red; font-size:20pt;" id="lbTotalPrice">
        </td>
    </tr>
    <tr>
        <td>Date</td>
        <td>:</td>
        <td><?= $tanggal; ?></td>
    </tr>
    <tr>
        <td>Name Customer</td>
        <td>:</td>
        <td><?= $namecustomer; ?></td>
    </tr>
</table>
<div class="row mt-4">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Code Product</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="codeproduct" id="codeproduct">
                <input type="hidden" id="iddetail">
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
                <button type="button" style="display:none;" class="btn btn-primary" title="Edit Item" id="tombolEditItem"><i class="fa fa-edit"></i></button>&nbsp;
                <button type="button" style="display:none;" class="btn btn-default" title="Cancel" id="tombolBatal"><i class="fa fa-sync-alt"></i></button>


            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 showDataDetail">

    </div>
</div>
<div class="viewmodal" style="display:none;"></div>
<script>
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

    function ambilTotalPrice() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/ambilTotalPrice",
            data: {
                nofaktur: nofaktur
            },
            dataType: "json",
            success: function(response) {
                $('#lbTotalPrice').html(response.totalprice);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function kosong() {
        $('#codeproduct').val('');
        $('#sellprice').val('');
        $('#nameproduct').val('');
        $('#jml').val('0');
        $('#codeproduct').focus();
    }

    function showDataDetail() {
        let faktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/showDataDetail",
            data: {
                nofaktur: faktur
            },
            dataType: "json",
            beforeSend: function() {
                $('.showDataDetail').html("<i class='fa fa-spin fa-spinner'></i>");
            },
            success: function(response) {
                if (response.data) {
                    $('.showDataDetail').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
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
                url: "/barangkeluar/saveItemDetail",
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
                        showDataDetail();
                        ambilTotalPrice();
                        kosong();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    }

    $(document).ready(function() {
        ambilTotalPrice();
        showDataDetail();

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

        $('#tombolEditItem').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/barangkeluar/editItem",
                data: {
                    iddetail: $('#iddetail').val(),
                    'jml': $('#jml').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            'icon': 'success',
                            'title': 'Success',
                            'text': response.success
                        });
                        showDataDetail();
                        ambilTotalPrice();
                        kosong();
                        $('#codeproduct').prop('readonly', false);
                        $('#buttonSearchProduct').prop('disabled', false);
                        $('#buttonSaveItem').fadeIn();
                        $('#tombolEditItem').fadeOut();
                        $('#tombolBatal').fadeOut();
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