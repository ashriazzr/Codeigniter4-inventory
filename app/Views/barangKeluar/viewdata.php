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

<?= $this->endSection('isi'); ?>