<?php session_start(); 
error_reporting(0); 
ini_set('display_errors', 0);?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Site de réservation</title>
<link rel="stylesheet" href="styles.css">
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
  </div>
</header>

<?php
$link = mysqli_connect("localhost", "habycoulibaly_203", "~01rH!EJ^fbg", "habycoulibaly_sae203");
if (!$link) {
    die(mysqli_connect_error());
}
$id = $_GET['id'];
$res = mysqli_query($link, "SELECT * FROM products WHERE product_id='$id'");
$data = mysqli_fetch_assoc($res);
if (isset($_GET['id']) && $data):
?>
<div class="product-page">
  <h1><?php echo $data['product_name']; ?></h1>
  <p class="availability_status"><?php echo ($data['stock'] <= 0 ? 'Non disponible' : $data['availability_status']); ?></p>
  <main>
    <img src="img/<?php echo $data['img']; ?>" alt="<?php echo $data['product_name']; ?>">
    <section class="info">
      <p class="price"><?php echo $data['price']; ?> €</p>
      <p class="description"><?php echo $data['description']; ?></p>

<?php if (!isset($_SESSION['client_id'])): ?>
  <p>Vous devez être connecté pour réserver ce produit.</p>
<?php else: ?>
<form method="POST">
  <div class="form-dates">
    <div>
      <label for="start_date">Date de début de réservation :</label>
      <input type="date" id="start_date" name="start_date" required>
    </div>
    <div>
      <label for="end_date">Date de fin de réservation :</label>
      <input type="date" id="end_date" name="end_date" required>
    </div>
  </div>
  <button type="submit" name="reserve" class="input">Réserver le Sac</button>
</form>
<?php
if (isset($_POST['reserve'])){
    $client_id = $_SESSION['client_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = $data['price'];
    $product_id = $data['product_id'];

    if ($data['stock'] >= 1 && $data['availability_status'] == 'Disponible') {
        $req = mysqli_query($link, "INSERT INTO reservations (client_id, start_date, end_date, reservation_date, price) VALUES ('$client_id','$start_date','$end_date',CURDATE(),'$price')");
        $reserv_id = mysqli_insert_id($link);
        $req2 = mysqli_query($link, "INSERT INTO lienrp (reserv_id, product_id) VALUES ('$reserv_id','$product_id')");
        $req3 = mysqli_query($link, "UPDATE products 
            SET stock = stock - 1, 
            availability_status = CASE 
                WHEN (stock - 1) <= 0 THEN 'Non disponible' 
                ELSE 'Disponible' 
            END 
            WHERE product_id='$product_id' AND stock > 0");
        echo '<p>Réservation réussie.</p>';
        echo '</section></main></div>';
        header("Location: confirmation.php");
        exit;
    } else {
        echo '<p>Produit indisponible.</p>';
    }
}
?>
<?php endif; ?>
    </section>
  </main>
</div>
<?php else: ?>
<p>Produit non trouvé</p>
<?php endif; ?>

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
</html>
