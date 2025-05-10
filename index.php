<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Site de réservation</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<header>
<div class="menu">
      <nav>
        <a href="index.php">Accueil</a>
        <a href="dashboard.php">Administration</a>
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
  </header>
  

    <form method="GET" class="filter-form">
        <div class="filter-group">
            <label for="min_price">Prix min (€) :</label>
            <input type="number" id="min_price" name="min_price" value="<?php echo ($min_price ?: ''); ?>" step="0.01" min="0">
        </div>
        <div class="filter-group">
            <label for="max_price">Prix max (€) :</label>
            <input type="number" id="max_price" name="max_price" value="<?php echo ($max_price == 9999999 ? '' : $max_price); ?>" step="0.01" min="0">
        </div><br>
        <!--<div class="filter-group">-->
        <!--    <label for="availability_status">Afficher les objets indisponibles :</label>-->
        <!--    <input type="checkbox" id="availability_status" name="availability_status" <?php echo isset($_GET['availability_status']) ? 'checked' : ''; ?>>-->
        <!--</div>-->
            <button type="submit" class="input">Filtrer</button>
            <a href="products.php" class="input">Réinitialiser</a>
    </form>
            

<?php
$min_price=$_GET['min_price'] ?? 0;
$max_price=$_GET['max_price'] ?? 9999999;

$link=mysqli_connect("localhost", "habycoulibaly_203", "~01rH!EJ^fbg", "habycoulibaly_sae203");
    if (!$link) {
        die(mysqli_connect_error());
}

$res=mysqli_query($link, ($min_price > 0 || $max_price < 9999999) ? "SELECT * FROM products WHERE price BETWEEN $min_price AND $max_price" : "SELECT * FROM products");
    echo '<main>';
    while ($data=mysqli_fetch_assoc($res)) { 
    echo '<div class="product">
        <div class="vitrine">
            <img src="img/'.$data['img'].'" alt="'.$data['product_name'].'" class="zoom">
            <p class="availability_status">'.$data['availability_status'].'</p>
            <p class="stock">'.$data['stock'].' place(s) restante(s)</p>
        </div>
            
        <div class="product-details">
            <div class="info">
                <h1>'.$data['product_name'].'</h1>
                <p class="price">'.$data['price'].' €</p>
                <div class="features">
                <p class="climate">Climat: '.$data['climate'].'</p>
                <p class="wildlife">Faune: '.$data['wildlife'].'</p>
                <p class="flora">Flore: '.$data['flora'].'</p>
                <p class="danger_level">Niveau de dangerosité: '.$data['danger_level'].'</p>
                </div>
            </div>
            <div class="action">
            <br>'; ?>
    <a href="product.php?id=<?php echo $data['product_id'];?>" class="input">Voir détails</a>
            <?php echo '</div>
        </div>
    </div>'; 
}
    echo "</main>";
?>

<footer>
  <div class="container"> 
    <section>
      <h2>entreprise</h2>
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
  <p class="credit">entreprise © 2025. Tous droits réservés.</p>
</footer>
</body>