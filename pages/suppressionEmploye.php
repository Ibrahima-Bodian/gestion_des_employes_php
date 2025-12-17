<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['numemp'])) {
    header('Location: choixSuppression.php');
    exit;
}

$numemp=(int) $_POST['numemp'];
$connection=connexion();
if (!$connection) {
    echo '<p>Erreur de connexion.</p>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Vérif s'il est chef (a des subordonnés)
$stmt=mysqli_prepare($connection, "SELECT COUNT(*) AS cnt FROM emp WHERE chef = ?");
mysqli_stmt_bind_param($stmt, "i", $numemp);
mysqli_stmt_execute($stmt);
$res=mysqli_stmt_get_result($stmt);
$row=$res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if ($row && intval($row['cnt']) > 0) {
    echo '<h1>Impossible de supprimer</h1>';
    echo '<p>Vous ne pouvez pas supprimer cet employé : il est chef de '.intval($row['cnt']).' employé(s). Commencez par changer le chef de ses subordonnés.</p>';
    echo '<p><a href="choixEmploye.php">Changer le chef</a> | <a href="choixSuppression.php">Retour</a></p>';
    close($connection);
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Effectuer la suppression
$stmt=mysqli_prepare($connection, "DELETE FROM emp WHERE numemp = ?");
mysqli_stmt_bind_param($stmt, "i", $numemp);
$ok=mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    echo '<h1>Suppression réussie</h1>';
    echo '<p>Vous avez supprimé l\'employé (numemp = '.htmlspecialchars($numemp, ENT_QUOTES, 'UTF-8').').</p>';
} else {
    echo '<h1>Erreur</h1>';
    echo '<p>Impossible de supprimer l\'employé.</p>';
}

close($connection);
?>
<p><a href="choixSuppression.php">Retour</a> | <a href="affichage.php">Voir la liste</a></p>
<?php include __DIR__ . '/../includes/footer.php'; ?>