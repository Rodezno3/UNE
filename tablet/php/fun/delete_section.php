<?php 
if(isset($_GET['art'])){
    require "conexion.php";
    $xql = "DELETE FROM Articulo_T WHERE IDSE=:id";
    $xuery = $conn->prepare($xql);
    $xuery->bindParam(':id' , $_GET['art']);
    if($xuery->execute()){
        $sql = "DELETE FROM Secciones_T WHERE ID=:id";
        $query = $conn->prepare($sql);
        $query->bindParam(':id' , $_GET['art']);
        if($query->execute()){
            header("location: ../../menu.php");
        }
    } else {
        
    }
    header("location: ../../menu.php");
} else {
    header("location: ../../menu.php?error");
}
?>