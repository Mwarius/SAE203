<?php
session_start();

if (!isset($_SESSION['groupe']) || !in_array("admin", $_SESSION['groupe'])) {
    die("Accès refusé.");
}

if (isset($_POST['fileToDelete'])) {
    $filename = basename($_POST['fileToDelete']);
    $filepath = "../Storage/" . $filename;

    if (file_exists($filepath)) {
        unlink($filepath);
        header("Location: ../gestion_fichier.php");
        exit;
    } else {
        die("Fichier introuvable.");
    }
} else {
    die("Paramètre manquant.");
}
?>