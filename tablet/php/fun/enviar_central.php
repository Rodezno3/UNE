<?php 
    if(isset($_GET['act'])){
        require "conexion.php";
        $sql = "SELECT * FROM Activo_C WHERE IDAC=:idac";
        $query = $conn->prepare($sql);
        $query->bindParam(':idac' , $_GET['act']);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $aql = "INSERT INTO Compartido (IDAC) VALUE (:idac)";
        $auery = $conn->prepare($aql);
        $auery->bindParam(':idac' , $_GET['act']);
        $auery->execute();
        
        $xql = "INSERT INTO Historial_Diario_C (Mesa , Cliente , Mesero , Persona , IDCF , Hora , Fecha , Llevar) VALUES (:mesa , :clie , :mese , :pers , :idcf , :hora , :fech , :llev)";
        $fecha = date('Y-m-d');
        $xuery = $conn->prepare($xql);
        $xuery->bindParam(':mesa' , $row['Mesa']);
        var_dump($row['Mesa']);
        echo "<br>";
        $xuery->bindParam(':clie' , $row['Cliente']);
        var_dump($row['Cliente']);
        echo "<br>";
        $xuery->bindParam(':mese' , $row['Personas']);
        var_dump($row['Personas']);
        echo "<br>";
        $xuery->bindParam(':pers' , $row['IDCF']);
        var_dump($row['IDCF']);
        echo "<br>";
        $xuery->bindParam(':idcf' , $row['Mesero']);
        var_dump($row['Mesero']);
        echo "<br>";
        $xuery->bindParam(':hora' , $row['Hora']);
        var_dump($row['Hora']);
        echo "<br>";
        $xuery->bindParam(':fech' , $fecha);
        var_dump($fecha);
        echo "<br>";
        $xuery->bindParam(':llev' , $row['Llevar']);
        var_dump($row['Llevar']);
        echo "<br>";
        if($xuery->execute()){
            $dql = "SELECT IDHDC FROM Historial_Diario_C IDHDC ORDER BY ASC";
            $duery = $conn->prepare($dql);
            if($duery->execute()){
                $dow = $duery->fetch(PDO::FETCH_ASSOC);
                $jql = "SELECT * FROM Descripcion_C WHERE IDAC=:idac";
                $juery = $conn->prepare($jql);
                $juery->bindParam(':idac' , $_GET['act']);
                $juery->execute();
                while($jow = $juery->fetch(PDO::FETCH_ASSOC)){
                    $tql = "SELECT Producto , Precio FROM Menu_C WHERE IDMEC=:idmec";
                    $tuery = $conn->prepare($tql);
                    $tuery->bindParam(':idmec' , $jow['IDMEC']);
                    $tuery->execute();
                    $tow = $tuery->fetch(PDO::FETCH_ASSOC);
                    
                    $fql = "INSERT INTO Historial_Orden_Diario_C (IDHDC , Producto , Cantidad , Precio) VALUES (:id , :pr , :ca , :co)";
                    $fuery = $conn->prepare($fql);
                    $fuery->bindParam(':id' , $dow['IDHDC']);
                    $fuery->bindParam(':pr' , $tow['Producto']);
                    $fuery->bindParam(':ca' , $jow['Cantidad']);
                    $fuery->bindParam(':co' , $tow['Precio']);
                    $fuery->execute();
                }
                
            }
            $zql = "DELETE FROM Activo_C WHERE IDAC=:idac";
            $zuery = $conn->prepare($zql);
            if($zuery->execute()){
                $vql = "DELETE FROM Descripcion_C WHERE IDAC=:idac";
                $vuery = $conn->prepare($vql);
                $vuery->bindParam(':idac' , $_GET['act']);
                if($vuery->execute()){
                    header("location: ../../inicio.php");
                } else {
                    header("location: ../../inicio.php?error=2");
                }
            } else {
                header("location: ../../inicio.php?error=1");
            }
        } else {
            //header("location: ../../inicio.php?error=0");
        }
        
    } else {
        header("location: ../../inicio.php");
    }
?>