<?php
session_start();
if (!isset($_SESSION['prenom'])) {
  header("Location:portail_connexion.php");
  exit;
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
              <a class='nav-link text-light active' href='./wiki.php'>Wiki</a>
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
      <h1 class='text-center'>Bienvenue sur le Wiki</h1>
      <p class='text-center'>Retrouvez ici les pages utilisées dans le projet et leur utilité</p>
    </div>
  </div>
</header>

<section class='flex-grow-1 container my-5'>
  <div class='table-responsive'>
    <table class='table table-bordered table-hover'>
      <thead class='table-dark'>
        <tr>
          <th>Nom</th>
          <th>Fichier ou Lien</th>
          <th>Description / Utilité</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Connexion</td>
          <td>portail_connexion.php</td>
          <td>Permet aux utilisateurs de se connecter à l’intranet avec leurs identifiants.</td>
        </tr>
        <tr>
          <td>Accueil</td>
          <td>accueil_intranet.php</td>
          <td>Page d’accueil après connexion, point de départ vers les autres sections.</td>
        </tr>
        <tr>
          <td>Annuaire</td>
          <td>annuaire.php</td>
          <td>Affiche les informations des utilisateurs enregistrés.</td>
        </tr>
        <tr>
          <td>Gestion des fichiers</td>
          <td>gestion_fichier.php</td>
          <td>Page prévue pour ajouter ou consulter des fichiers partagés.</td>
        </tr>
        <tr>
          <td>Wiki</td>
          <td>wiki.php</td>
          <td>Page actuelle contenant la documentation et l’explication des fichiers utilisés.</td>
        </tr>
        <tr>
          <td>Déconnexion</td>
          <td>portail_deconnexion.php</td>
          <td>Termine la session utilisateur et redirige vers la page de connexion.</td>
        </tr>
        <tr>
          <td>Stack Overflow</td>
          <td><a href='https://stackoverflow.com' target='_blank'>stackoverflow.com</a></td>
          <td>Site d’entraide pour développeurs utilisé pour résoudre des problèmes de code, trouver des exemples ou comprendre des erreurs.</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<footer class='bg-dark text-white text-center py-3'>
  <div class='container'>
    <p>&copy; ". date('Y') ." Intranet. Tous droits réservés.</p>
  </div>
</footer>
</body>
</html>";
?>
