<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['folderName'])) {
    $folderName = trim($_POST['folderName']);
    $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $folderName); // Évite les noms dangereux

    if ($safeName !== '') {
        $path = "../Storage/" . $safeName;

        if (!file_exists($path)) {
            mkdir($path, 0775, true);
            header("Location: ../gestion_fichier.php");
            exit;
        } else {
            header("Location: ../gestion_fichier.php");
            exit;
        }
    } else {
        die("Nom de dossier invalide.");
    }
} else {
    die("Requête invalide.");
}
?>
