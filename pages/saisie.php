<?php
include __DIR__ . '/../includes/header.php';

include __DIR__ . '/../includes/fonction.php';
$connection=connexion();

$departements=[];
$chefs=[];

if ($connection) {
    $res=mysqli_query($connection, "SELECT numdept, deptnom, ville FROM dept ORDER BY deptnom");
    if ($res) {
        while ($r=mysqli_fetch_assoc($res)) $departements[]=$r;
        mysqli_free_result($res);
    }
    $res=mysqli_query($connection, "SELECT numemp, nom FROM emp ORDER BY nom");
    if ($res) {
        while ($r=mysqli_fetch_assoc($res)) $chefs[]=$r;
        mysqli_free_result($res);
    }
    close($connection);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ajouter un Employé</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<h1>Ajouter un employé</h1>
<form action="insert.php" method="post">
  <label for="nom">Nom :</label><br>
  <input id="nom" name="nom" type="text" required><br>

  <label for="emploi">Emploi :</label><br>
  <input id="emploi" name="emploi" type="text" required><br>

  <label for="embauche">Date embauche :</label><br>
  <input id="embauche" name="embauche" type="date" placeholder="jj/mm/aaaa"><br>

  <label for="salaire">Salaire :</label><br>
  <input id="salaire" name="salaire" type="number" min="0" step="50"><br>

  <label for="prime">Prime :</label><br>
  <input id="prime" name="prime" type="number" min="0" step="50"><br>

  <label for="numdept">Département :</label><br>
  <select id="numdept" name="numdept" required>
    <option value="">-- choisir --</option>
    <?php foreach ($departements as $d): ?>
      <option value="<?= htmlspecialchars($d['numdept'], ENT_QUOTES, 'UTF-8') ?>">
        <?= htmlspecialchars($d['deptnom'].' ('.$d['ville'].')', ENT_QUOTES, 'UTF-8') ?>
      </option>
    <?php endforeach; ?>
  </select><br>

  <label for="chef">Chef :</label><br>
  <select id="chef" name="chef">
    <option value="">-- aucun --</option>
    <?php foreach ($chefs as $c): ?>
      <option value="<?= htmlspecialchars($c['numemp'], ENT_QUOTES, 'UTF-8') ?>">
        <?= htmlspecialchars($c['nom'], ENT_QUOTES, 'UTF-8') ?>
      </option>
    <?php endforeach; ?>
  </select><br><br>

  <input type="submit" value="Envoyer">
</form>
</body>
</html>
