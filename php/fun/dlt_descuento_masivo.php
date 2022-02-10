<?php 
if(isset($_GET['id'])){
    require "conexion.php";
    $error = 0;
    $blue = "SELECT IDMEC FROM Menu_C WHERE Grupo=:gru";
    $berry = $conn->prepare($blue);
    $berry->bindParam(':gru' , $_GET['id']);
    $berry->execute();
    while($b = $berry->fetch(PDO::FETCH_ASSOC)){
        var_dump($b);
        $sql = "DELETE FROM Descuento_C WHERE IDMEC=:id";
        $query = $conn->prepare($sql);
        $query->bindParam(':id' , $b['IDMEC']);
        if($query->execute()){ } else { $error = 1; }
    }
    if($error = 0){
        header("location: ../../menu.php");
    } else {
        header("location: ../../menu.php?error");
    }
} else {
    header("location: ../../menu.php?error=0");
}
?>