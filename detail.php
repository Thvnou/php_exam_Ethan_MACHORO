<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if ($mysqli->connect_error) {
    die("Erreur BDD");
}

if (!isset($_GET['id'])) {
    die("Article introuvable");
}

$id = $_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM article WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$article = $result->fetch_assoc();

if (!$article) {
    die("Article non trouvé");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Détails article</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto" style="max-width:600px">

<div class="card-header bg-dark text-white text-center">
<h3><?php echo $article['name']; ?></h3>
</div>

<div class="card-body">

<p><strong>Description :</strong></p>

<p><?php echo $article['description']; ?></p>

<hr>

<p><strong>Prix :</strong> <?php echo $article['price']; ?> €</p>

<hr>

<a href="cart.php?id=<?php echo $article['id']; ?>" class="btn btn-success w-100 mb-2">
Ajouter au panier
</a>

<a href="edit.php?id=<?php echo $article['id']; ?>" class="btn btn-warning w-100">
Modifier
</a>


<a href="home.php" class="btn btn-secondary w-100">
Retour accueil
</a>

</div>

</div>

</div>

</body>
</html>
