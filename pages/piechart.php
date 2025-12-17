<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

$connection = connexion();
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
function palette($n){
  $base=['#4dc9f6','#f67019','#f53794','#537bc4','#acc236','#166a8f','#00a950','#58595b','#8549ba','#f44'];
  $out=[]; for($i=0;$i<$n;$i++) $out[] = $base[$i % count($base)]; return $out;
}
$colors=palette(count($data));
?>
<div style="padding:1rem;">
  <h2>Pie Chart — répartition des salaires moyens</h2>
  <div style="max-width:700px; height:500px;">
    <canvas id="chartPie"></canvas>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels=<?= json_encode($labels, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>;
const values=<?= json_encode($data) ?>;
const bg=<?= json_encode($colors) ?>;
new Chart(document.getElementById('chartPie').getContext('2d'), {
  type: 'pie',
  data: { labels: labels, datasets: [{ data: values, backgroundColor: bg }] },
  options: { responsive:true, maintainAspectRatio:false }
});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>