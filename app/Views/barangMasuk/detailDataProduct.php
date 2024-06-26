<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Code Product</th>
            <th>Name Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($showData->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['brgkode'] ?></td>
                <td><?= $row['brgnama'] ?></td>
                <td><?= number_format($row['brgharga'], 0, ",", ".") ?></td>
                <td><?= number_format($row['brgstock'], 0, ",", ".") ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-info" onclick="choose('<?= $row['brgkode'] ?>')">Choose</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function choose(code) {
        $('#kdbarang').val(code);
        $('#modalSearchProduct').on('hidden.bs.modal', function(e) {
            ambilDataBarang();
        })
        $('#modalSearchProduct').modal('hide');

    }
</script>