<?php
session_start();
if (!isset($_SESSION['prenom'])){
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
          if (isset($_SESSION['prenom']) && isset($_SESSION['nom']) && isset($_SESSION['groupe'])) {
            echo "<span class='text-light me-2'>Connecté en tant que ". htmlspecialchars($_SESSION['prenom']) ." ". htmlspecialchars($_SESSION['nom']) .", ". implode(", ", $_SESSION['groupe']) ."</span>";
            echo "<a href='./portail_deconnexion.php' class='btn btn-outline-light btn-sm'>Se déconnecter</a>";
          }
          echo "
        </div>
      </div>
    </div>
  </nav>
  <div class='jumbotron jumbotron-fluid p-5 bg-primary text-white'>
    <div class='container'>
      <h1 class='text-center'>Bienvenue dans l'annuaire</h1>
    </div>
  </div>
</header>
<section class='flex-grow-1 d-flex justify-content-center align-items-center'>
  <table>";
  $compteurTable = 1;
  $jsonUser = json_decode(file_get_contents("data\annuaire_utilisateurs.json"));
  for ($i=0; $i < sizeof($jsonUser); $i++){
    if ($compteurTable == 1){
      echo "<tr>";
    };
    $userActuel = (array)($jsonUser[$i]);
    echo "<td>
            <div class='card'>
              <div class='card-header'><h1> ".$userActuel["prenom"]." ".$userActuel["nom"]." </h1></div>
              <div class='card-body'><img src=".$userActuel["photo"]." alt='User $i' style='height: 200px'><p> ".$userActuel['description']." </p>
              <div class='card-footer text-secondary'><p> ".$userActuel["fonction"]." </p>
          </td>";
    if ($compteurTable == 3){
      echo "</tr>";
      $compteurTable = 1;
    }
    else{
      $compteurTable+= 1;
    }
    
  }
echo "</table>
</section>
<footer class='bg-dark text-white text-center py-3'>
  <div class='container'>
    <p>&copy; ". date('Y') ." Intranet. Tous droits réservés.</p>
  </div>
</footer>
</html>"
?>
