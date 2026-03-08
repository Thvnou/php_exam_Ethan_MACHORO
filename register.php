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
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Vérifier si username ou email existe déjà
    $stmt = $mysqli->prepare("SELECT id FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {

        $error = "Username ou email déjà utilisé !";

    } else {

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $role = "user";
        $solde = 0;

        // ⚠ correction ici : mdp au lieu de password
        $stmt = $mysqli->prepare("INSERT INTO user (username, email, mdp, solde, `rôle`) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssis", $username, $email, $hash, $solde, $role);

        if ($stmt->execute()) {

            // connexion automatique
            $_SESSION['user_id'] = $mysqli->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            header("Location: home.php");
            exit;

        } else {

            $error = "Erreur lors de la création du compte";

        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription - E-Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto" style="max-width: 500px;">

<div class="card-header text-center bg-success text-white">
<h3>Inscription</h3>
</div>

<div class="card-body">

<?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Mot de passe</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" class="btn btn-success w-100">
Créer mon compte
</button>

</form>

<p class="text-center mt-3">
Déjà un compte ? <a href="login.php">Connecte-toi</a>
</p>

</div>
</div>
</div>

</body>
</html>
