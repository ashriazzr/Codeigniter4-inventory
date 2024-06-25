<?= $this->extend('main/layout'); ?>



<?= $this->section('judul'); ?>
Management Data product
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/product/addProduct')">
    <i class=" fa fa-plus-circle"></i>Add Product
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('success'); ?>
<?= form_open('product/index') ?>

<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search data with code, Name Product & Category" name="search" autofocus value="<?= $search ?>">

    <button class="btn btn-outline-success" type="submit" name="searchbutton"><i class="fa fa-search"></i></button>
</div>
<?= form_close(); ?>
<span class="badge badge-success">
    <h5>
        <?= "Total Data : $totalData"; ?>
    </h5>
</span>
<br>
<table class="table table-striped table-bordered table-hover" style="width:100%;">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Stock</th>
            <th style="width: 15%;">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 10);
        foreach ($showData as $row) :
        ?>

            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['brgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td><?= $row['katnama']; ?></td>
                <td><?= $row['satnama']; ?></td>
                <td><?= number_format($row['brgharga'], 0); ?></td>
                <td><?= number_format($row['brgstock'], 0); ?></td>
                <td>

                    <button type="button" class="btn btn-sm btn-info" onclick="edit('<?= $row['brgkode'] ?>')"><i class="fa fa-edit"></i></button>
                    <form action="/product/deleteData/<?= $row['brgkode'] ?>" method="POST" style="display:inline;" onsubmit="hapus();">
                        <input type="hidden" value="DELETE" name="_method">

                        <button type=" submit" class="btn btn-sm btn-danger" title="Delete Data">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="float-left mt-4">
    <?= $pager->links('product', 'paging') ?>
</div>

<script>
    function edit(code) {
        window.location.href = ('/product/editProduct/' + code);
    }

    function hapus() {
        var pesan = confirm('Are you sure want to delete this data?');

        if (pesan) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?= $this->endSection('isi'); ?>