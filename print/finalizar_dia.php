<?php
error_reporting(0);
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
require "../php/fun/tiempo.php";
if($fdate == '1899/12/31'){
  header("location: ../../count.php");
} else {
$total_global = 0;
/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


/*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

$nombre_impresora = "POS-80CF";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);

try{
	$logo = EscposImage::load("logos.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}


$sql = "SELECT * FROM Menu_C";
require "../php/fun/conexion.php";
/*--- INFO GENERAL ---*/
$query = $conn->prepare($sql);
$query->execute();
#La fecha también
$printer->text("\n"."CIERRE DE DÍA ". $fdate . "\n");
$printer->text("**** DETALLES ****" . "\n");
$printer->text("-----------------------------" . "\n");
$propina = 0;
$printer->setJustification(Printer::JUSTIFY_LEFT);
$propina = 0;
while($row = $query->fetch(PDO::FETCH_ASSOC)){
    $total = 0;
    $potal = 0;
    $tql = "SELECT Cantidad, Precio, Propina FROM Historial_Orden_Diario_C O LEFT JOIN Historial_Diario_C H ON O.IDHDC = H.IDHDC WHERE Producto=:pro";
    $tuery = $conn->prepare($tql);
    $tuery->bindParam(':pro' , $row['Producto']);
    $tuery->execute();
    while($sow = $tuery->fetch(PDO::FETCH_ASSOC)){
        if(!empty($sow['Cantidad'])){
            $potal = $potal + $sow['Cantidad'];
            if($sow['propina'] == 1){
                $piro = $sow['cantidad'] * 0.1;
                $propina = $propina + $piro;
            }
        }
    } 
    if(!empty($potal)){
        $printer->text("Producto: " . $row['Producto']);
        $printer->text("\n Cantidad: " . $potal . " Total: $". $total = number_format(($row['Precio'] * $potal) , 2) ."\n");
        $total_global = $total_global + $total;
    }
}
$bot = "SELECT Precio FROM Historial_Orden_Diario_C WHERE Producto='descuento'";
$ia = $conn->prepare($bot);
$ia->execute();
$descuento = 0;
while($red = $ia->fetch(PDO::FETCH_ASSOC)){
    $descuento = $descuento + $red['Precio'];
}
$printer->text("----------------------------------" . "\n");
if($sow['propina'] == 1){
    $printer->text("Propina: $".number_format($propina , 2)."\n");
    $total_global = $total_global + $propina;
}
if($descuento != 0){
    $neu = -1 * $descuento;
    $total_descuento = $total_global - $neu;
}
if($descuento == 0){
    $printer->text("Total: $". number_format($total_global , 2) ."\n");
} else {
    $printer->text("Sub Total: $". number_format($total_global , 2) ."\n");
    $printer->text("Descuento: -$".number_format($neu , 2));
    $printer->text("Total: $". number_format($total_descuento , 2) ."\n");
}
$printer->text("----------------------------------" . "\n");

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


$key = 0;
$fql = "SELECT * FROM Historial_Diario_C";
$fuery = $conn->prepare($fql);
$fuery->execute();
while($fow = $fuery->fetch(PDO::FETCH_ASSOC)){
    $iden = $fow['IDHDC'];

    $xql = "INSERT INTO Historial_C (Mesa , Cliente , Mesero , Persona , IDCF , Hora , Fecha , Llevar , des_alternativo , propina) VALUES (:mesa , :clie , :mese , :pers , :idcf , :hora , :fech , :llev , :des , :pro)";
    $xuery = $conn->prepare($xql);
    $xuery->bindParam(':mesa' , $fow['Mesa']);
    $xuery->bindParam(':clie' , $fow['Cliente']);
    $xuery->bindParam(':mese' , $fow['Mesero']);
    $xuery->bindParam(':pers' , $fow['Persona']);
    $xuery->bindParam(':idcf' , $fow['IDCF']);
    $xuery->bindParam(':hora' , $fow['Hora']);
    $xuery->bindParam(':fech' , $fow['Fecha']);
    $xuery->bindParam(':llev' , $fow['Llevar']);
    $xuery->bindParam(':des' , $fow['des_alternativo']);
    $xuery->bindParam(':pro' , $fow['propina']);
    if($xuery->execute()){} else {
        $key = 1;
    }
    
    $kql = "SELECT IDH FROM Historial_C ORDER BY IDH DESC";
    $kuery = $conn->prepare($kql);
    $kuery->execute();
    $kow = $kuery->fetch(PDO::FETCH_ASSOC);
    
    $dql = "SELECT * FROM Historial_Orden_Diario_C WHERE IDHDC=:idhdc";
    $duery = $conn->prepare($dql);
    $duery->bindParam(':idhdc' , $iden);
    $duery->execute();
    while($dow = $duery->fetch(PDO::FETCH_ASSOC)){
        $zql = "INSERT INTO Historial_Orden_C (IDH , Producto , Cantidad , Precio) VALUES (:idh , :pro , :can , :pre)";
        $zuery = $conn->prepare($zql);
        $zuery->bindParam(':idh' , $kow['IDH']);
        $zuery->bindParam(':pro' , $dow['Producto']);
        $zuery->bindParam(':can' , $dow['Cantidad']);
        $zuery->bindParam(':pre' , $dow['Precio']);
        if($zuery->execute()){} else {
            $key = 1;
        }
    }
    
    
}


if($key == 0){
    $dlth = "DELETE FROM Historial_Diario_C";
    $dlto = "DELETE FROM Historial_Orden_Diario_C";
    
    $tan = $conn->prepare($dlth);
    $tan->execute();
    
    $ten = $conn->prepare($dlto);
    $ten->execute();
}
}
header("location: ../count.php");
?>
<script>
  window.locatio.href="../count.php";
</script>