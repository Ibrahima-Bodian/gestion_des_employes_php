<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

$connection=connexion();
$emps=[];
if ($connection) {
    $res=mysqli_query($connection, "SELECT numemp, nom FROM emp ORDER BY nom");
    if ($res) {
        while ($r=mysqli_fetch_assoc($res)) $emps[]=$r;
        mysqli_free_result($res);
    }
    close($connection);
}
?>
<h1>Suppression d'un employé</h1>

<?php if (count($emps)===0): ?>
  <p>Aucun employé trouvé.</p>
<?php else: ?>
  <form action="suppressionEmploye.php" method="post" onsubmit="return confirm('Confirmer la suppression ?');">
    <?php foreach ($emps as $e): ?>
      <div>
        <label>
          <input type="radio" name="numemp" value="<?= htmlspecialchars($e['numemp'], ENT_QUOTES, 'UTF-8') ?>" required>
          <?= htmlspecialchars($e['nom'], ENT_QUOTES, 'UTF-8') ?>
        </label>
      </div>
    <?php endforeach; ?>
    <p><button type="submit">Supprimer</button></p>
  </form>
<?php endif; ?>

<p><a href="affichage.php">Retour liste</a></p>

<?php include __DIR__ . '/../includes/footer.php'; ?>