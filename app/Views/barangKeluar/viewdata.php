

<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Data Transaction Outgoing Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/barangKeluar/input')">
    <i class=" fa fa-plus-circle"></i> Add Transaction
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="row">
    <div class="col">
        <table>Filter Data</table>
    </div>
    <div class="col">
        <input type="date" name="tglawal" id="tglawal" class="form-control">
    </div>
    <div class="col">
        <input type="date" name="tglakhir" id="tglakhir" class="form-control">
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-primary" id="buttonShow">Show</button>
    </div>
</div><br>

<table style="width: 100%;" id="databarangkeluar" class="table table-bordered table-hover dataTable dtr-inline collapsed">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Date</th>
            <th>Name Customer</th>
            <th>Total price (Rp)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<script>
    function listDataBarangkeluar() {
        var table = $('#databarangkeluar').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/barangkeluar/listData",
                "type": "POST",
                "data": {
                    tglawal: $('#tglawal').val(),
                    tglakhir: $('#tglakhir').val(),

                }
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }, ],
        });
    }

    $(document).ready(function() {
        listDataBarangkeluar();

        $('#buttonShow').click(function(e) {
            e.preventDefault();
            listDataBarangkeluar();

        });
    });

    function print(faktur) {
        let windowPrint = window.open('/barangkeluar/printFaktur/' + faktur, "Print Invoice Outgoing Transaction", "width=200,height=400");

        windowPrint.focus();
    }

    function hapus(faktur) {
        Swal.fire({
            title: "Delete Transaction",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/deleteTransaction",
                    data: {
                        faktur: faktur,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            listDataBarangkeluar();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        });
    }

    function edit(faktur) {
        window.location.href = ('/barangkeluar/edit/') + faktur;
    }
</script>
<?= $this->endSection('isi'); ?>