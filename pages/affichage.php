<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TP BD et web : affichage des résultats</title> 
 <link rel="Stylesheet" type="text/css" href="style.css" />
<body>
<?php
// remonte d'un dossier vers includes
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/fonction.php';

// je récup et valide les paramètres GET
$numdepartement = isset($_GET['numdepartement']) ? (int) $_GET['numdepartement'] : 0;
$salairemin = isset($_GET['salairemin']) ? (int) $_GET['salairemin'] : 1450;

echo '<h1>Employés du département '.htmlspecialchars($numdepartement, ENT_QUOTES, 'UTF-8')
    .' avec salaire &gt; '.htmlspecialchars($salairemin, ENT_QUOTES, 'UTF-8').'</h1>';

$connection = connexion();

// Req préparée : jointure avec dept et auto-jointure pour récupérer le nom du chef
$sql = "SELECT e.numemp, e.nom, e.salaire, d.deptnom, d.ville, c.nom AS nom_chef
        FROM emp e
        LEFT JOIN dept d ON e.numdept = d.numdept
        LEFT JOIN emp c  ON e.chef = c.numemp
        WHERE e.numdept = ? AND e.salaire > ?
        ORDER BY e.salaire DESC";

$stmt = mysqli_prepare($connection, $sql);
if ($stmt === false) {
    die('Erreur préparation requête.');
}
mysqli_stmt_bind_param($stmt, "ii", $numdepartement, $salairemin);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Affichage sécurisé
if ($result && mysqli_num_rows($result) > 0) {
    echo '<table border="1"><tr>'
       .'<th>numemp</th>'
       .'<th>nom</th>'
       .'<th>salaire</th>
       <th>département</th>
       <th>ville</th>
       <th>nom_chef</th>'
       .'</tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.htmlspecialchars($row['numemp'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['nom'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['salaire'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['deptnom'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['ville'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '<td>'.htmlspecialchars($row['nom_chef'], ENT_QUOTES, 'UTF-8').'</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>Aucun employé ne correspond aux critères.</p>';
}

mysqli_stmt_close($stmt);
close($connection);

include __DIR__ . '/../includes/footer.php';
?>
</body>
</html>
