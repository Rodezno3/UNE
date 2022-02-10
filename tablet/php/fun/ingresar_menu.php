<?php 
if(isset($_POST)){
    if(!empty($_POST['pro_ing']) && !empty($_POST['pre_ing']) && $_GET['id']){
        require "conexion.php";
        $sql = "INSERT INTO Articulo_T (Producto , Precio , Grupo, IDSE) VALUES (:pro , :pre , :gru , :idse)";
        $query = $conn->prepare($sql);
        $query->bindParam(':pro' , $_POST['pro_ing']);
        $query->bindParam(':pre' , $_POST['pre_ing']);
        $query->bindParam(':gru' , $_POST['tipo']);
        $query->bindParam(':idse' , $_GET['id']);
        if($query->execute()){
            header("location: ../../menu.php?value=true");
        } else {
            header("location: ../../menu.php?value=false");
        }
    } else {
        header("location: ../../menu.php?value=false0");
    }
} else {
    header("location: ../../menu.php");
}
?>