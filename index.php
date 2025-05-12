<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site de réservation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="stars"></div>

<header>
    <div class="menu">
        <nav>
            <a href="index.php">Accueil</a>
            <a href="reservation.php">Mes réservations</a>
            <?php $Admin=isset($_SESSION['client_id']) && $_SESSION['client_id']==='13';
            if ($Admin) {
            echo '<a href="dashboard.php">Administration</a>';
            } ?>
        </nav>
        
        <div class="button">
            <?php if (!isset($_SESSION['client_id'])): ?>
                <a href="inscription.php" class="button sinscrire">S'inscrire</a>
                <a href="connexion.php" class="button seconnecter">Se connecter</a>
            <?php else: ?>
                <span class="user">Bonjour, <?php echo $_SESSION['client_name']; ?></span>
                <a href="deconnexion.php" class="button seconnecter">Déconnexion</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<section class="hero">
    <h1>Explorez l’Univers avec Nebulo</h1>
    <p>Réservez des sacs de voyage dimensionnels pour découvrir des planètes lointaines et des univers alternatifs.</p>
</section>

<section class="about">
    <h2>Qu’est-ce que Nebulo ?</h2>
    <p>Nebulo est un site de r2servqtion qui vous permet de réserver des <strong>sacs de voyage dimensionnels</strong>, des dispositifs uniques conçus pour transporter les aventuriers à travers les dimensions et vers des planètes inexplorées.</p>
    <p>Que vous soyez un voyageur aguerri ou un curieux nous cherhcons à rendre l’exploration interdimensionnelle accessible à tous, avec des réservations simples et des destinations soigneusement sélectionnées pour leur beauté et leur mystère.</p>
</section>

<section class="ids">
    <div class="id">
        <h3>1. Choisissez Votre Destination</h3>
        <p>Parcourez notre sélection de planètes et univers, avec des détails sur le climat, la faune et les niveaux de dangerosité.</p>
    </div>
    <div class="id">
        <h3>2. Réservez Votre Sac</h3>
        <p>Sélectionnez vos dates de voyage et réservez votre sac dimensionnel en quelques clics. Connectez-vous pour finaliser.</p>
    </div>
    <div class="id">
        <h3>3. Explorez l’Inconnu</h3>
        <p>Utilisez votre sac pour voyager en toute sécurité vers votre destination. Profitez de l’aventure et revenez avec des souvenirs cosmiques !</p>
    </div>
</section>

<section class="filter-section">
    <form method="GET" class="filter-form">
        <div class="filter-group">
            <label for="min_price">Prix min (€) :</label>
            <input type="number" id="min_price" name="min_price" value="<?php echo ($min_price ?: ''); ?>" step="0.01" min="0">
        </div>
        <div class="filter-group">
            <label for="max_price">Prix max (€) :</label>
            <input type="number" id="max_price" name="max_price" value="<?php echo ($max_price == 9999999 ? '' : $max_price); ?>" step="0.01" min="0">
        </div>
        <div class="filter-buttons">
            <button type="submit" class="input">Filtrer</button>
            <a href="index.php" class="input">Réinitialiser</a>
        </div>
    </form>
</section>

<?php
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 9999999;

$link = mysqli_connect("localhost", "habycoulibaly_203", "~01rH!EJ^fbg", "habycoulibaly_sae203");
if (!$link) {
    die(mysqli_connect_error());
}

$res = mysqli_query($link, ($min_price > 0 || $max_price < 9999999) ? "SELECT * FROM products WHERE price BETWEEN $min_price AND $max_price" : "SELECT * FROM products");
echo '<main>';
while ($data = mysqli_fetch_assoc($res)) {
    echo '<div class="product">
        <div class="vitrine">
            <img src="img/' . $data['img'] . '" alt="' . $data['product_name'] . '" class="zoom">
            <p class="availability_status">' . $data['availability_status'] . '</p>
            <p class="stock">' . $data['stock'] . ' place(s) restante(s)</p>
        </div>
        
        <div class="product-details">
            <div class="info">
                <h1>' . $data['product_name'] . '</h1>
                <p class="price">' . $data['price'] . ' €</p>
                <ul class="features">
                    <li class="climate">Climat: ' . $data['climate'] . '</li>
                    <li class="wildlife">Faune: ' . $data['wildlife'] . '</li>
                    <li class="flora">Flore: ' . $data['flora'] . '</li>
                    <li class="danger_level">Niveau de dangerosité: ' . $data['danger_level'] . '</li>
                </ul>
            </div>
            <div class="action">
                <a href="product.php?id=' . $data['product_id'] . '" class="input">Voir détails</a>
            </div>
        </div>
    </div>';
}
echo "</main>";
?>

<footer>
    <div class="container">
        <section>
            <h2>Nebulo</h2>
            <p>est un service de réservation de sacs de voyage dimensionnels spécialement conçus pour permettre aux clients d’explorer univers alternatifs et planètes lointaines.</p>
        </section>
        <section>
            <h3>Mon Compte</h3>
            <ul>
                <li><a href="#">Mon Compte</a></li>
                <li><a href="#">Commandes</a></li>
            </ul>
        </section>
        <section>
            <h3>Aide</h3>
            <ul>
                <li><a href="#">Contact</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Conditions</a></li>
                <li><a href="#">Confidentialité</a></li>
            </ul>
        </section>
        <section>
            <h3>Catégories</h3>
            <ul>
                <li><a href="#">Sacs de voyage</a></li>
            </ul>
        </section>
    </div>
    <p class="credit">Nebulo © 2025. Tous droits réservés.</p>
</footer>
</body>
</html>
