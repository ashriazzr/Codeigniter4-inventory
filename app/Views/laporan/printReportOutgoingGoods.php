<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Outgoing Goods</title>
</head>

<body onload="window.print();">
    <table style="width: 100%; border-collapse: collapse; text-align: center;" border="1">
        <tr>
            <td>
                <table style="width: 100%; text-align: center;" border="0">
                    <tr style="text-align: center;">
                        <td>
                            <h3>SPIKE HOUSE MARKET</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; text-align: center;" border="0">
                    <tr style="text-align: center;">
                        <td>
                            <h3><u>Report Outgoing Product</u></h3><br>
                            Period : <?= $firstDate . "-" . $lastDate; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><br>
                            <center>
                                <table border="1" cellpadding="5" style="border-collapse: collapse; border: 1px solid #000;text-align: center; width: 80%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Invoice</th>
                                            <th>Date</th>
                                            <th>Total Price (Rp.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = 1;
                                        $totalSeluruhHarga = 0;
                                        foreach ($datalaporan->getResultArray() as $row) :
                                            $totalSeluruhHarga += $row['totalharga']; ?>
                                            <tr>
                                                <td><?= $nomor++; ?></td>
                                                <td><?= $row['faktur']; ?></td>
                                                <td><?= $row['tglfaktur']; ?></td>
                                                <td style="text-align: right;">
                                                    <?= number_format($row['totalharga'], 0, ",", ".") ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;  ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total All Price</th>
                                            <td style="text-align: right;">
                                                <?= number_format($totalSeluruhHarga, 0, ",", ".") ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </center>
                            <br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>