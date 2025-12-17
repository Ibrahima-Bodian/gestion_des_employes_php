<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

$connection=connexion();
$labels=$data=[];
if ($connection) {
    $sql="SELECT d.deptnom, d.ville, AVG(e.salaire) AS avg_salaire
            FROM dept d
            LEFT JOIN emp e ON e.numdept=d.numdept
            GROUP BY d.numdept
            ORDER BY d.numdept";
    $res=mysqli_query($connection, $sql);
    while ($r=mysqli_fetch_assoc($res)) {
        $labels[]=$r['deptnom'] . ' (' . $r['ville'] . ')';
        $data[]=$r['avg_salaire'] !== null ? round((float)$r['avg_salaire'],2) : 0;
    }
    mysqli_free_result($res);
    close($connection);
}
?>
<div style="padding:1rem;">
  <h2>Line Chart — salaires moyens par département</h2>
  <div style="max-width:1100px; height:500px;">
    <canvas id="chartLine"></canvas>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = <?= json_encode($labels, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>;
const values = <?= json_encode($data) ?>;
new Chart(document.getElementById('chartLine').getContext('2d'), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{ label: 'Salaire moyen', data: values, borderColor: '#4dc9f6', backgroundColor: 'rgba(77,201,246,0.2)', fill:true, tension:0.2 }]
  },
  options: { responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true } } }
});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>