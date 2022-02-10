<?php
session_start();
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
require "tiempo.php";
if(isset($_POST) && isset($_COOKIE)){
    if(!empty($_POST['name'])){
        require "conexion.php";
        $mesero = $_SESSION['mesero'];
        $hora = date('H:i:s' , time());
        $sql = "INSERT INTO Activo_T (Cliente , Hora) VALUES (:cli , :hora)";
        $query = $conn->prepare($sql);
        $query->bindParam(':cli' , $_POST['name']);
        $query->bindParam(':hora' , $clock);
        if($query->execute()){
            $jum = "SELECT IDAT FROM Activo_T ORDER BY IDAT DESC";
            $suit = $conn->prepare($jum);
            $suit->execute();
            $h = $suit->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "No se ejecuto";
        }
        $noland = 0;
        for($i=0 ; $i<=24 ; $i++){
            $a = "a".$i;
            $b = "b".$i;
            if(isset($_COOKIE[$a])){
                $m = $_COOKIE[$a];
                $n = $_COOKIE[$b];
                $s = "INSERT INTO Descripcion_T (IDAT , IDART , Cantidad) VALUES (:ida , :idme , :can )";
                $q = $conn->prepare($s);
                $q->bindParam(':ida' , $h['IDAT']);
                $q->bindParam(':idme' , $m);
                $q->bindParam(':can' , $n);
                if($q->execute()){
                setcookie($a , false , $expire = time() -100 , "/");
                setcookie($b , false , $expire = time() -100 , "/");
                } else {
                    $noland = 1;
                }
            }
        }
        if($noland == 0){
            $xql = "INSERT INTO Compartido (IDAT) VALUES (:idac)";
            $xuery = $conn->prepare($xql);
            $xuery->bindParam(':idac' , $h['IDAT']);
            if($xuery->execute()){
                header("location: ../../inicio.php");
            } else {
                header("location: ../../inicio.php?error=2");
            }
        } else {
            header("location: ../../inicio.php?error=1");
        }
        //header("location: ../../print/orden.php");
        header("location: ../../inicio.php");
    } else {}
} else {}
?>