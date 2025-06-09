<?php
include './scripts/fonction.php';
page_load();
?>


  <div class='jumbotron jumbotron-fluid p-5 bg-primary text-white'>
    <div class='container'>
      <h1 class='text-center'>Bienvenue dans le gestionnaire de fichier</h1>
    </div>
  </div>
</header>
<section class='flex-grow-1 d-flex justify-content-center align-items-center'>
<div class="container py-5">
        <h1 class="mb-4 text-center">📁 Gestionnaire de fichiers</h1>

        <!-- Formulaire d'upload -->
        <div class="card mb-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Uploader un fichier</h5>
                    <form action="./scripts/upload.php" method="post" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-4">
                            <input type="file" name="fileToUpload" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <select name="uploadFolder" class="form-select" required>
                                <?php
                                $dossierBase = "Storage"; // Définit le dossier de base où sont stockés tous les sous-dossiers accessibles via l'interface.
                                $dossiers = scandir($dossierBase); // Récupère tous les fichiers et dossiers contenus dans "Storage" (renvoie aussi '.' et '..').

                                $groupesUtilisateur = $_SESSION['groupe']; // Récupère les groupes de l'utilisateur connecté (ou tableau vide si non défini).
                                $isAdmin = in_array("admin", $groupesUtilisateur); // Vérifie si l'utilisateur a le rôle "admin".

                                foreach ($dossiers as $dossier) { // Parcourt chaque élément trouvé dans le dossier "Storage".
                                    if ($dossier === '.' || $dossier === '..') continue; // Ignore les entrées spéciales du système de fichiers.
                                    if (!is_dir("$dossierBase/$dossier")) continue; // Ignore les fichiers : on ne garde que les dossiers.
                                
                                    // Vérifie si le dossier est restreint (seulement visible par les rôles "direction" ou "managers").
                                    $estDossierRestreint = in_array($dossier, ['direction', 'managers']);
                                
                                    // L'utilisateur est autorisé à voir ce dossier si :
                                    // - il est admin
                                    // - le dossier n'est pas restreint
                                    // - OU il appartient au groupe correspondant au nom du dossier
                                    $autoriseVoir = $isAdmin || !$estDossierRestreint || in_array($dossier, $groupesUtilisateur);
                                
                                    if (!$autoriseVoir) continue; // Si l'utilisateur n'est pas autorisé à voir ce dossier, on passe au suivant.
                                
                                    // Marque le dossier "transfert" comme sélectionné par défaut.
                                    $selected = ($dossier === 'transfert') ? 'selected' : '';
                                
                                    // Affiche une option dans le <select> avec le nom du dossier (échappé pour la sécurité HTML).
                                    echo "<option value=\"" . htmlspecialchars($dossier) . "\" $selected>" . htmlspecialchars($dossier) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                            
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Uploader</button>
                        </div>
                    </form>
            </div>
        </div>
        <!-- création fichier -->
    <div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Créer un dossier</h5>
        <form action="./scripts/create_folder.php" method="post" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="folderName" class="form-control" placeholder="Nom du dossier" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">Créer</button>
            </div>
        </form>
    </div>
</div>

        <!-- Liste des fichiers disponibles -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">📂 Fichiers disponibles</h5>
                <?php
                $isAdmin = isset($_SESSION['groupe']) && in_array("admin", $_SESSION['groupe']);
                afficherFichiers("Storage");   
                ?>
                </ul>
            </div>
        </div>
    </div>
    
</section>

<?php
piedPage();
?>
