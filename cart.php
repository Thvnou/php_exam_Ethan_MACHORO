<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if ($mysqli->connect_error) {
    die("Erreur BDD");
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $mysqli->prepare("SELECT * FROM article WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $article = $result->fetch_assoc();

    if ($article) {
        $_SESSION['cart'][] = $article;
    }
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Panier</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Mon panier</h2>

<table class="table table-bordered">

<thead class="table-dark">
<tr>
<th>Article</th>
<th>Prix</th>
</tr>
</thead>

<tbody>

<?php foreach ($_SESSION['cart'] as $item): ?>

<tr>

<td><?php echo $item['nom']; ?></td>

<td><?php echo $item['prix']; ?> €</td>

</tr>

<?php $total += $item['prix']; ?>

<?php endforeach; ?>

</tbody>

</table>

<h4>Total : <?php echo $total; ?> €</h4>

<a href="cart.php?clear=1" class="btn btn-danger mt-3">
Vider le panier
</a>

<a href="home.php" class="btn btn-secondary mt-3">
Retour accueil
</a>

</div>

</body>
</html>
