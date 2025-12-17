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
<h1>Sélectionner l'employé qui va changer de chef</h1>

<?php if (count($emps)===0): ?>
  <p>Aucun employé trouvé.</p>
<?php else: ?>
  <form action="choixChef.php" method="post">
    <?php foreach ($emps as $e): ?>
      <div>
        <label>
          <input type="radio" name="numemp" value="<?= htmlspecialchars($e['numemp'], ENT_QUOTES, 'UTF-8') ?>" required>
          <?= htmlspecialchars($e['nom'], ENT_QUOTES, 'UTF-8') ?>
        </label>
      </div>
    <?php endforeach; ?>
    <p><button type="submit">Choisir Chef</button></p>
  </form>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>