<?php
$targetDir = "../Storage/";
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    echo "Fichier uploadé avec succès. <a href='../gestion_fichier.php'>Retour</a>";
} else {
    echo "Erreur lors de l'upload du fichier.";
}
?>