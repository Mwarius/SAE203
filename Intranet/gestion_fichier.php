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
                    <div class="col-md-8">
                        <input type="file" name="fileToUpload" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Uploader</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des fichiers disponibles -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">📂 Fichiers disponibles</h5>
                <ul class="list-group">
                    <?php
                    $files = scandir("Storage");
                    $isAdmin = isset($_SESSION['groupe']) && in_array("admin", $_SESSION['groupe']);

                    foreach ($files as $file) {
                        if ($file != "." && $file != "..") {
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                            echo '<div>' . htmlspecialchars($file) . '</div>';
                            echo '<div>';
                            echo '<a href="./scripts/download.php?file=' . urlencode($file) . '" class="btn btn-sm btn-outline-success me-2">Télécharger</a>';

                            if ($isAdmin) {
                                echo '<form action="./scripts/delete.php" method="post" class="d-inline" onsubmit="return confirm(\'Supprimer ce fichier ?\');">';
                                echo '<input type="hidden" name="fileToDelete" value="' . htmlspecialchars($file) . '">';
                                echo '<button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>';
                                echo '</form>';
                            }

                            echo '</div>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
piedPage();
?>
