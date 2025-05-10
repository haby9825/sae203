<?php
$link = mysqli_connect("localhost", "habycoulibaly_203", "~01rH!EJ^fbg", "habycoulibaly_sae203");
    if (!$link) {
        die(mysqli_connect_error());
}
// $id=$_GET['id'];
// $res=mysqli_query($link,"select r.reserv_id, r.start_date, r.end_date, r.reservation_date, r.price, p.product_name
//     from reservations r
//     join lienrp lr on r.reserv_id=lr.reserv_id
//     join products p on lr.product_id=p.product_id
//     where r.client_id='$id'
//     order by r.reservation_date desc");
    
//     $data=mysqli_fetch_assoc($res);
//     if (isset($_GET['id'])){
//     echo '<tr>

//     </tr>';
//     }
//     if (isset($_SESSION['client_id'])){
        
//     }
    
// $req=mysqli_query($link,"insert into reservations (client_id, product_id, reservation_date, price) values ($client_id, $product_id, $reservation_date, $price)");

        // '.$data['product_name'].'</td>
        // <td>'.$data['start_date'].'</td>
        // <td>'.$data['end_date'].'</td>
        // <td>'.$data['reservation_date'].'</td>
        //  <td>'.$data['price'].'€</td>