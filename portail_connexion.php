<?php
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant_saisi = $_POST['utilisateur'] ?? '';
    $motdepasse_saisi = $_POST['motdepasse'] ?? '';

    $jsonData = file_get_contents('./annuaire_utilisateurs.json');
    $utilisateurs = json_decode($jsonData, true);

    $trouve = false;

    foreach ($utilisateurs as $utilisateur) {
        $motdepassebon = password_verify($motdepasse_saisi, $utilisateur['motdepasse']);
        if ($utilisateur['utilisateur'] === $identifiant_saisi && $motdepassebon) {
            $_SESSION['nom'] = $utilisateur['utilisateur'];
            $_SESSION['role'] = $utilisateur['role'];
            $trouve = true;
            header("Location: accueil_intranet.php");
            exit();
        }
    }

    if (!$trouve) {
        $message = "<p class='text-danger text-center mt-3'>Identifiants ou mot de passe incorrects.</p>";
    }
}

echo "
<!DOCTYPE html>
<html lang='fr'>
<head>
  <title>INTRANET</title>
  <link rel='icon' href=''>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
</head>
<body class='d-flex flex-column min-vh-100'>

<header>
    <div class='text-center p-5 bg-secondary text-white'>
        <h1>Connectez-vous à l'intranet de GMG Construction</h1>
    </div>
</header>

<section class='flex-grow-1 d-flex justify-content-center align-items-center'>
    <div class='container' style='max-width: 400px;'>
        <form action='' method='post' class='w-100'>
            <div class='form-group mb-3'>
                <label>Utilisateur</label>
                <input type='text' class='form-control' name='utilisateur' placeholder='Utilisateur' required>
            </div>
            <div class='form-group mb-3'>
                <label>Mot de passe</label>
                <input type='password' class='form-control' name='motdepasse' placeholder='Mot de passe' required>
            </div>
            <button type='submit' class='btn btn-primary w-100'>Se connecter</button>
            $message
        </form>
    </div>
</section>

<footer class='mt-auto p-5 bg-secondary text-dark text-center'>
    <p>footer</p>
</footer>

</body>
</html>";
?>
