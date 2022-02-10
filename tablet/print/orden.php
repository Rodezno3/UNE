<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$nombre_impresora = "despacho1"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);

try{
	$logo = EscposImage::load("logos.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){}

require "../php/fun/conexion.php";
/*--- INFO GENERAL ---*/
$sql = "SELECT * FROM Activo WHERE IDA=:ida";
$query = $conn->prepare($sql);
$query->bindParam(':ida' , $_GET['final']);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
/*--- MENU GENERAL ---*/
$leng = "SELECT * FROM Description WHERE IDA=:ida";
$consulta = $conn->prepare($leng);
$consulta->bindParam(':ida' , $_GET['final']);
$consulta->execute();

$printer->text("\n"."ORDEN #". $_GET['final'] . "\n");
$printer->text("Mesa: ".$row['Mesa']."\n");
$printer->text("Fecha: " .$fdate. "\n");
$printer->text("**** COCINA ****" . "\n");
$printer->text("-----------------------------" . "\n");
/*
	Ahora vamos a imprimir los
	productos
*/
/*Alinear a la izquierda para la cantidad y el nombre*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
while($colum = $consulta->fetch(PDO::FETCH_ASSOC)){
    $s = "SELECT Producto FROM Menu WHERE IDME=:idme";
    $q = $conn->prepare($s);
    $q->bindParam(':idme' , $colum['IDME']);
    $q->execute();
    $r = $q->fetch(PDO::FETCH_ASSOC);
    
    $printer->text( $colum['Cantidad'] . " ".$r['Producto']." \n");   
}
if($row['Llevar'] == 1){
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("-----------------------------" . "\n");
$printer->text("**** PARA LLEVAR ****" . "\n");
$printer->text("-----------------------------" . "\n");
} 
/*
	Terminamos de imprimir
	los productos, ahora va el total
*/


/*
	Podemos poner también un pie de página
*/

/*Alimentamos el papel 3 veces*/
$printer->feed(3);

/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
$printer->cut();

/*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
$printer->pulse();

/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();
header("location: ../inicio.php");

?>