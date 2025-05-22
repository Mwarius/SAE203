<?php session_start();

$identifiant_saisi = $_POST['utilisateur'];
$motdepasse_saisi = $_POST['motdepasse'];
echo "<pre>";
print_r($_POST);
echo "<pre>";

$jsonData = file_get_contents('./annuaire_utilisateurs.json');
$utilisateurs = json_decode($jsonData, true);

$trouve = false;

foreach ($utilisateurs as $utilisateur) {
    $motdepassebon=password_verify($motdepasse_saisi, $utilisateur['motdepasse']);
    if ($utilisateur['utilisateur'] == $identifiant_saisi && $motdepassebon==1) {
        $_SESSION['nom'] = $utilisateur['utilisateur'];
        $_SESSION['role'] = $utilisateur['role'];
        $trouve = true;
        echo "<h1>yesss</h1>";
        echo "<pre>";
        print_r($_SESSION);
        echo "<pre>";
        header("Location:accueil_intranet.php");
        break;        
    }
}

if ($trouve) {
    echo "Connexion réussie. Bonjour " . htmlspecialchars($_SESSION['nom']) . " (" . htmlspecialchars($_SESSION['role']) . ")<br>";
} else {
    echo "Identifiants incorrects.<br>";
}

echo "<a href='portail_connexion.php'>Retour à l'accueil</a>";
?>