<?php
session_start();

// Vérifier que le dossier est spécifié
if (!isset($_GET['folder'])) {
    header("Location: ../index.php");
    exit;
}

// Sécuriser le nom du dossier (évite les chemins relatifs)
$folder = basename($_GET['folder']);
$basePath = realpath('../Storage'); // dossier racine complet
$fullPath = realpath("$basePath/$folder"); //chemin complet

// Vérification que le chemin est bien dans Storage
if (!$fullPath || strpos($fullPath, $basePath) !== 0 || !is_dir($fullPath)) {
    die("Dossier invalide.");
}

// Créer un fichier ZIP temporaire
$zip = new ZipArchive();
$tmpZip = tempnam(sys_get_temp_dir(), 'zip_');

if ($zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Impossible de créer le fichier ZIP.");
}

$folderBase = basename($fullPath);
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fullPath, RecursiveDirectoryIterator::SKIP_DOTS)); // fonction native a php permettant de lister tt les fichiers d'un dossier.

foreach ($files as $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = $folderBase . '/' . substr($filePath, strlen($fullPath) + 1); // permet de recréer l'arborescence d'origine (avec les fichier dans les bon dossier)
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();

// Forcer le téléchargement
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $folderBase . '.zip"');
header('Content-Length: ' . filesize($tmpZip));

// Lire le fichier et le supprimer juste après
readfile($tmpZip);
unlink($tmpZip);
exit;
