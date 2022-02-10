<?php 
if(isset($_GET['final']) && isset($_GET['compartido'])){
    require "conexion.php";
    $xql = "DELETE FROM Compartido WHERE IDCompartido=:idc";
    $xuery = $conn->prepare($xql);
    $xuery->bindParam(':idc' , $_GET['compartido']);
    $xuery->execute();
    
    
    $sql = "DELETE FROM Activo_T WHERE IDAT=:idac";
    $sqli = "DELETE FROM Descripcion_T WHERE IDAT=:idac";
    $query = $conn->prepare($sql);
    $queri = $conn->prepare($sqli);
    $query->bindParam(':idac' , $_GET['final']);
    $queri->bindParam(':idac' , $_GET['final']);
    $query->execute();
    $queri->execute();
    header("location: ../../inicio.php");
} else {
    header("location: ../../inicio.php?error");
}
?>