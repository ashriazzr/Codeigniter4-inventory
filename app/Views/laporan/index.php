<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Report<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
Data Report Transaction
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 50px;">
                <i class="fa fa-file fa-3x mb-3"></i>
                <h5 class="card-title text-center">Report Incoming Goods</h5>
            </div>
            <button type="button" class="btn btn-lg btn-light text-primary w-100" onclick="window.location=('/laporan/cetak-barang-masuk')">
                View Report
            </button>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card text-white bg-success h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 50px;">
                <i class="fa fa-file fa-3x mb-3"></i>
                <h5 class="card-title text-center">Report Outgoing Goods</h5>
            </div>
            <button type="button" class="btn btn-lg btn-light text-success w-100" onclick="window.location=('/laporan/cetak-barang-keluar')">
                View Report
            </button>
        </div>
    </div>
</div>
<?= $this->endSection('isi'); ?>