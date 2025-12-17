<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

$connection=connexion();
$departements=[];
if ($connection) {
    $res=mysqli_query($connection, "SELECT numdept, deptnom, ville FROM dept ORDER BY deptnom");
    if ($res) {
        while ($r=mysqli_fetch_assoc($res)) $departements[]=$r;
        mysqli_free_result($res);
    }
}

$numdept=isset($_GET['numdept']) && ctype_digit($_GET['numdept']) ? (int)$_GET['numdept'] : null;

// Préparer requête avec jointures ; si numdept null, pas de WHERE sur numdept
if ($connection) {
    if ($numdept===null) {
        $sql="SELECT e.numemp, e.nom, e.emploi, e.embauche, e.salaire, e.prime, d.deptnom, d.ville, c.nom AS nom_chef
                FROM emp e
                LEFT JOIN dept d ON e.numdept=d.numdept
                LEFT JOIN emp c ON e.chef=c.numemp
                ORDER BY e.nom";
        $stmt=mysqli_prepare($connection, $sql);
    } else {
        $sql="SELECT e.numemp, e.nom, e.emploi, e.embauche, e.salaire, e.prime, d.deptnom, d.ville, c.nom AS nom_chef
                FROM emp e
                LEFT JOIN dept d ON e.numdept=d.numdept
                LEFT JOIN emp c ON e.chef=c.numemp
                WHERE e.numdept = ?
                ORDER BY e.nom";
        $stmt=mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $numdept);
    }
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
} else {
    $result=false;
}
?>
<h1>Filtrage des employés</h1>

<form method="get" action="filtreEmployeDept.php">
  <label for="numdept">Filtrer par département :</label>
  <select id="numdept" name="numdept">
    <option value="">-- Tous --</option>
    <?php foreach ($departements as $d): ?>
      <option value="<?= htmlspecialchars($d['numdept'], ENT_QUOTES, 'UTF-8') ?>" <?= ($numdept !==null && $numdept==$d['numdept']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($d['deptnom'].' ('.$d['ville'].')', ENT_QUOTES, 'UTF-8') ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Appliquer</button>
</form>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    echo '<table border="1" style="width:100%;border-collapse:collapse;margin-top:1rem">';
    echo '<tr><th>numemp</th><th>nom</th><th>emploi</th><th>embauche</th><th>salaire</th><th>prime</th><th>dept</th><th>ville</th><th>chef</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.htmlspecialchars($row['numemp'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['nom'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['emploi'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['embauche'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['salaire'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['prime'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['deptnom'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['ville'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['nom_chef'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>Aucun employé trouvé pour ce filtre.</p>';
}

if (isset($stmt)) { mysqli_stmt_close($stmt); }
if ($connection) { close($connection); }

include __DIR__ . '/../includes/footer.php';
?>