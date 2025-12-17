<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['numEmp']) || !isset($_POST['newChef'])) {
    header('Location: choixEmploye.php');
    exit;
}

$numEmp=(int) $_POST['numEmp'];
$newChefRaw=$_POST['newChef'];

$connection=connexion();
if (!$connection) {
    echo '<p>Erreur de connexion.</p>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

if ($newChefRaw==='NULL') {
    // suppression du chef (NULL)
    $stmt=mysqli_prepare($connection, "UPDATE emp SET chef=NULL WHERE numemp=?");
    mysqli_stmt_bind_param($stmt, "i", $numEmp);
    $ok=mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($ok) {
        echo '<p>Chef supprimé pour l\'employé (numemp = '.htmlspecialchars($numEmp, ENT_QUOTES, 'UTF-8').').</p>';
    } else {
        echo '<p>Erreur lors de la suppression du chef.</p>';
    }
} else {
    $newChef=(int) $newChefRaw;
    $stmt=mysqli_prepare($connection, "UPDATE emp SET chef = ? WHERE numemp = ?");
    mysqli_stmt_bind_param($stmt, "ii", $newChef, $numEmp);
    $ok=mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($ok) {
        // obtenir noms pour message
        $stmt=mysqli_prepare($connection, "SELECT e.nom AS emp_nom, c.nom AS chef_nom FROM emp e LEFT JOIN emp c ON e.chef = c.numemp WHERE e.numemp = ?");
        mysqli_stmt_bind_param($stmt, "i", $numEmp);
        mysqli_stmt_execute($stmt);
        $res=mysqli_stmt_get_result($stmt);
        $row=$res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);

        $empNom=$row['emp_nom'] ?? '—';
        $chefNom=$row['chef_nom'] ?? '—';
        echo '<p>Le nouveau chef de '.htmlspecialchars($empNom, ENT_QUOTES, 'UTF-8').' est '.htmlspecialchars($chefNom, ENT_QUOTES, 'UTF-8').'.</p>';
    } else {
        echo '<p>Erreur lors de la mise à jour du chef.</p>';
    }
}

close($connection);
?>

<p><a href="choixEmploye.php">Retour à la sélection</a> | <a href="affichage.php">Voir la liste</a></p>

<?php include __DIR__ . '/../includes/footer.php'; ?>