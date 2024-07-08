<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Data Report Transaction Outgoing Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/laporan/index')">
    <i class=" fa fa-backward"></i> Back
</button><?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Choose Period</div>
            <div class="card-body bg-white">
                <p class="card-text">
                    <?= form_open('laporan/print-product-outgoing-period', ['target' => '_blank']) ?>
                <div class="form-group">
                    <label for="">First Date</label>
                    <input type="date" name="firstDate" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Last Date</label>
                    <input type="date" name="lastDate" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-success"><i class="fa fa-print"></i> Print Report</button>
                </div>
                <?= form_close(); ?>
                </p>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection('isi'); ?>