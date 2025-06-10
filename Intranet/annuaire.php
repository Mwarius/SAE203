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
          if (isset($_SESSION['prenom']) && isset($_SESSION['nom']) && isset($_SESSION['fonction'])) {
            echo "<span class='text-light me-2'>Connecté en tant que ". htmlspecialchars($_SESSION['prenom']) ." ". htmlspecialchars($_SESSION['nom']) .", ". htmlspecialchars($_SESSION['fonction']) ."</span>";
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
<form method='post'>
  <table align='center'>
    <tr>
      <td><input type='submit' name='utilisateurs' class='border-primary text-primary bg-white' value='Utilisateurs'><td>
      <td><input type='submit' name='partenaires' class='border-primary text-primary bg-white' value='Partenaires'><td>
      <td><input type='submit' name='clients' class='border-primary text-primary bg-white' value='Clients'><td>
    </tr>
  </table>
</form>;
<section class='flex-grow-1 d-flex justify-content-center align-items-center'>";
  

if (isset($_POST['utilisateurs'])){
  echo "<table>";
  $compteurTable = 1;
  $jsonUser = json_decode(file_get_contents("data\annuaire_utilisateurs.json"));
    for ($i=0; $i < sizeof($jsonUser); $i++){
      if ($compteurTable == 1){
        echo "<tr>";
      };
      $userActuel = (array)($jsonUser[$i]);
      echo "<td>
        <div class='card border-black' style='border-radius: 10px;height:500px'>
        <div class='card-header bg-primary text-white' style='border-radius: 8px'><h1> ".$userActuel["prenom"]." ".$userActuel["nom"]." </h1></div>
        <div class='card-body'><img src=".$userActuel["photo"]." alt='User $i' style='width: 350px'><p> ".$userActuel['description']." </p>
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
  echo "</table>";
}
elseif (isset($_POST['partenaires'])){
  echo "<table>";
  $compteurTable = 1;
  $jsonPart = json_decode(file_get_contents("data\annuaire_partenaire.json"));
    for ($i=0; $i < sizeof($jsonPart); $i++){
      if ($compteurTable == 1){
        echo "<tr>";
      };
      $partActuel = (array)($jsonPart[$i]);
      echo "<td>
        <div class='card border-black' style='border-radius: 10px; height: 500px'>
        <div class='card-header bg-primary text-white' style='border-radius: 8px'><h1> ".$partActuel["nom"]." </h1></div>
        <div class='card-body'><img src=".$partActuel["logo"]." alt='Partenaire $i' style='width: 350px'><p> ".$partActuel['description']." </p>
      </td>";
      if ($compteurTable == 3){
        echo "</tr>";
        $compteurTable = 1;
      }
      else{
        $compteurTable+= 1;
      }
    }
  echo "</table>";
}
elseif (isset($_POST['clients'])){
  echo "<table>";
  $compteurTable = 1;
  $jsonClient = json_decode(file_get_contents("data\annuaire_clients.json"));
    for ($i=0; $i < sizeof($jsonClient); $i++){
      if ($compteurTable == 1){
        echo "<tr>";
      };
      $clientActuel = (array)($jsonClient[$i]);
      echo "<td>
        <div class='card border-black' style='border-radius: 10px;height:300px'>
        <div class='card-header bg-primary text-white' style='border-radius: 8px'><h3> ".$clientActuel["nom_client"]."<br>".$clientActuel["projet"]." </h3></div>
        <div class='card-body'><p>".$clientActuel["telephone"]."<br>".$clientActuel["email"]."<br>".$clientActuel["adresse"]."<br>".$clientActuel["statut"]."<br>".$clientActuel['id_client']."</p>
      </td>";
      if ($compteurTable == 4){
        echo "</tr>";
        $compteurTable = 1;
      }
      else{
        $compteurTable+= 1;
      }
    }
  echo "</table>";
}
else{
  echo "<table>";
  $compteurTable = 1;
  $jsonUser = json_decode(file_get_contents("data\annuaire_utilisateurs.json"));
    for ($i=0; $i < sizeof($jsonUser); $i++){
      if ($compteurTable == 1){
        echo "<tr>";
      };
      $userActuel = (array)($jsonUser[$i]);
      echo "<td>
        <div class='card border-black' style='border-radius: 10px;height:500px'>
        <div class='card-header bg-primary text-white' style='border-radius: 8px'><h1> ".$userActuel["prenom"]." ".$userActuel["nom"]." </h1></div>
        <div class='card-body'><img src=".$userActuel["photo"]." alt='User $i' style='width: 350px'><p> ".$userActuel['description']." </p>
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
  echo "</table>";
}

echo "</section>
<footer class='bg-dark text-white text-center py-3'>
  <div class='container'>
    <p>&copy; ". date('Y') ." Intranet. Tous droits réservés.</p>
  </div>
</footer>
</html>"
?>
