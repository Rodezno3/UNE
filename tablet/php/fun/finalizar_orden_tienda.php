<?php
session_start();
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
$key = 0;
require "tiempo.php";
if(isset($_GET['id'])){
    require "conexion.php";
    $sql = "SELECT * FROM Activo_T WHERE IDAT=:ida";
    $query = $conn->prepare($sql);
    $query->bindParam(':ida' , $_GET['id']);
    if($query->execute()){
        echo "Si selecciono Activo<br>";
    }
    $kim = $query->fetch(PDO::FETCH_ASSOC);
    /*- CAMBIAR -*/
    $hora = date('H:m:s' , time());
    $fecha = date('Y-m-d' , time());
    $m = "INSERT INTO Historial_Diario_T (Cliente , Hora , Fecha) VALUES (:clie , :hora , :fech)";
    $n = $conn->prepare($m);
    $n->bindParam(':clie' , $kim['Cliente']);
    $n->bindParam(':hora' , $kim['Hora']);
    $n->bindParam(':fech' , $fdate);
    if($n->execute()){
        echo "Si ingreso Historial<br>";
    }
    /*-- menu --*/
    $me = "SELECT * FROM Descripcion_T WHERE IDAT=:ida";
    $nu = $conn->prepare($me);
    $nu->bindParam(':ida' , $_GET['id']);
    if($nu->execute()){
        echo "Si selecciono Description<br>";
    }
    while($re = $nu->fetch(PDO::FETCH_ASSOC)){
        $an = "SELECT * FROM Articulo_T WHERE IDART=:idme";
        $tes = $conn->prepare($an);
        $tes->bindParam(':idme' , $re['IDART']);
        if($tes->execute()){
           echo "Si selecciono un dato<br>";
        }
        $de = $tes->fetch(PDO::FETCH_ASSOC);
        
        $sub = "SELECT IDHDT FROM Historial_Diario_T ORDER BY IDHDT DESC";
        $cacha = $conn->prepare($sub);
        $cacha->execute();
        $misio = $cacha->fetch(PDO::FETCH_ASSOC);
        
        $s = "INSERT INTO Historial_Orden_Diario_T (IDHDT , Producto , Cantidad , Precio) VALUES (:idh , :pro , :can , :pre)";
        $q = $conn->prepare($s);
        $q->bindParam(':idh' , $misio['IDHDT']);
        $q->bindParam(':pro' , $de['Producto']);
        $q->bindParam(':can' , $re['Cantidad']);
        $q->bindParam(':pre' , $de['Precio']);
        if($q->execute()){
            echo "Si ingreso un dato a Orden<br>";
        } else {
            $key = 1;
            echo "No ingreso un dato a Orden: ".$de['Producto']."<br>";
        }
    }
    /*-- DELETE --*/
    if($key == 0){
        $el = "DELETE FROM Activo_T WHERE IDAT=:ida";
        $im = $conn->prepare($el);
        $im->bindParam(':ida' , $_GET['id']);
        $im->execute();

        $in = "DELETE FROM Descripcion_T WHERE IDAT=:ida";
        $ar = $conn->prepare($in);
        $ar->bindParam(':ida' , $_GET['id']);
        $ar->execute();
        
        $ru = "DELETE FROM Compartido WHERE IDAT=:ida";
        $by = $conn->prepare($ru);
        $by->bindParam(':ida' , $_GET['id']);
        $by->execute();

        header("location: ../../inicio.php");
    } else {
        header("location: ../../inicio.php?error");
    }
} else {}
?>