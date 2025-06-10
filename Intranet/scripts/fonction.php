<?php
function showname() {
    if (isset($_SESSION['prenom']) && isset($_SESSION['nom']) && isset($_SESSION['groupe'])) {
        echo "<span class='text-light me-2'>Connecté en tant que ". htmlspecialchars($_SESSION['prenom']) ." ". htmlspecialchars($_SESSION['nom']) .", ". implode(", ", $_SESSION['groupe']) ."</span>";
        echo "<a href='./portail_deconnexion.php' class='btn btn-outline-light btn-sm'>Se déconnecter</a>";
    }
}
function page_load() {
    session_start();
    if (!isset($_SESSION['prenom'])){
        header("Location:portail_connexion.php");
    } 

        echo "<!DOCTYPE html>
            <html lang='fr'>
                <head>
                    <title>INTRANET</title>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
                    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
                </head>
                <body class='d-flex flex-column min-vh-100'>
                <header>
                  <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
                    <div class='container-fluid'>
                      <a class='navbar-brand' href='./accueil_intranet.php'>GMG</a>
                      <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'>
                        <span class='navbar-toggler-icon'></span>
                      </button>
                      <div class='collapse navbar-collapse' id='navbarNav'>
                        <ul class='navbar-nav me-auto'>
                          <li class='nav-item'>
                            <a class='nav-link text-light' href='./annuaire.php'>Annuaire</a>
                          </li>
                          <li class='nav-item'>
                            <a class='nav-link text-light' href='./gestion_fichier.php'>Gestion fichier</a>
                          </li>
                          <li class='nav-item'>
                            <a class='nav-link text-light' href='./wiki.php'>Wiki</a>
                          </li>
                          <li>
                            <a class='nav-link text-light' href='./profil.php'>Mon profil</a>
                          </li>
                        </ul>
                        <div class='d-flex align-items-center'>";
        showname();
        echo "</div></div></div></nav>";
}


function piedPage(){
    echo "
    <footer class='bg-dark text-white text-center py-3'>
        <div class='container'>
            <p>&copy; ". date('Y') ." Intranet. Tous droits réservés.</p>
        </div>
    </footer>
    </html>";
}

function afficherFichiers($chemin, $prefix = '') {
    global $isAdmin;

    $groupesUtilisateur = $_SESSION['groupe'] ?? [];
    $elements = scandir($chemin);
    echo '<ul class="list-group list-group-flush">';

    foreach ($elements as $element) {
        if ($element === '.' || $element === '..') continue;

        // Vérification des dossiers restreints
        $estDossierRestreint = in_array($element, ['direction', 'managers']);
        $autoriseVoir = $isAdmin || !$estDossierRestreint || in_array($element, $groupesUtilisateur);

        if (!$autoriseVoir) continue;

        $cheminComplet = $chemin . '/' . $element;
        $cheminRelatif = ltrim($cheminComplet, './'); // Pour enlever le ./ du nom

        if (is_dir($cheminComplet)) {
            $collapseId = md5($cheminComplet); // transforme le chemin en id unique avec un hashage md5 (connaitre le hashage md5 en CTF, c'est utile)
            $encodedFolder = urlencode($cheminRelatif);

            echo "
            <li class='list-group-item'>
                <div class='d-flex justify-content-between align-items-center'>
                    <a class='link-offset-2 link-underline link-underline-opacity-0' data-bs-toggle='collapse' href='#collapse$collapseId' role='button' aria-expanded='false' aria-controls='collapse$collapseId'>
                        📁 " . htmlspecialchars($element) . "
                    </a>
                    <div class='btn-group btn-group-sm'>
                        <a href='./scripts/download_zip.php?folder={$encodedFolder}' class='btn btn-outline-secondary m-1'>📦 ZIP</a>";

            if ($isAdmin) {
                echo "
                        <form action='./scripts/delete.php' method='post' class='d-inline' onsubmit='return confirm(\"Supprimer ce dossier et tout son contenu ?\");'>
                            <input type='hidden' name='fileToDelete' value='" . htmlspecialchars($cheminRelatif) . "'>
                            <button type='submit' class='btn btn-outline-danger m-1'>🗑️</button>
                        </form>";
            }

            echo "      </div>
                </div>
                <div class='collapse mt-2 ms-3' id='collapse$collapseId'>";
                    afficherFichiers($cheminComplet, $prefix . $element . '/');
            echo "  </div>
            </li>";
        } else {
            echo "
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <div>📄 " . htmlspecialchars($element) . "</div>
                <div class='btn-group btn-group-sm'>
                    <a href='./scripts/download.php?file=" . urlencode($cheminRelatif) . "' class='btn btn-outline-success m-1'>Télécharger</a>";

            if ($isAdmin) {
                echo "
                    <form action='./scripts/delete.php' method='post' class='d-inline' onsubmit='return confirm(\"Supprimer ce fichier ?\");'>
                        <input type='hidden' name='fileToDelete' value='" . htmlspecialchars($cheminRelatif) . "'>
                        <button type='submit' class='btn btn-outline-danger m-1'>🗑️</button>
                    </form>";
            }

            echo "
                </div>
            </li>";
        }
    }

    echo '</ul>';
}
?>
