<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['identifiant'])) {
    header("Location: portail_connexion.php");
    exit();
}

$fichier_utilisateurs = "./data/annuaire_utilisateurs.json";
$utilisateurs = [];

$contenu_fichier = file_get_contents($fichier_utilisateurs);
$utilisateurs = json_decode($contenu_fichier, true);

$identifiant_actuel = $_SESSION['identifiant'];
$index_utilisateur = -1;

for ($i = 0; $i < count($utilisateurs); $i++) {
    if ($utilisateurs[$i]['identifiant'] == $identifiant_actuel) {
        $index_utilisateur = $i;
        break;
    }
}

$utilisateur = ['prenom' => '','nom' => '','identifiant' => '','email' => '','fonction' => '','groupe' => [],'photo' => ''];

if ($index_utilisateur >= 0) {
    $utilisateur = $utilisateurs[$index_utilisateur];

    // Ajout des données dans $_SESSION
    $_SESSION['prenom'] = $utilisateur['prenom'];
    $_SESSION['nom'] = $utilisateur['nom'];
    $_SESSION['fonction'] = $utilisateur['fonction'];
}

$message = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $index_utilisateur >= 0) {
    $email_saisi = $_POST['email'];
    $motdepasse1 = $_POST['new_password'];
    $motdepasse2 = $_POST['confirm_password'];

    if ($motdepasse1 != "" && $motdepasse1 != $motdepasse2) {
        $message = "<div class='alert alert-danger text-center'>Les mots de passe ne correspondent pas.</div>";
    } else {
        if ($motdepasse1 != "") {
            $utilisateurs[$index_utilisateur]['motdepasse'] = password_hash($motdepasse1, PASSWORD_DEFAULT);
        }

        $utilisateurs[$index_utilisateur]['email'] = filter_var($email_saisi, FILTER_SANITIZE_EMAIL);

        $fichier_modifier = file_put_contents($fichier_utilisateurs, json_encode($utilisateurs, JSON_PRETTY_PRINT));

        if ($fichier_modifier) {
            $message = "<div class='alert alert-success text-center'>Profil mis à jour avec succès.</div>";
        } else {
            $message = "<div class='alert alert-danger text-center'>Erreur lors de la mise à jour du profil.</div>";
        }
    }
}

// Préparer les données d'affichage
$photo = './image/utilisateur_par_defaut.png';
if (!empty($utilisateur['photo'])) {
    $photo = htmlspecialchars($utilisateur['photo']);
}

$prenom = htmlspecialchars($utilisateur['prenom']);
$nom = htmlspecialchars($utilisateur['nom']);
$identifiant = htmlspecialchars($utilisateur['identifiant']);
$email = htmlspecialchars($utilisateur['email']);
$fonction = htmlspecialchars($utilisateur['fonction']);
$groupes = implode(', ', $utilisateur['groupe']);
$description = isset($utilisateur['description']) ? htmlspecialchars($utilisateur['description']) : '';
$annee = date("Y");




echo "
<!DOCTYPE html>
<html lang='fr'>
<head>
  <meta charset='utf-8'>
  <title>INTRANET</title>
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
            echo "<span class='text-light me-2'>Connecté en tant que ". htmlspecialchars($_SESSION['prenom']) . " ". htmlspecialchars($_SESSION['nom']) . ", ". htmlspecialchars($_SESSION['fonction']). "</span>";
            echo "<a href='./portail_deconnexion.php' class='btn btn-outline-light btn-sm'>Se déconnecter</a>";
          }
        echo "
        </div>
      </div>
    </div>
  </nav>
  <div class='bg-primary text-white py-5 text-center'>
    <h1>Bienvenue sur l'Intranet de GMG Construction</h1>
    <p>Votre espace de travail collaboratif</p>
  </div>
</header>
<main class='flex-grow-1 py-5'>
  <div class='container'>
    <h1 class='mb-4 text-center'>Profil de l'utilisateur</h1>
    <div class='row justify-content-center'>
      <div class='col-md-4 text-center'>
        <img src='$photo' alt='Photo de profil' class='img-thumbnail mb-3'>
      </div>
      <div class='col-md-6'>
        <form method='post'>
          <p><strong>Prénom :</strong> $prenom</p>
          <p><strong>Nom :</strong> $nom</p>
          <p><strong>Identifiant :</strong> $identifiant</p>
          <p><strong>Email :</strong> $email</p>
          <div class='mb-3'>
            <label for='description' class='form-label'>Description :</label>
            <textarea type='description' class='form-control' id='description' name='description' rows='5' value='$description'></textarea>
          </div>
          <div class='mb-3'>
            <label for='new_password' class='form-label'>Nouveau mot de passe :</label>
            <input type='password' class='form-control' id='new_password' name='new_password'>
          </div>
          <div class='mb-3'>
            <label for='confirm_password' class='form-label'>Confirmer le mot de passe :</label>
            <input type='password' class='form-control' id='confirm_password' name='confirm_password'>
          </div>
          <p><strong>Fonction :</strong> $fonction</p>
          <p><strong>Groupes :</strong> $groupes</p>
          $message
          <button type='submit' class='btn btn-primary'>Mettre à jour</button>
        </form>
      </div>
    </div>
  </div>
</main>
<footer class='bg-dark text-white text-center py-3'>
  <div class='container'>
    <p>&copy; $annee Intranet. Tous droits réservés.</p>
  </div>
</footer>
</body>
</html>
";
?>
