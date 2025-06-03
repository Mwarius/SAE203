<?php
session_start();
if (!isset($_SESSION['prenom'])) {
  header("Location:portail_connexion.php");
  exit;
}

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
  <title>INTRANET - Wiki</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
</head>
<body class='d-flex flex-column min-vh-100'>
<header>
  <div>
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
              <a class='nav-link active text-light' href='./wiki.php'>Wiki</a>
            </li>
          </ul>
          <div class='d-flex align-items-center'>";
            if (isset($_SESSION['prenom']) && isset($_SESSION['nom']) && isset($_SESSION['groupe'])) {
              echo "<span class='text-light me-2'>Connecté en tant que ". htmlspecialchars($_SESSION['prenom']) ." ". htmlspecialchars($_SESSION['nom']) .", ". implode(', ', $_SESSION['groupe']) ."</span>";
              echo "<a href='./portail_deconnexion.php' class='btn btn-outline-light btn-sm'>Se déconnecter</a>";
            }
          echo "</div>
        </div>
      </div>
    </nav>
  </div>
  <div class='jumbotron jumbotron-fluid p-5 bg-primary text-white'>
    <div class='container'>
      <h1 class='text-center'>Wiki de l'intranet GMG Construction</h1>
      <p class='text-center'>Documentation des pages de l'intranet</p>
    </div>
  </div>
</header>

<main class='container my-5 flex-grow-1'>
  <div class='table-responsive'>
    <table class='table table-bordered table-hover'>
      <thead class='table-dark'>
        <tr>
          <th>Nom de la page</th>
          <th>Fichier</th>
          <th>Description / Utilité</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Page de connexion</td>
          <td><code>portail_connexion.php</code></td>
          <td>Permet aux utilisateurs de se connecter via un identifiant et un mot de passe. Vérifie les identifiants avec un fichier JSON sécurisé.</td>
        </tr>
        <tr>
          <td>Page d'accueil</td>
          <td><code>accueil_intranet.php</code></td>
          <td>Page d’accueil de l'intranet après connexion. Présente les liens vers les fonctionnalités principales.</td>
        </tr>
        <tr>
          <td>Annuaire</td>
          <td><code>annuaire.php</code></td>
          <td>Affiche les utilisateurs enregistrés dans le fichier JSON. Permet de visualiser le personnel GMG.</td>
        </tr>
        <tr>
          <td>Gestionnaire de fichiers</td>
          <td><code>gestion_fichier.php</code></td>
          <td>Permet de gérer les fichiers partagés de l’entreprise (upload, affichage... à implémenter).</td>
        </tr>
        <tr>
          <td>Wiki</td>
          <td><code>wiki.php</code></td>
          <td>Page de documentation expliquant l’utilité de chaque partie du site.</td>
        </tr>
        <tr>
          <td>Déconnexion</td>
          <td><code>portail_deconnexion.php</code></td>
          <td>Déconnecte l'utilisateur en supprimant sa session, puis le redirige vers la page de connexion.</td>
        </tr>
      </tbody>
    </table>
  </div>
</main>

<footer class='bg-dark text-white text-center py-3 mt-auto'>
  <div class='container'>
    <p>&copy; ". date('Y') ." Intranet. Tous droits réservés.</p>
  </div>
</footer>
</body>
</html>";
?>
