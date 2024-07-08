<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Welcome to Inventory System
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
Data Inventory
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="col-lg-8">
    <div class="card text-white bg-primary mb-3">
        <div class="card-header">Laporan Grafik</div>
        <div class="card-body bg-white">
            <div class="form-group">
                <label for="">Choose Month</label>
                <input type="month" class="form-control" value="<?= date('Y-m') ?>" name="" id="bulan">
                <button type="button" class="btn btn-sm btn-primary" id="buttonShow">
                    Show
                </button>
            </div>
            <div class="viewTampilGrafik"></div>
        </div>
    </div>
    <script>
        function tampilGrafik() {
            $.ajax({
                type: "post",
                url: "/laporan/tampilGrafikBarangMasuk",
                data: {
                    bulan: $('#bulan').val()
                },
                dataType: "json",
                beforeSend: function() {
                    $('.viewTampilGrafik').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function(response) {
                    if (response.data) {
                        $('.viewTampilGrafik').html(response.data);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }


        $(document).ready(function() {
            tampilGrafik();
            $('#buttonShow').click(function(e) {
                e.preventDefault();
                tampilGrafik();
            });
        });
    </script>
    <?= $this->endSection('isi'); ?>