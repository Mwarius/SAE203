<?php

$ajoutJson = [];
$ajoutJson['id_client'] = $_POST['id_client'];
$ajoutJson['nom_client'] = $_POST['nom_client'];
$ajoutJson['telephone'] = $_POST['telephone'];
$ajoutJson['email'] = $_POST['email'];
$ajoutJson['adresse'] = $_POST['adresse'];
$ajoutJson['projet'] = $_POST['projet'];
$ajoutJson['statut'] = $_POST['statut'];

$jsonPath = '../data/annuaire_clients.json';
$jsonString = file_get_contents($jsonPath);
$jsonDec = json_decode($jsonString, true);
if (!$jsonDec) $jsonDec = [];

$jsonDec[] = $ajoutJson;

$jsonFinal = json_encode($jsonDec, JSON_PRETTY_PRINT);
file_put_contents($jsonPath, $jsonFinal);

header("Location: ../annuaire.php");
exit;
?>
