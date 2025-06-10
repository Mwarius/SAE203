<?php
session_start();

$targetDir = '../Storage/';
$uploadFolder = isset($_POST['uploadFolder']) ? basename($_POST['uploadFolder']) : 'transfert';

// Sécurisation
$uploadFolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $uploadFolder);
$targetDir .= $uploadFolder . '/';

// Création du chemin s'il n'existe pas
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0775, true);
}

$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    header("Location: ../gestion_fichier.php");
    exit;
} else {
    echo "Erreur lors de l’upload du fichier.";
}
?>
