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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $author_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("INSERT INTO article (name, description, price, author_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssdi", $name, $description, $price, $author_id);

    if ($stmt->execute()) {
        $success = "Article ajouté avec succès";
    } else {
        $error = "Erreur lors de l'ajout";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Vendre un article</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto" style="max-width:600px">

<div class="card-header bg-success text-white text-center">
<h3>Mettre un article en vente</h3>
</div>

<div class="card-body">

<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="POST">

<div class="mb-3">
<label>Nom de l'article</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Prix</label>
<input type="number" step="0.01" name="price" class="form-control" required>
</div>

<button class="btn btn-success w-100">Publier l'article</button>

</form>

</div>
</div>
</div>

</body>
</html>
