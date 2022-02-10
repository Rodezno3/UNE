<?php 
if(isset($_POST)){
    if(isset($_POST['name']) && isset($_POST['img'])){
        require "conexion.php";
        $sql = "INSERT INTO Secciones_T (Nombre , Img) VALUES (:name , :img)";
        $query = $conn->prepare($sql);
        $query->bindParam(':name' , $_POST['name']);
        $query->bindParam(':img' , $_POST['img']);
        if($query->execute()){
            header("location: ../../nueva_orden_tienda.php");
        } else {
            header("location: ../../nueva_seccion.php?error=2");
        }
    } else {
        header("location: ../../nueva_seccion.php?error=1");
    }
} else {
    header("location: ../../inicio.php");
}
?>