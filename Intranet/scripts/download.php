<?php
$filename = basename($_GET['file']);
$filepath = "../Storage/" . $filename;

if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'. $filename .'"');
    readfile($filepath);
    exit;
} else {
    echo "Fichier introuvable.";
}
?>