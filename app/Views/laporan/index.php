<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Report<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
Data Report Transaction
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-block btn-lg btn-success" onclick="window.location=('/laporan/cetak-barang-masuk')" style="padding-top: 50px; padding-bottom: 50px;"><i class="fa fa-file"></i> Report Incoming Goods
        </button>
    </div>
    <div class="col-lg-4">

    </div>
    <div class="col-lg-4">

    </div>
</div>
<?= $this->endSection('isi'); ?>