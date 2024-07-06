<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Data Report Transaction Incoming Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-warning" onclick="window.location('/laporan/index')">back</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card text-white bg-primary mb-3" >
            <div class="card-header">Choose Period</div>
            <div class="card-body bg-white">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">
                <div class="form-group"></div>
                </p>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection('isi'); ?>