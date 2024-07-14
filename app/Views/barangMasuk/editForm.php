<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Edit Transaksi Barang Masuk
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/barangMasuk/data')">
    <i class=" fa fa-arrow-left"></i> Kembali
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<form action="/barangMasuk/update" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="porder" value="<?= $barang['porder'] ?>">

    <div class="form-group">
        <label for="tglporder">Tanggal porder</label>
        <input type="date" class="form-control" id="tglporder" name="tglporder" value="<?= $barang['tglporder'] ?>" required>
    </div>

    <div class="form-group">
        <label for="totalharga">Total Harga</label>
        <input type="text" class="form-control" id="totalharga" name="totalharga" value="<?= $barang['totalharga'] ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
<?= $this->endSection('isi'); ?>
