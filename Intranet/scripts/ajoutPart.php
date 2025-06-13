<?php

$ajoutJson = [];
$ajoutJson['nom'] = $_POST['nom'];
$ajoutJson['logo'] = "./img/partenaire/" . $_POST['logo'];
$ajoutJson['description'] = $_POST['desc'];


$jsonPath = '../data/annuaire_partenaire.json';
$jsonString = file_get_contents($jsonPath);
$jsonDec = json_decode($jsonString, true);
if (!$jsonDec) $jsonDec = [];

$jsonDec[] = $ajoutJson;

$jsonFinal = json_encode($jsonDec, JSON_PRETTY_PRINT);
file_put_contents($jsonPath, $jsonFinal);

header("Location: ../annuaire.php");
exit;
?>
