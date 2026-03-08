# Exam Final PHP

## Ethan MACHORO B2 YNOV


## Fonctionnalités Principales

### Pour les Utilisateurs
- **Inscription et Connexion** : Créez un compte avec nom d'utilisateur, email et mot de passe. Connexion sécurisée.
- **Voir les Articles** : Page d'accueil avec tous les articles en vente, triés par date (les plus récents en premier).
- **Détails des Articles** : Cliquez sur un article pour voir sa description, prix, et auteur.
- **Vendre un Article** : Les utilisateurs connectés peuvent mettre en vente leurs propres articles.
- **Panier** : Ajoutez des articles au panier (stocké en session pour le moment).
- **Mon Compte** : Voir vos informations personnelles (nom, email, rôle).
- **Validation de Commande** : Validez votre panier en entrant une adresse de livraison. Le système vérifie votre solde et met à jour le stock.

### Pour les Administrateurs
- Accès à une page admin (actuellement vide, mais réservée pour de futures fonctionnalités comme gérer les utilisateurs ou articles).


## Structure de la Base de Données

Le fichier `php_exam_db.sql` contient le schéma et des données.

Voici les tables principales :

- **user** : Utilisateurs (id, username, email, mdp hashé, solde, photo, rôle)
- **article** : Articles en vente (id, name, description, price, created_at, author_id, lienImage)
- **cart** : Panier (id, idUser, idArticle) - Note : actuellement, le panier utilise les sessions PHP, pas cette table.
- **invoice** : Factures (id, idUser, dateTransaction, montant, adresseFacture, villeFacture, codePastalFacture)
- **stock** : Stock des articles (id, idArticle, nbArticle)

## Installation et Configuration

### Prérequis
- Serveur web (XAMPP)
- PHP 8.0
- MySQL
- Navigateur web

### Étapes d'Installation
1. **Téléchargez ou clonez le projet** dans le dossier htdocs de votre serveur pour moi c'était `/xampp/htdocs/php_exam`.

2. **Importez la base de données** :
   - Ouvrez phpMyAdmin (ou votre outil MySQL).
   - Créez une nouvelle base de données nommée `php_exam_db`.
   - Importez le fichier `php_exam_db.sql` fourni.

3. **Configurez la connexion** :
   - Ouvrez `config.php`.
   - Vérifiez les paramètres de connexion :
     ```php
     $host   = 'localhost';
     $dbname = 'php_exam_db';
     $user   = 'root';  // Changez si nécessaire
     $pass   = 'root';  // Changez si nécessaire
     ```
   - Si ton mot de passe MySQL est différent, modifiez-le ici.

4. **Démarrez le serveur** :
   - Lancez Apache et MySQL via XAMPP.
   - Accédez au site via `http://localhost/php_exam/home.php`.

### Utilisation
- Allez sur `home.php` pour commencer.
- Inscrivez-vous ou connectez-vous.
- Explorez les articles, vendez-en, ajoutez au panier, etc.

## Points à Améliorer (Notes d'Étudiant)


## Auteur

Ethan MACHORO B2 YNOV