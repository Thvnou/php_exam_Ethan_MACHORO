<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if ($mysqli->connect_error) die("Erreur BDD");

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

// Récupération du total du panier
$total = 0;
$result = $mysqli->query("SELECT SUM(a.prix * c.quantite) as total 
                          FROM cart c 
                          JOIN article a ON c.id_article = a.id 
                          WHERE c.id_user = " . $_SESSION['user_id']);
if ($row = $result->fetch_assoc()) {
    $total = $row['total'] ?? 0;
}

// Récupération du solde
$userResult = $mysqli->query("SELECT solde FROM user WHERE id = " . $_SESSION['user_id']);
$user = $userResult->fetch_assoc();
$solde = $user['solde'] ?? 0;

// Validation de la commande
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse     = trim($_POST['adresse']);
    $ville       = trim($_POST['ville']);
    $code_postal = trim($_POST['code_postal']);

    if ($total > $solde) {
        $error = "Solde insuffisant !";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO invoice (id_user, montant, adresse, ville, code_postal) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $_SESSION['user_id'], $total, $adresse, $ville, $code_postal);
        $stmt->execute();
        $invoice_id = $mysqli->insert_id;

        $new_solde = $solde - $total;
        $mysqli->query("UPDATE user SET solde = $new_solde WHERE id = " . $_SESSION['user_id']);

        $cartItems = $mysqli->query("SELECT id_article, quantite FROM cart WHERE id_user = " . $_SESSION['user_id']);
        while ($item = $cartItems->fetch_assoc()) {
            $mysqli->query("UPDATE stock SET quantite = quantite - " . $item['quantite'] . " WHERE id_article = " . $item['id_article']);
        }
        $mysqli->query("DELETE FROM cart WHERE id_user = " . $_SESSION['user_id']);

        header("Location: account.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation commande - E-Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">E-Shop PHP</a>
        <div>
            <a href="home.php" class="btn btn-outline-light me-2">Accueil</a>
            <a href="cart.php" class="btn btn-outline-light me-2">Retour au panier</a>
            <a href="account.php" class="btn btn-outline-light me-2">Compte</a>
            <a href="logout.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container" style="max-width: 700px;">
    <h1>Validation de la commande</h1>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <h4>Total : <strong><?= number_format($total, 2) ?> €</strong></h4>
            <p>Solde actuel : <strong><?= number_format($solde, 2) ?> €</strong></p>

            <?php if ($total > 0): ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Adresse</label>
                        <input type="text" name="adresse" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ville</label>
                            <input type="text" name="ville" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Code postal</label>
                            <input type="text" name="code_postal" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 mt-4">
                        Valider la commande
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
