<!-- <?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Edit Transaction Incoming Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<a href="<?= base_url('barangMasuk/index'); ?>" class="btn btn-secondary btn-sm">Back</a>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<?= form_open('barangMasuk/updateFaktur') ?>
<div class="form-group">
    <label for="faktur">Facture</label>
    <input type="text" class="form-control" id="faktur" name="faktur" value="<?= $barangMasuk['faktur'] ?>" readonly>
</div>
<div class="form-group">
    <label for="tglfaktur">Date</label>
    <input type="date" class="form-control" id="tglfaktur" name="tglfaktur" value="<?= $barangMasuk['tglfaktur'] ?>">
</div>
<div class="form-group">
    <label for="totalharga">Total Price (Rp)</label>
    <input type="number" class="form-control" id="totalharga" name="totalharga" value="<?= $barangMasuk['totalharga'] ?>">
</div>
<button type="submit" class="btn btn-primary">Save Changes</button>
<?= form_close(); ?>

<h5 class="mt-4">Detail Items</h5>
<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Code</th>
            <th>Name</th>
            <th>Buy Price (Rp)</th>
            <th>Sell Price (Rp)</th>
            <th>Qty</th>
            <th>Subtotal (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detailBarangMasuk as $index => $item) : ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $item['detbrgkode'] ?></td>
                <td><?= $item['brgnama'] ?></td>
                <td><?= $item['dethargamasuk'] ?></td>
                <td><?= $item['dethargajual'] ?></td>
                <td><?= $item['detjml'] ?></td>
                <td><?= $item['detsubtotal'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection('isi'); ?> -->
