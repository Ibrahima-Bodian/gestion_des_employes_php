<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['numemp'])) {
    header('Location: choixEmploye.php');
    exit;
}

$numemp=(int) $_POST['numemp'];
$connection=connexion();
$employe=null;
$chefs=[];

if ($connection) {
    //nom de l'employé sélectionné
    $stmt=mysqli_prepare($connection, "SELECT nom FROM emp WHERE numemp = ?");
    mysqli_stmt_bind_param($stmt, "i", $numemp);
    mysqli_stmt_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    $employe=$res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    //liste des chefs possibles (exclut l'employé lui-même)
    $stmt=mysqli_prepare($connection, "SELECT numemp, nom FROM emp WHERE numemp <> ? ORDER BY nom");
    mysqli_stmt_bind_param($stmt, "i", $numemp);
    mysqli_stmt_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    if ($res) {
        while ($r=mysqli_fetch_assoc($res)) $chefs[]=$r;
        mysqli_free_result($res);
    }
    mysqli_stmt_close($stmt);
    close($connection);
}
?>
<h1>Choisir le nouveau chef</h1>

<?php if (!$employe): ?>
  <p>Employé introuvable.</p>
<?php else: ?>
  <p>Employé sélectionné : <strong><?= htmlspecialchars($employe['nom'], ENT_QUOTES, 'UTF-8') ?></strong></p>
  <form action="changerChef.php" method="post">
    <input type="hidden" name="numEmp" value="<?= htmlspecialchars($numemp, ENT_QUOTES, 'UTF-8') ?>">
    <?php foreach ($chefs as $c): ?>
      <div>
        <label>
          <input type="radio" name="newChef" value="<?= htmlspecialchars($c['numemp'], ENT_QUOTES, 'UTF-8') ?>" required>
          <?= htmlspecialchars($c['nom'], ENT_QUOTES, 'UTF-8') ?>
        </label>
      </div>
    <?php endforeach; ?>
    <div>
      <label>
        <input type="radio" name="newChef" value="NULL" required> AUCUN CHEF
      </label>
    </div>
    <p><button type="submit">Changer de chef</button></p>
  </form>
<?php endif; ?>

<p><a href="choixEmploye.php">Retour</a></p>

<?php include __DIR__ . '/../includes/footer.php'; ?>