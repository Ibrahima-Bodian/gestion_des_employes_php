<?php
include __DIR__ . '/../includes/header.php';

// récupération des départ via fonction.php
include __DIR__ . '/../includes/fonction.php';
//include __DIR__ . '/../includes/header.php';
$connection=connexion();
$departements=[];
if ($connection) {
    $sql="SELECT numdept, deptnom, ville FROM dept ORDER BY deptnom";
    $res=mysqli_query($connection, $sql);
    if ($res) {
        while ($r=mysqli_fetch_assoc($res)) {
            $departements[]=$r;
        }
        mysqli_free_result($res);
    }
    close($connection);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TP BD et web : formulaire</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<form action="affichage.php" method="get">
  <label for="numdepartement">Département (nom et ville) :</label><br>
  <select id="numdepartement" name="numdepartement" required>
    <?php if (!empty($departements)): ?>
      <?php foreach ($departements as $d): ?>
        <option value="<?= htmlspecialchars($d['numdept'], ENT_QUOTES, 'UTF-8') ?>">
          <?= htmlspecialchars($d['deptnom'].' à '.$d['ville'], ENT_QUOTES, 'UTF-8') ?>
        </option>
      <?php endforeach ?>
    <?php else: ?>
      <!-- fallback si pas de connexion DB -->
      <option value="4">administration à Amboise</option>
      <option value="1">vente à Blois</option>
      <option value="2">production à Tours</option>
      <option value="3">livraison à Contres</option>
    <?php endif; ?>
  </select>
  <br><br>
  <label for="salairemin">Salaire Minimal :</label>
  <input id="salairemin" type="number" name="salairemin" min="0" step="50" value="0" required>
  <p><input type="submit" value="Envoyer"></p>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
