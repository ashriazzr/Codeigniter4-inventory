<link rel="stylesheet" href="<?= base_url() . '/plugins/chart.js/Chart.min.css' ?>">
<script src="<?= base_url() . '/plugins/chart.js/Chart.bundle.min.js' ?>"></script>

<canvas id="myChart" style="height: 50vh; width: 80vh;"></canvas>

<?php
$date = "";
$total = "";

foreach ($grafik as $row) :
    $tgl = $row->tgl;
    $date .= "'$tgl'" . ",";

    $totalPrice = $row->totalharga;
    $total .=  "'$totalPrice'" . ",";


endforeach;
?>

<script>
   var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    responsive: true,
    data: {
        labels: [<?= $date; ?>],
        datasets: [{
            label: 'Total Price',
            backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(75, 192, 192)'],
            borderColor: ['rgb(255, 99, 132)'],
            data: [<?= $total; ?>]
        }]
    }
});

</script>