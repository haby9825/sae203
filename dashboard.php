<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Site de réservation</title>
<link rel="stylesheet" href="dash_style.css">
</head>
<body>
<aside>
  <nav>
    <ul>
      <li><a href="#dashboard">Tableau de bord</a></li>
      <li><a href="#reservations">Réservations</a></li>
      <li><a href="#clients">Clients</a></li>
      <li><a href="#ajouter">Ajouter</a></li>
      <li><a href="#modifier">Modifier</a></li>
      <li><a href="#supprimer">Supprimer</a></li>
    </ul>
  </nav>
</aside>

<main>
  <section id="dashboard">
    <h1>Tableau de bord</h1>
    <div class="grid">
      <div class="card">
        <h3>Total Produits</h3>
        <h4>
          <?php
            $link=mysqli_connect("localhost","habycoulibaly_203","~01rH!EJ^fbg","habycoulibaly_sae203");
            $res=mysqli_query($link,"select count(*) as total from products");
            $data=mysqli_fetch_assoc($res);
            echo $data['total'];
          ?>
        </h4>
      </div>
      <div class="card">
        <h3>Total Réservations</h3>
        <h4>
          <?php
            $res=mysqli_query($link,"select count(*) as total from reservations");
            $data=mysqli_fetch_assoc($res);
            echo $data['total'];
          ?>
        </h4>
      </div>
      <div class="card">
        <h3>Total Clients</h3>
        <h4>
          <?php
            $res=mysqli_query($link,"select count(*) as total from clients");
            $data=mysqli_fetch_assoc($res);
            echo $data['total'];
          ?>
        </h4>
      </div>
      <div class="card">
      <h3>Chiffre d'Affaire Mensuel</h3>
      <h4>
        <?php
          $res=mysqli_query($link,"select sum(price) as total from reservations 
             where month(reservation_date)=month(curdate()) 
             and year(reservation_date)=year(curdate())");
          $data=mysqli_fetch_assoc($res);
          echo $data['total'] ? number_format($data['total'], 2, ',', ' ') . " €" : "0 €";
        ?>
      </h4>
    </div>
     <div class="card">
      <h3>Chiffre d'Affaire Annuel</h3>
      <h4>
        <?php
          $res=mysqli_query($link,"select sum(price) as total from reservations 
             where year(reservation_date)=year(curdate())");
          $data = mysqli_fetch_assoc($res);
          echo $data['total'] ? number_format($data['total'], 2, ',', ' ') . " €" : "0 €";
        ?>
      </h4>
    </div>
     <div class="card">
      <h3>Réservations du Jour</h3>
      <h4>
        <?php
          $res=mysqli_query($link,"select count(*) as total from reservations 
             where date(reservation_date)=curdate()");
          $data = mysqli_fetch_assoc($res);
          echo $data['total'];
        ?>
      </h4>
    </div>
    </div>
  </section>
  
  
  
 <section id="reservations">
    <h1>Liste des réservations</h1>
        <div class="card">
        <table>
        <tr>
          <th>ID</th>
          <th>Produit</th>
          <th>Date de départ</th>
          <th>Date de fin</th>
          <th>Prénom</th>
          <th>Nom</th>
        </tr>
        <?php
        $res=mysqli_query($link,"select r.reserv_id, r.start_date, r.end_date, p.product_name, c.name, c.lastname
            from reservations r
            join lienrp l ON r.reserv_id=l.reserv_id
            join products p ON l.product_id=p.product_id
            join clients c on r.client_id=c.client_id");
        while ($data=mysqli_fetch_assoc($res)){
          echo "<tr>
            <td>{$data['reserv_id']}</td>
            <td>{$data['product_name']}</td>
            <td>{$data['start_date']}</td>
            <td>{$data['end_date']}</td>
            <td>{$data['name']}</td>
            <td>{$data['lastname']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>
  </section>
  
<section id="clients">
    <h1>Liste des clients</h1>
    <div class="card">
      <table>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Nombre de réservation</th>
          <th>Dernière réservation</th>
          <th>Dépense</th>
        </tr>
        <?php
        $res=mysqli_query($link, "select c.client_id, c.name, c.lastname, c.email,
                count(r.reserv_id) as nb,
                max(r.reservation_date) as dr,
                sum(p.stock * p.price) as 'depense'
                from clients c
                left join reservations r on c.client_id=r.client_id
                left join lienrp on r.reserv_id=lienrp.reserv_id
                left join products p on lienrp.product_id=p.product_id
                group by c.client_id");
        while ($data=mysqli_fetch_assoc($res)) {
          $depense=number_format($data['depense'], 2);
          echo "<tr>
            <td>{$data['client_id']}</td>
            <td>{$data['name']} {$data['lastname']}</td>
            <td>{$data['email']}</td>
            <td>{$data['nb']}</td>
            <td>{$data['dr']}</td>
            <td>{$depense} €</td>
          </tr>";
        }?>
      </table>
    </div>
  </section>
  
<section id="ajouter">
    <div class="card">
        <h1>Ajouter un produit</h1>
            <form method='POST' enctype='multipart/form-data'>
            Nom<input type='text' name='product_name' required>
            <BR><BR>
            Image<input type='file' name='img' required>
            <BR><BR>
            Prix<input type='number' name='price' step='0.01' required>
            <BR><BR>
            Stock<input type='number' name='stock' required>
            <BR><BR>
            Disponibilité<select name='availability_status' required>
              <option value='disponible'>Disponible</option>
              <option value='non disponible'>Non disponible</option>
              <option value='en cours de réservation'>En cours de réservation</option>
            </select>
            <BR><BR>
            Planète<input type='text' name='planet' required>
            <BR><BR>
            <label for='description'>Description</label><textarea id='description' name='description'></textarea>
            <BR><BR>
            Climat<select name='climate' required>
              <option value='humide'>Humide</option>
              <option value='arctique'>Arctique</option>
              <option value='tempere'>Tempéré</option>
              <option value='tropical'>Tropical</option>
              <option value='desertique'>Désertique</option>
              <option value='absent'>Absent</option>
              </select>
            <BR><BR>
            Faune<select name='wildlife' required>
              <option value='rare'>Rare</option>
              <option value='riche'>Riche</option>
              <option value='inexistante'>Inexistante</option>
              <option value='abondante'>Abondante</option>ù
              </select>
            <BR><BR>
            Flore<select name='flora' required>
              <option value='aucune'>Aucune</option>
              <option value='luxuriante'>Luxuriante</option>
              <option value='exotique'>Exotique</option>
              <option value='diversifiee'>Diversifiée</option>
              <option value='minime'>Minime</option>
              <option value='mutante'>Mutante</option>
              </select>
            <BR><BR>
            Dangerosité<select name='danger_level' required>
              <option value='minimal'>Minimal</option>
              <option value='faible'>Faible</option>
              <option value='modere'>Modéré</option>
              <option value='eleve'>Élevé</option>
              <option value='extreme'>Extrême</option>
              </select>
            <BR><BR>
        <input type='submit' name='suba' value'Ajouter'>
    </form>
</div>
</section>

    
<section id="modifier">
    <div class="card">
        <h1>Modifier un produit</h1>
        <form method="POST" class="form-container">
            <label for="product_id">ID du sac :</label>
            <input type="number" id="product_id" name="product_id" required>
            <label for="price">Nouveau prix :</label>
            <input type="number" id="price" name="price" step="0.01" required>
            <input type="submit" name="subm" value="Mettre à jour">
        </form>
    </div>
</section>
   
<?php
$res=mysqli_query($link,"select product_id,planet,img,price,description from products");
echo '<section id="supprimer">
    <div class="card"> 
        <h1>Supprimer un produit</h1>
        <table>
        <tr><th>ID</th><th>Planète</th><th>Visuel</th><th>Prix</th><th>Description</th>
        <form method="POST">';
     while ($data=mysqli_fetch_assoc($res)){
     echo "<tr>"; 
            foreach($data as $indice=>$valeur){
                if ($indice=='img') {
                    echo "<td><img src='img/{$valeur}'></td>";
                } else { echo "<td>$valeur</td>"; }
            }
            $id=$data['product_id'];
            echo "<td><input type='checkbox' name='supp[]' value='$id'></td>";
            echo "</tr>";
        } 
        echo "<tr><td><input type='submit' name='subp' value='Supprimer' onclick='return confirm('Confirmer la suppression ?')'></td></tr>
        </table>
        </form>
    </div>
</section>";
   


function ajt(){
    $link=mysqli_connect("localhost","habycoulibaly_203","~01rH!EJ^fbg","habycoulibaly_sae203");
    $product_name= $_POST['product_name'];
    $price=$_POST['price'];
    $stock=$_POST['stock'];
    $description=$_POST['description'];
    $availability_status=$_POST['availability_status'];
    $planet=$_POST['planet'];
    $climate=$_POST['climate'];
    $wildlife=$_POST['wildlife'];
    $flora=$_POST['flora'];
    $danger_level=$_POST['danger_level'];

    if (isset($_FILES['img']) && $_FILES['img']['error']==0){
        $img=$_FILES['img']['name'];
        $tmp=$_FILES['img']['tmp_name'];
        move_uploaded_file($tmp,"img/".$img);
    }
    if (mysqli_query($link,"insert into products (product_name, img, price, stock, description, availability_status, planet, climate, wildlife, flora, danger_level) 
        values ('$product_name','$img','$price','$stock','$description','$availability_status','$planet','$climate','$wildlife','$flora','$danger_level')")){
        echo "<script>alert('Produit ajouté');</script>";
    } else { mysqli_error($link); }
}


function mod(){
    $price=$_POST['price'];
    $id=$_POST['product_id'];
    $link=mysqli_connect("localhost","habycoulibaly_203","~01rH!EJ^fbg","habycoulibaly_sae203");
    if (mysqli_query($link,"update products set price = $price where product_id = $id")){
        echo "<script>alert('Nouveau prix ajouté');</script>"; } 
    else { echo mysqli_error($link); }
    }   

function sup(){
    $link=mysqli_connect("localhost","habycoulibaly_203","~01rH!EJ^fbg","habycoulibaly_sae203");
    foreach ($_POST['supp'] as $id) {
        if (mysqli_query($link,"delete from products where product_id='$id'")){
            echo "<script>alert('Produit supprimé');</script>"; } 
        else { echo mysqli_error($link); }
    }
}

if (isset($_POST['suba'])){ 
    echo ajt();
} else { echo mysqli_error($link); }
if (isset($_POST['subm'])){ 
    echo mod();
} else { echo mysqli_error($link); }
if (isset($_POST['subp'])){ 
    echo sup();
} else { echo mysqli_error($link); }
mysqli_close($link);
?>   
</main>
</body>
</html>