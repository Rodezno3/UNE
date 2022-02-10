<?php
error_reporting(0);
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
require "../php/fun/tiempo.php";
if($fdate == '1899/12/31'){
} else {
$total_global = 0;

$nombre_impresora = "POS-80CB"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);

try{
	$logo = EscposImage::load("logos.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}

require "../php/fun/conexion.php";
/*--- INFO GENERAL ---*/

$sql = "SELECT * FROM Articulo_T";
$query = $conn->prepare($sql);
$query->execute();
date_default_timezone_set("America/El_Salvador");
$printer->text("\n CIERRE DE DÍA ".$fdate."\n");
$printer->text("**** DETALLES ****" . "\n");
$printer->text("-----------------------------" . "\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
while($row = $query->fetch(PDO::FETCH_ASSOC)){
    $total = 0;
    $potal = 0;
    $tql = "SELECT Cantidad, Precio FROM Historial_Orden_Diario_T O LEFT JOIN Historial_Diario_T H ON O.IDHDT = H.IDHDT WHERE Producto=:pro";
    $tuery = $conn->prepare($tql);
    $tuery->bindParam(':pro' , $row['Producto']);
    $tuery->execute();
    while($sow = $tuery->fetch(PDO::FETCH_ASSOC)){
        $potal = $potal + $sow['Cantidad'];
    } 
    if($potal != 0){
        $printer->text("Producto: " . $row['Producto']);
        $printer->text("\n Cantidad: " . $potal . " Total: $". $total = number_format(($row['Precio'] * $potal) , 2) ."\n");

    } else {
	   echo "no ingreso los datos";
    }
    $total_global = $total_global + $total;
}
$printer->text("----------------------------------" . "\n");
$printer->text("Total: $". number_format($total_global , 2) ."\n");
$printer->text("----------------------------------" . "\n");

$printer->feed(3);

$printer->cut();

$printer->pulse();

$printer->close();

/*---- ----*/
require "../php/fun/conexion.php";
$key = 0;
$xql = "SELECT * FROM Historial_Diario_T";
$xuery = $conn->prepare($xql);
$xuery->execute();
while($xow = $xuery->fetch(PDO::FETCH_ASSOC)){
    $iden = $xow['IDHDT'];
    
    $fun = "INSERT INTO Historial_T (Cliente , Hora , Fecha) VALUES (:cliente , :hora , :fecha)";
    $fin = $conn->prepare($fun);
    $fin->bindParam(':cliente' , $xow['Cliente']);
    $fin->bindParam(':hora' , $xow['Hora']);
    $fin->bindParam(':fecha' , $xow['Fecha']);
    if($fin->execute()){} else {
        $key = 1;
    }
    
    $tql = "SELECT IDH FROM Historial_T ORDER BY IDH DESC";
    $tuery = $conn->prepare($tql);
    $tuery->execute();
    $tow = $tuery->fetch(PDO::FETCH_ASSOC);

    $zql = "SELECT * FROM Historial_Orden_Diario_T WHERE IDHDT=:idhdt";
    $zuery = $conn->prepare($zql);
    $zuery->bindParam(':idhdt' , $iden);
    $zuery->execute();
    while($zow = $zuery->fetch(PDO::FETCH_ASSOC)){
        $san = "INSERT INTO Historial_Orden_T (IDH , Producto , Cantidad , Precio) VALUES (:id , :pro , :can , :pre)";
        $sen = $conn->prepare($san);
        $sen->bindParam(':id' , $tow['IDH']);
        $sen->bindParam(':pro' , $zow['Producto']);
        $sen->bindParam(':can' , $zow['Cantidad']);
        $sen->bindParam(':pre' , $zow['Precio']);
        if($sen->execute()){} else {
            $key = 1;
        }
    }

}


if($key == 0){
    $dltc = "DELETE FROM Historial_Diario_T";
    $dltd = "DELETE FROM Historial_Orden_Diario_T";

    $tan = $conn->prepare($dltc);
    $tan->execute();

    $ten = $conn->prepare($dltd);
    $ten->execute();
    header("location: ../count.php");
} else {
    //header("location: ../count.php?error");
}
}
header("location: ../count.php");
?>
<script>
  window.location.href="../count.php";
</script>


?>
