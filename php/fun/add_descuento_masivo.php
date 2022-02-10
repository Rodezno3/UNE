<?php 
if(isset($_GET['grupo'])){
    require "conexion.php";
    $pr = 0;
    $cont = "SELECT * FROM Menu_C WHERE Grupo=:gu";
    $coconut = $conn->prepare($cont);
    $coconut->bindParam(':gu' , $_GET['grupo']);
    $coconut->execute();
    while($c = $coconut->fetch(PDO::FETCH_ASSOC)){
        $blue = "SELECT IDMEC FROM Descuento_C WHERE IDMEC=:id";
        $berry = $conn->prepare($blue);
        $berry->bindParam(':id' , $c['IDMEC']);
        $berry->execute();
        if(isset($_POST['check'])){
            //Si seleccionaron descuento directo
            if($b = $berry->fetch(PDO::FETCH_ASSOC)){
                $sql = "UPDATE Descuento_C SET DescuentoDi = :di , DescuentoPo = NULL , FechaIn = :in , FechaFi = :fi WHERE IDMEC = :id";
                $query = $conn->prepare($sql);
                $query->bindParam(':di' , $_POST['directo']);
                $query->bindParam(':in' , $_POST['inicio']);
                $query->bindParam(':fi' , $_POST['fin']);
                $query->bindParam(':id' , $c['IDMEC']);
                if($query->execute()){ } else { $pr = 1; }
            } else {
                $sql = "INSERT INTO Descuento_C (IDMEC , DescuentoDi , DescuentoPo , FechaIn , FechaFi) VALUES (:id , :des , NULL , :ini , :fin)";
                $query = $conn->prepare($sql);
                $query->bindParam(':id' , $c['IDMEC']);
                $query->bindParam(':des' , $_POST['directo']);
                $query->bindParam(':ini' , $_POST['inicio']);
                $query->bindParam(':fin' , $_POST['fin']);
                if($query->execute()){ } else { $pr = 1; }
            }
        } else {        
            //Si seleccionaron descuento porcentaje
            if($b = $berry->fetch(PDO::FETCH_ASSOC)){
                $sql = "UPDATE Descuento_C SET DescuentoDi = NULL , DescuentoPo = :po , FechaIn = :in , FechaFi = :fi WHERE IDMEC = :id";
                $query = $conn->prepare($sql);
                $query->bindParam(':po' , $_POST['percent']);
                $query->bindParam(':in' , $_POST['inicio']);
                $query->bindParam(':fi' , $_POST['fin']);
                $query->bindParam(':id' , $c['IDMEC']);
                if($query->execute()){ } else { $pr = 1; }
            } else {
                $sql = "INSERT INTO Descuento_C (IDMEC , DescuentoDi , DescuentoPo , FechaIn , FechaFi) VALUES (:id , NULL , :por , :ini , :fin)";
                $query = $conn->prepare($sql);
                $query->bindParam(':id' , $c['IDMEC']);
                $query->bindParam(':por' , $_POST['percent']);
                $query->bindParam(':ini' , $_POST['inicio']);
                $query->bindParam(':fin' , $_POST['fin']);
                if($query->execute()){ } else { $pr = 1; }
            }
        }
    }
    if($pr = 0){
        header("location: ../../menu.php");
    } else {
        header("location: ../../menu.php?error=1");
    }
} else {
    header("location: ../../menu.php");
}
?>