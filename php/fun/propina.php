<?php 
if(isset($_GET['ida'])){
    if($_GET['date'] == 1){
        require "conexion.php";
        $sql = "UPDATE activo_c SET propina=0 WHERE IDAC=:ida";
        $query = $conn->prepare($sql);
        $query->bindParam(':ida' , $_GET['ida']);
        $query->execute();
        header("location: ../../inicio.php");
    } elseif($_GET['date'] == 0){
        require "conexion.php";
        $sql = "UPDATE activo_c SET propina=1 WHERE IDAC=:ida";
        $query = $conn->prepare($sql);
        $query->bindParam(':ida' , $_GET['ida']);
        $query->execute();
        header("location: ../../inicio.php");
    } else {
        header("location: ../../inicio.php");
    }
} else {
    header("location: ../../inicio.php");
}
?>