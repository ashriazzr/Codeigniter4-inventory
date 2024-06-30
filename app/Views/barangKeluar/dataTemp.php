<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th colspan="5"></th>
            <th colspan="2" style=" text-align: right;">
                <?php
                $totalPrice = 0;
                foreach ($showdata->getResultArray() as $row) :
                    $totalPrice += $row['detsubtotal'];
                endforeach;
                ?>
                <h3><?= number_format($totalPrice, 0, ",", ".") ?></h3>
                <input type="hidden" id="totalprice" value="<?= $totalPrice ?>">

            </th>

        </tr>
    </thead>
    <thead>
        <tr>
            <th>No</th>
            <th>Code product</th>
            <th>Name product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Sub. Total</th>
            <th>#</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $nomor = 1;
        foreach ($showdata->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['detbrgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td style="text-align: right;"><?= number_format($row['dethargajual'], 0, ",", ".") ?></td>
                <td><?= number_format($row['detjml'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($row['detsubtotal'], 0, ",", ".") ?></td>
                <td style="text-align: right;">
                    <button class="btn btn-sm btn-danger" onclick="deleteItem('<?= $row['id'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach;  ?>
    </tbody>
</table>

<script>
    function deleteItem(id) {
        Swal.fire({
            title: "Delete Item",
            text: "Are you sure want to delete this Item?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangKeluar/deleteItem",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('success', response.success, 'success');
                            showDataTemp();
                            kosong();
                        }
                    }
                });
            }
        });
    }
</script>