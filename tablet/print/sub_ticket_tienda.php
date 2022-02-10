<?php

if(!isset($_GET['final'])){
    header("location: ../inicio.php?error");
}

require __DIR__ . '/ticket/autoload.php'; 
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$nombre_impresora = "POS-80CB"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);
require "../php/fun/tiempo.php";
require "../php/fun/conexion.php";
require "../php/fun/funciones.php";
/*--- INFO GENERAL ---*/
$sql = "SELECT * FROM Activo_T WHERE IDAT=:ida";
$query = $conn->prepare($sql);
$query->bindParam(':ida' , $_GET['final']);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
/*--- MENU GENERAL ---*/
$leng = "SELECT * FROM Descripcion_T WHERE IDAT=:ida";
$consulta = $conn->prepare($leng);
$consulta->bindParam(':ida' , $_GET['final']);
$consulta->execute();
$total = 0;

$printer->text("\n"."CASA XOXÓCTIC" . "\n");
$printer->text("CASA XOXÓCTIC Café, bakery y eco tienda." . "\n");
#La fecha también
date_default_timezone_set("America/America/El_Salvador");
$printer->text("Fecha: ".$fdate."  Hora: ".$clock."\n");
$printer->text("**** PRE - CUENTA ****" . "\n");
$printer->text("----------------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Cant.  Descripción    P.U   IMP.\n");
$printer->text("----------------------------------"."\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
while($colum = $consulta->fetch(PDO::FETCH_ASSOC)){
    $s = "SELECT Producto , Precio FROM Articulo_T WHERE IDART=:idme";
    $q = $conn->prepare($s);
    $q->bindParam(':idme' , $colum['IDART']);
    $q->execute();
    $r = $q->fetch(PDO::FETCH_ASSOC);
    
    $printer->text( $r['Producto'] . " \n");
    $printer->text( $colum['Cantidad'] . " Unidad   $". number_format($r['Precio'] , 2) ." $".number_format(($r['Precio'] * $colum['Cantidad']) , 2)."   \n");
    
    $total = $total + ($r['Precio'] * $colum['Cantidad']);
}

$printer->text("----------------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
                                          
$printer->text("TOTAL: $".number_format($total , 2)."\n");

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("----------------------------------"."\n");
$printer->text("\n");
$printer->text("NO VALIDO COMO TIQUETE\n\n");
$printer->text("-- Gracias por su compra --\n");
$printer->text("Casa Xoxóctic lo espera pronto\n");


$printer->feed(3);

$printer->cut();

$printer->pulse();

$printer->close();
$f = $_GET['final'];
header("location: ../inicio.php");

?>