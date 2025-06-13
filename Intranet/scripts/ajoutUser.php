<?php

$ajoutJson = [];
$ajoutJson['prenom'] = $_POST['prenom'];
$ajoutJson['nom'] = $_POST['nom'];
$ajoutJson['motdepasse'] = $_POST['mdp'];
$ajoutJson['identifiant'] = strtolower(substr($ajoutJson['prenom'], 0, 2) . $ajoutJson['nom']);
$ajoutJson['photo'] = "./img/entreprise/" . $_POST['image'];
$ajoutJson['fonction'] = $_POST['fonction'];
$ajoutJson['description'] = $_POST['desc'];
$ajoutJson['groupe'] = [];

if (isset($_POST['directeur']))  $ajoutJson['groupe'][] = 'directeur';
if (isset($_POST['direction']))  $ajoutJson['groupe'][] = 'direction';
if (isset($_POST['salaries']))   $ajoutJson['groupe'][] = 'salariés';
if (isset($_POST['admin']))      $ajoutJson['groupe'][] = 'admin';
if (isset($_POST['managers']))   $ajoutJson['groupe'][] = 'managers';

// Read existing data
$jsonPath = '../data/annuaire_utilisateurs.json';
$jsonString = file_get_contents($jsonPath);
$jsonDec = json_decode($jsonString, true);
if (!$jsonDec) $jsonDec = [];

// Add new user
$jsonDec[] = $ajoutJson;

// Save updated JSON
$jsonFinal = json_encode($jsonDec, JSON_PRETTY_PRINT);
file_put_contents($jsonPath, $jsonFinal);

// Redirect to annuaire
header("Location: ../annuaire.php");
exit;
?>
