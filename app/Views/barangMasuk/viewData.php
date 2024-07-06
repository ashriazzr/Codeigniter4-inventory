<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Data Transaction Incoming Goods
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/barangMasuk/index')">
    <i class=" fa fa-plus-circle"></i> Add Transaction
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<?= form_open('barangMasuk/data') ?>
<?= "<span class=\"badge badge-success\"> Total Data : $totalData</span> " ?>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search based on PO number" name="search" value="<?= $search ?>" autofocus="true">
    <div class="input-group-append">
        <button class="btn btn-outline-primary" type="submit" name="searchButton"><i class="fa fa-search"></i></button>
    </div>
</div>
<?= form_close(); ?>
<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>No PO</th>
            <th>Date</th>
            <th>Total Item</th>
            <th>Total Price (Rp)</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 10);
        foreach ($showData as $row) :

        ?>

            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $row['faktur']; ?></td>
                <td><?= date('d-m-Y', strtotime($row['tglfaktur'])); ?></td>
                <td align="center">
                    <?php
                    $db = \Config\Database::connect();
                    $totalItem = $db->table('detail_barangmasuk')->where('detfaktur', $row['faktur'])->countAllResults();
                    ?>
                    <span style="cursor:pointer; font-weight: bold; color:blue;" onclick="detailItem('<?= $row['faktur'] ?>')"><?= $totalItem; ?></span>
                </td>
                <td><?= number_format($row['totalharga'], 0, ",", ".") ?></td>
                <td>

                    <button type="button" class="btn btn-sm btn-info" onclick="edit('<?= $row['faktur'] ?>')"><i class="fa fa-edit"></i></button>
                    <form action="/barangmasuk/hapus/<?= $row['faktur'] ?>" method="POST" style="display:inline;" onsubmit="hapus();">
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
<div class="viewmodal" style="display: none;"></div>
<div class="float-left mt-4">
    <?= $pager->links('barangMasuk', 'paging') ?>
</div>

<script>
    function detailItem(faktur) {
        $.ajax({
            type: "post",
            url: "/barangMasuk/detailItem",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalItem').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function edit(code) {
        window.location.href = ('/barangMasuk/editFaktur/' + code);
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