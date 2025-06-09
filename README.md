
# Application E-Commerce Simple en PHP Native

## Description

Cette application e-commerce simple est développée en PHP natif avec MySQL comme base de données. Elle comprend deux interfaces principales :  

- **Interface Utilisateur (User)** :  
  Les utilisateurs peuvent créer un compte, se connecter, consulter tous les produits, filtrer par catégorie, ajouter des produits dans un panier, passer une commande et consulter leur historique de commandes.

- **Interface Administrateur (Admin)** :  
  L'administrateur peut gérer les utilisateurs (activer ou désactiver les comptes), gérer les produits (CRUD), gérer les catégories de produits (CRUD) et gérer les commandes.

---

## Fonctionnalités

### Utilisateur (User)

- Inscription / Connexion
- Consultation des produits
- Filtrage par catégorie
- Ajout au panier
- Passer une commande
- Voir l’historique des commandes

### Administrateur (Admin)

- Gestion des utilisateurs (activation / désactivation)
- Gestion des produits (Créer, Lire, Modifier, Supprimer)
- Gestion des catégories (CRUD)
- Gestion des commandes

---

## Installation

1. Clonez ou téléchargez ce dépôt.

    ```
    git clone git@github.com:Zeini-23025/e-commerce.git
    ```
  
2. Configurez la base de données MySQL :

   - Créez une base de données (ex : `ecommerce_db`)
   - Importez le fichier SQL `ecommerce.sql` fourni (ou créez les tables manuellement selon le script SQL)

3. Configurez la connexion à la base de données dans le fichier `db_conn.php`:

```php
<?php
$host = "localhost";
$dbname = "ecommerce_db";
$username = "root";
$password = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
```

4. Placez les fichiers dans votre serveur local (XAMPP, WAMP, MAMP, etc.).

5. Accédez à l'application via votre navigateur :  
   - Interface utilisateur : `http://localhost/ton-projet/user`  
   - Interface administrateur : `http://localhost/ton-projet/admin`

---

## Technologies utilisées

- PHP natif
- MySQL
- HTML / CSS / JavaScript

---

## Structure du projet

```
/admin          # Interface administrateur
/user           # Interface utilisateur
/config         # Configuration base de données
/src            # les filles html , css , php
/uploads         # les images 
/database.sql   # Script SQL pour créer la base de données et les tables
```

---

## Remarques

- Sécurisez bien vos formulaires contre les injections SQL.
- Les sessions PHP sont utilisées pour gérer les connexions.
- Le projet est basique et peut être étendu selon vos besoins.

---

## Contact

Pour toute question, contactez-moi à : **zeiny.cheikh.dev@gmail.com**

---

Merci d'utiliser cette application !
