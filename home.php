<?php
// Connexion a la database
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if ($mysqli->connect_error) die("Erreur BDD : " . $mysqli->connect_error);

session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home - E-Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">E-Shop PHP</a>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="sell.php" class="btn btn-outline-light me-2">Vendre un article</a>
                <a href="cart.php" class="btn btn-outline-light me-2">Panier</a>
                <a href="account.php" class="btn btn-outline-light me-2">Mon compte</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="admin.php" class="btn btn-warning me-2">Admin</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-light me-2">Connexion</a>
                <a href="register.php" class="btn btn-success">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="mb-4">Articles en vente (les plus récents en premier)</h1>

    <div class="row">
        <?php
        
        $result = $mysqli->query("SELECT a.*, u.username 
                                FROM article a 
                                JOIN user u ON a.author_id = u.id 
                                ORDER BY a.id DESC");



        if ($result->num_rows === 0):
        ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Aucun article en vente pour le moment.<br>
                    <a href="sell.php" class="btn btn-success mt-3">Mets en vente ton premier article !</a>
                </div>
            </div>
        <?php else: 
            while ($row = $result->fetch_assoc()):
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($row['lienImage'] ?? 'uploads/default.jpg') ?>" 
                         class="card-img-top" style="height: 200px; object-fit: cover;" alt="Image article">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                        <p class="card-text text-muted">
                            <?= number_format($row['price'], 2) ?> €<br>
                            par <strong><?= htmlspecialchars($row['username']) ?></strong>
                        </p>
                        <a href="details.php?id=<?= $row['id'] ?>">
                            Voir le détail
                        </a>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        endif; 
        ?>
    </div>
</div>
</body>
</html>