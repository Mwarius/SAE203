<?php
$filename = $_GET['file'];
$filepath = "../" . $filename;

if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'. basename($filename) .'"');
    readfile($filepath);
    exit;
} else {
    echo "Fichier introuvable.";
}
?>
