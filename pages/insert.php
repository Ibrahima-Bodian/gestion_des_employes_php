<?php
include __DIR__ . '/../includes/fonction.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: saisie.php');
    exit;
}

// Récup et nettoyage des données
$nom=trim($_POST['nom'] ?? '');
$emploi=trim($_POST['emploi'] ?? '');
$embauche=trim($_POST['embauche'] ?? '');
$salaire=$_POST['salaire'] ?? '';
$prime=$_POST['prime'] ?? '';
$numdept=$_POST['numdept'] ?? '';
$chef=$_POST['chef'] ?? '';

// Validation basique
$errors=[];
if ($nom==='') $errors[]='Le nom est requis.';
if ($emploi==='') $errors[]='L\'emploi est requis.';
if ($numdept==='' || !ctype_digit(strval($numdept))) $errors[]='Le département est requis.';
if ($salaire !=='' && !is_numeric($salaire)) $errors[]='Salaire invalide.';
if ($prime !== '' && !is_numeric($prime)) $errors[]='Prime invalide.';
if ($chef !== '' && !ctype_digit(strval($chef))) $errors[]='Chef invalide.';

if (count($errors) > 0) {
    echo '<p>Erreurs :</p><ul>';
    foreach ($errors as $e) echo '<li>'.htmlspecialchars($e, ENT_QUOTES, 'UTF-8').'</li>';
    echo '</ul><p><a href="saisie.php">Retour</a></p>';
    exit;
}

// Préparation des valeurs pour insertion (NULL si vide)
$embauche_val=$embauche=== '' ? null : $embauche;
$salaire_val=$salaire === '' ? null : (int)$salaire;
$prime_val=$prime === '' ? null : (int)$prime;
$numdept_val=(int)$numdept;
$chef_val=($chef === '' ? null : (int)$chef);

$connection=connexion();
if (!$connection) {
    die('Connexion impossible.');
}

$sql="INSERT INTO emp (nom, emploi, embauche, salaire, prime, numdept, chef)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt=mysqli_prepare($connection, $sql);
if ($stmt===false) {
    close($connection);
    die('Erreur préparation requête.');
}


$bind_embauche=$embauche_val;
$bind_salaire=$salaire_val;
$bind_prime=$prime_val;
$bind_chef=$chef_val;

mysqli_stmt_bind_param($stmt, "sssiiii",
    $nom,
    $emploi,
    $bind_embauche,
    $bind_salaire,
    $bind_prime,
    $numdept_val,
    $bind_chef
);


$ok = mysqli_stmt_execute($stmt);
if ($ok) {
    echo '<p>Employé ajouté avec succès.</p>';
    echo '<p><a href="saisie.php">Ajouter un autre</a> | <a href="affichage.php">Voir la liste</a></p>';
} else {
    echo '<p>Erreur insertion : '.htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8').'</p>';
    echo '<p><a href="saisie.php">Retour</a></p>';
}

mysqli_stmt_close($stmt);
close($connection);
?>
