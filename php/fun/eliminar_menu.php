<?php 
if(isset($_GET['menu'])){
    require "conexion.php";
    $sql = "DELETE FROM Menu_C WHERE IDMEC=:idme";
    $query = $conn->prepare($sql);
    $query->bindParam(':idme' , $_GET['menu']);
    $query->execute();
    header("location: ../../menu.php");
} else {
    header("location: ../../menu.php?error");
}
?>