<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if ($mysqli->connect_error) {
    die("Erreur connexion BDD");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT username, email, rôle FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Mon compte</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto" style="max-width:500px">

<div class="card-header bg-primary text-white text-center">
<h3>Mon compte</h3>
</div>

<div class="card-body">

<p><strong>Nom utilisateur :</strong> <?php echo $user['username']; ?></p>

<p><strong>Email :</strong> <?php echo $user['email']; ?></p>

<p><strong>Role :</strong> <?php echo $user['rôle']; ?></p>

<hr>

<a href="home.php" class="btn btn-secondary w-100 mb-2">
Retour accueil
</a>

<a href="logout.php" class="btn btn-danger w-100">
Se déconnecter
</a>

</div>

</div>

</div>

</body>
</html>
