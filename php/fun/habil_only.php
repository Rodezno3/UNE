<?php 
require "conexion.php";
if(isset($_GET['h']) && isset($_GET['id'])){
    if($_GET['h'] == 0){
        $sql = "UPDATE menu_c SET habil=0 WHERE IDMEC=:id";
        $query = $conn->prepare($sql);
        $query->bindparam(':id' , $_GET['id']);
        if($query->execute()){
            header("location: ../../menu.php");
        } else {
            header("location: ../../menu.php?error=2");
        }
    } elseif($_GET['h'] == 1){
        $sql = "UPDATE menu_c SET habil=1 WHERE IDMEC=:id";
        $query = $conn->prepare($sql);
        $query->bindparam(':id' , $_GET['id']);
        if($query->execute()){
            header("location: ../../menu.php");
        } else {
            header("location: ../../menu.php?error=2");
        }
    } else {
        header("location: ../../menu.php?error=1");
    }
} else {
    header("location: ../../menu.php?error=0");
}
?>