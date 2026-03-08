<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if ($mysqli->connect_error) die("Erreur BDD : " . $mysqli->connect_error);

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, username, mdp, `rôle` FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {

        if (password_verify($password, $user['mdp'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['rôle']; // on stocke le rôle en session

            header("Location: home.php");
            exit;
        }
    }

    $error = "Identifiants incorrects";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion - E-Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto" style="max-width: 500px;">

<div class="card-header text-center bg-primary text-white">
<h3>Connexion</h3>
</div>

<div class="card-body">

<?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">

<div class="mb-3">
<label>Username ou Email</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Mot de passe</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary w-100">
Se connecter
</button>

</form>

<p class="text-center mt-3">
Pas encore de compte ? <a href="register.php">Inscris-toi</a>
</p>

</div>
</div>
</div>

</body>
</html>
