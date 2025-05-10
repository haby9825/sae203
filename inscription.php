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
        <h1>Bienvenue</h1>
        <p class="inscription">Vous possédez déjà un compte ? <a href="connexion.php">Compte existant</a></p>
    </div>
    
    <div class="right">
        <form method="post">
            <h2>Authentification</h2>
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" placeholder="Nom" required>
            <label for="name">Prénom</label>
            <input type="text" name="name" placeholder="Prénom" required>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="S'inscrire">
        </form>
      </div>
</div>
</body>
</html>


<?php
$link=mysqli_connect("localhost","habycoulibaly_203","~01rH!EJ^fbg","habycoulibaly_sae203");
    if (!$link) {
        die(mysqli_connect_error());
    } 

if (isset($_POST["name"]) && isset($_POST["lastname"])) {
    $lastname=$_POST["lastname"];
    $name=$_POST["name"];
    $email=$_POST["email"];
    $password=$_POST['password'];
$res=mysqli_query($link,"select * from clients where email='$email'");

if (mysqli_num_rows($res)>0){
    header("Location:connexion.php");
    exit();
} 
 else {
    $req="insert into clients (lastname,name,email,password) values ('$lastname','$name','$email','$password')";
    if (mysqli_query($link,$req))
    {  
        echo "<script>alert('Compte existant');</script>";
        header("Location:index.php");
        exit(); 
    }
    else 
    { echo mysqli_error($link); }
 }
}
 else {

} 
?>