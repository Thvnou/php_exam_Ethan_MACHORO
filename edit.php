<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("UPDATE article SET name=?, description=?, price=? WHERE id=?");

    $stmt->bind_param("ssdi", $name, $description, $prix, $id);
    $stmt->execute();

    header("Location: details.php?id=" . $id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Modifier article</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto" style="max-width:600px">

<div class="card-header bg-warning text-dark text-center">
<h3>Modifier l'article</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Nom</label>
<input type="text" name="name" class="form-control"
value="<?php echo htmlspecialchars($article['name'] ?? ''); ?>" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" required><?php echo htmlspecialchars($article['description']); ?></textarea>
</div>

<div class="mb-3">
<label>Prix</label>
<input type="number" step="0.01" name="price" class="form-control"
value="<?php echo $article['price'] ?? ''; ?>" required>
</div>

<button class="btn btn-warning w-100 mb-2">
Modifier l'article
</button>

<a href="home.php" class="btn btn-secondary w-100">
Retour accueil
</a>

</form>

</div>

</div>

</div>

</body>
</html>
