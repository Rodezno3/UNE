<?php 
if(isset($_GET['menu']) && isset($_GET['tipo'])){
    require "conexion.php";
    if(isset($_POST['check'])){
        //Si es descuento directo
        if($_GET['tipo'] == 1){
            //Si es nuevo
            $sql = "INSERT INTO Descuento_C (IDMEC , DescuentoDi , DescuentoPo , FechaIn , FechaFi) VALUES (:id , :des , NULL , :ini , :fin)";
            $query = $conn->prepare($sql);
            $query->bindParam(':id' , $_GET['menu']);
            $query->bindParam(':des' , $_POST['directo']);
            $query->bindParam(':ini' , $_POST['inicio']);
            $query->bindParam(':fin' , $_POST['fin']);
            if($query->execute()){
                header("location: ../../menu.php");
            } else {
                header("location: ../../menu.php?error");
            }
        } elseif($_GET['tipo'] == 2){
            //Si hay que actualizar
            $sql = "UPDATE Descuento_C SET DescuentoDi = :di , DescuentoPo = NULL , FechaIn = :in , FechaFi = :fi WHERE IDMEC = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':di' , $_POST['directo']);
            $query->bindParam(':in' , $_POST['inicio']);
            $query->bindParam(':fi' , $_POST['fin']);
            $query->bindParam(':id' , $_GET['menu']);
            if($query->execute()){
                header("location: ../../menu.php");
            } else {
                header("location: ../../menu.php?error");
            }
        } else {
            
        }
        
    } else {
        //Si es descuento por porcentaje
        if($_GET['tipo'] == 1){
            //Si es nuevo
            $sql = "INSERT INTO descuento_c (IDMEC , DescuentoDi , DescuentoPo , FechaIn , FechaFi) VALUES (:id , NULL , :des , :ini , :fin)";
            $query = $conn->prepare($sql);
            $query->bindParam(':id' , $_GET['menu']);
            $query->bindParam(':des' , $_POST['percent']);
            $query->bindParam(':ini' , $_POST['inicio']);
            $query->bindParam(':fin' , $_POST['fin']);
            if($query->execute()){
                header("location: ../../menu.php");
            } else {
                header("location: ../../menu.php?error");
            }
        } elseif($_GET['tipo'] == 2){
            //Si hay que actualizar
            $sql = "UPDATE Descuento_C SET DescuentoDi = NULL , DescuentoPo = :po , FechaIn = :in , FechaFi = :fi WHERE IDMEC = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':po' , $_POST['percent']);
            $query->bindParam(':in' , $_POST['inicio']);
            $query->bindParam(':fi' , $_POST['fin']);
            $query->bindParam(':id' , $_GET['menu']);
            if($query->execute()){
                header("location: ../../menu.php");
            } else {
                header("location: ../../menu.php?error");
            }
        } else {
            header("location: ../../menu.php?error=0");
        }
    }
} else {
    header("location: ../../menu.php");
}
?>