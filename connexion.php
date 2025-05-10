<?php session_start(); 
error_reporting(0); 
ini_set('display_errors', 0);?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Site de réservation</title>
<link rel="stylesheet" href="connexion_style.css">
</head>
<body>
    

<div class="container">
  <div class="left">
    <h1>Bon retour</h1>
    <p class="inscription">Vous n'avez pas de compte ? <a href="inscription.php">Créer un compte</a></p>
  </div>

  <div class="right">
    <h2>Authentification</h2>
    <form method="post">
      <label for="email">Email</label>
      <input type="text" id="email" name="email" placeholder="Email" required>
      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" placeholder="Mot de passe" required>
      <input type="submit" Value="Se connecter">
    </form>
  </div>
</div>

<?php 
if (isset($_POST["email"]) && isset($_POST["password"])) {
$email=$_POST["email"];
$password=$_POST["password"]; 
$link = mysqli_connect("localhost", "habycoulibaly_203", "~01rH!EJ^fbg", "habycoulibaly_sae203");
    if (!$link) {
        die(mysqli_connect_error());
    }
$res=mysqli_query($link,"select * from clients where email='$email'");
$data=mysqli_fetch_assoc($res);

if ($data && $_POST['password']==$data['password']){
        $_SESSION['client_id']=$data['client_id'];
        $_SESSION['client_name']=$data['name'];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Email ou mot de passe incorrect');</script>";
    }
}
?>

</body>
</html>


