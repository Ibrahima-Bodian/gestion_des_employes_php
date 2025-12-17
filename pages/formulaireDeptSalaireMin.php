<?php
include __DIR__ . '/../includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TP BD et web : formulaire</title>
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<body>
<form action="affichage.php" method="get">
  <label for="numdepartement">Numéro de département :</label>
  <input id="numdepartement" type="number" name="numdepartement" min="1" max="999" required>

  <label for="salairemin">Salaire minimal :</label>
  <input id="salairemin" type="number" name="salairemin" min="0" step="50" value="0" required>

  <p><input type="submit" value="Rechercher"></p>
</form>
</body>
</html>