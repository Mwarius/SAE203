<?php
session_start(); // Démarre la session PHP pour accéder aux variables de session.

function deleteRecursive($dir) {
    // Fonction récursive pour supprimer un dossier et tout son contenu (utile plus tard).
    if (!file_exists($dir)) return; // Si le chemin n'existe pas, on sort de la fonction.
    if (is_file($dir)) {
        unlink($dir); // Si c'est un fichier, on le supprime.
    } elseif (is_dir($dir)) { // sinon c'est un dossier donc on execute la fonction a l'interieur de ce dossier
        foreach (scandir($dir) as $item) { // on parcours tout son contenu
            if ($item === '.' || $item === '..') continue; // On ignore les entrées spéciales.
            deleteRecursive($dir . DIRECTORY_SEPARATOR . $item); // utilisation DIRECTORY_SEPARATOR pour marcher sur linux et windows (Xamp par exemple)
            // Appel récursif pour chaque élément contenu dans le dossier.
        }
        rmdir($dir); // Une fois vide, on peut supprimer le dossier.
    }
}

if (!isset($_SESSION['groupe']) || !in_array("admin", $_SESSION['groupe'])) {
    die("Accès refusé.");
} 
// Vérifie que l'utilisateur est connecté et appartient au groupe "admin".
// Sinon, stoppe immédiatement l'exécution du script (sécurité quand meme).

if (isset($_POST['fileToDelete'])) { 
    // Vérifie que le paramètre "fileToDelete" a bien été envoyé via le formulaire.

    $target = str_replace(['..', '\\'], '', $_POST['fileToDelete']); 
    // Nettoie le chemin pour éviter les tentatives de traversée de répertoires (ex: "../../etc/passwd") comme en CTF
    // Supprime les séquences ".." et les antislashs.

    $path = "../" . $target; 
    // Construit le chemin réel sur le serveur, relatif au dossier courant.

    if (!file_exists($path)) {
        die("Fichier ou dossier introuvable.");
    }
    // Si le fichier ou le dossier à supprimer n'existe pas, on arrête l'exécution avec un message.
    deleteRecursive($path); // Lance la suppression du fichier ou dossier demandé.
    header("Location: ../gestion_fichier.php"); 
    // Redirige l'utilisateur vers la page principale après suppression.
    exit; // Termine le script proprement.
}

die("Paramètre manquant."); 
// Si le formulaire ne contient pas "fileToDelete" aka le fichier qu'on veut supprimer, on arrête tout avec un message d'erreur.
?>
