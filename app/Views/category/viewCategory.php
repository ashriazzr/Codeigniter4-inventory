<?= $this->extend('main/layout'); ?>



<?= $this->section('judul'); ?>
Management Data Category
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>

<?= form_button('', '<i class ="fa fa-plus-circle"></i> Add Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('category/formAdd') . "')"
]) ?>

<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>

<?= session()->getFlashdata('success'); ?>
<?= form_open('category/index') ?>

<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search data category" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" value="<?= $search; ?>">
    <div class="input-group-append">
        <button class=" btn btn-outline-primary" type="submit" id="searchbutton" name="searchbutton"><i class="fa fa-search"></i></button>
    </div>
</div>
<?= form_close(); ?>
<table class="table table-striped table-bordered table-hover" style="width:100%;">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Name Category</th>
            <th style="width: 15%;">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 5);
        foreach ($showData as $row) :
        ?>

            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['katnama']; ?></td>
                <td>
                    <button type="button" class="btn btn-info" title="Edit Data" onclick="edit('<?= $row['katid'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <form action="/category/deleteData/<?= $row['katid'] ?>" method="POST" style="display:inline;" onsubmit="hapus();">
                        <input type="hidden" value="DELETE" name="_method">

                        <button type=" submit" class="btn btn-danger" title="Delete Data">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="float-center">
    <?= $pager->links('category', 'paging'); ?>
</div>

<script>
    function edit(id) {
        window.location = ('/category/formEdit/' + id);
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