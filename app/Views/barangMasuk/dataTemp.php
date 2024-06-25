<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Code Product</th>
            <th>Name Product</th>
            <th>Seilling price</th>
            <th>Purchase Price</th>
            <th>Total</th>
            <th>Sub. Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($dataTemp->getResultArray() as $row) :
        ?>

            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $row['brgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td style="text-align:right;">
                    <?= number_format($row['dethargajual'], 0, ",", ".") ?>
                </td>
                <td style="text-align:right;">
                    <?= number_format($row['dethargamasuk'], 0, ",", ".") ?>
                </td>
                <td style="text-align:right;">
                    <?= number_format($row['detjml'], 0, ",", ".") ?>
                </td>
                <td style="text-align:right;">
                    <?= number_format($row['detsubtotal'], 0, ",", ".") ?>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem('<?= $row['iddetail'] ?>')"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function hapusItem(id) {
        Swal.fire({
            title: "Delete item?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangMasuk/deleteItem",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            dataTemp();
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.success
                              
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        });
    }
</script>