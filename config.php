<?php
// Ce fichier sert à connecter PHP à ta base de données
// Tu le mettras en include en haut de TOUTES les pages

session_start(); // Obligatoire pour gérer la connexion utilisateur

$host   = 'localhost';
$dbname = 'php_exam_db';     // ← CHANGE ÇA si tu as donné un autre nom à ta DB (ex: mon_projet)
$user   = 'root';
$pass   = 'root';            // Sur XAMPP c’est souvent "root". Si ça ne marche pas, mets ''

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Erreur connexion BDD : " . $mysqli->connect_error);
}
?>