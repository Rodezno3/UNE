<?php 
error_reporting(0);
session_start();
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
require "php/fun/conexion.php";
require "php/fun/funciones.php";
date_default_timezone_set('America/El_Salvador');

$dia = date("Y-m-d" , time());
$hql = "SELECT * FROM Descuento_C";
$huery = $conn->prepare($hql);
$huery->execute();
while($how = $huery->fetch(PDO::FETCH_ASSOC)){
  if($how['FechaFi'] >= $dia){
      $uql = "DELETE FROM Descuento_C WHERE IDMEC=:id";
      $uery = $conn->prepare($uql);
      $uery->bindParam(':id' , $how['IDMEC']);
      $uery->execute();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <title>Casa Xoxoctic</title>
    <!-- estilos -->
    <link rel="stylesheet" href="css/estilos_header.css">
    <link rel="stylesheet" href="css/estilos_block_activos.css">
    <link rel="stylesheet" href="css/estilos_factura.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Dosis:wght@500&display=swap" rel="stylesheet">
    <!-- scripts -->
    <?php 
    if($clock >= "20:00:00"){
    ?>
    <script type="text/javascript">
      var cont = confirm("Hora de cierre de día.");
      if(cont == true){
          window.location="print/finalizar_dia.php";
          /* Añadir función de que si se envia desde aquí cerrar el programa de una sola vez */
      }
    </script>
    <?php } ?>
    <script>
      window.onload = actualizarPagina();
      function actualizarPagina() {
        let actualizar = false;
        momentoActual = new Date();
        hora = momentoActual.getHours();
        minuto = momentoActual.getMinutes();
        segundo = momentoActual.getSeconds();
        
        str_segundo = new String(segundo);
        if(str_segundo.length == 1){
          segundo = "0" + segundo;
        }
        str_minuto = new String(minuto);
        if(str_minuto.length == 1){
          minuto = "0" + minuto;
        }
        str_hora = new String(hora);
        if(str_hora.length == 1){
          hora = "0" + hora;
        }
        horaImprimible = hora + ":" + minuto + ":" + segundo;
        if(horaImprimible == "10:52:30"){
          actualizar = true;
        }
        setTimeout("actualizarPagina()" , 1000);
        if(actualizar == true){
          location.reload();
        }
        
      }
    </script>
</head>
<body>
    <?php require "php/header.php"; ?>
    <!-- factura -->
    <section class="inicio">
        <?php if(isset($_GET['ver'])){ 
        $s = "SELECT * FROM Activo_C WHERE IDAC=:ida";
        $q = $conn->prepare($s);
        $q->bindParam(':ida' , $_GET['ver']);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_ASSOC);
        ?>
        <article class="factura">
            <h2>Factura</h2>
            <hr>
            <h3>CASA XOXÓCTIC</h3>
            <h4>CASA XOXÓCTIC Café, bakery y eco tienda.</h4>
            <div class="f_div">
                <p>Fecha: <?= date('d/m/Y', time()); ?></p>
                <p>Hora: <?= $r['Hora']; ?></p>
            </div>
            <h5>**** PRE - CUENTA ****</h5>
            <hr>
            <p><span>Cant. Descripción</span><span>Total</span></p>
            <hr>
            <?php 
            $pp = $r['IDAC'];
            $pre = "SELECT * FROM Descripcion_C WHERE IDAC=$pp";
            $consul = $conn->prepare($pre);
            $consul->execute();
            $total = 0;
            while($six = $consul->fetch(PDO::FETCH_ASSOC)){
                $cf = $conn->prepare("SELECT * FROM Menu_C WHERE IDMEC=:six");
                $cf->bindParam(':six' , $six['IDMEC']);
                $cf->execute();
                $cb = $cf->fetch(PDO::FETCH_ASSOC);
            ?>
            <p>
                <span><?= $six['Cantidad'] ?> <?= $cb['Producto']; ?></span>
                <span>$<?= number_format(Precio($cb['IDMEC']) , 2); ?></span><span>$<?php $fan = number_format(($six['Cantidad'] * Precio($cb['IDMEC'])) , 2); echo $fan; ?></span>
            </p>
            <?php 
            $total = $total + $fan;
            } ?>
            <br>
            <hr>
            <p>
                <span>Sub Total: </span>
                <span>$<?php echo number_format($total , 2); ?></span>
            </p>
            <hr>
            <p>
                <strong><span>Total</span></strong>
                <strong><span>$<?php echo number_format($total , 2); ?></span></strong>
            </p>
            <hr>
            <span class="centrado">NO VALIDO COMO TIQUETE</span>
            <hr>
            <span class="centrado">- Cuenta Cerrada -</span>
            <span class="centrado">Transacción en dolares Americanos.</span>
        </article>
        <?php } else { ?>
        <article class="factura">
            <h2>Factura</h2>
            <hr>
            <h3>CASA XOXÓCTIC</h3>
            <h4>CASA XOXÓCTIC Café, bakery y eco tienda.</h4>
            <div class="f_div">
                <p>Fecha: 00/00/00</p>
                <p>Hora: 0:00:00 PM</p>
            </div>
            <h5>**** PRE - CUENTA ****</h5>
            <hr>
            <p><span>Cant. Descripción</span><span>Total</span></p>
            <hr>
            <p>
                <span>1 Menú número 1</span>
                <span>$0.00</span>
            </p>
            <br>
            <hr>
            <p>
                <span>Sub Total: </span>
                <span>$0.00</span>
            </p>
            <p>
                <span>Propina: </span>
                <span>$0.00</span>
            </p>
            <hr>
            <p>
                <strong><span>Total</span></strong>
                <strong><span>$0.00</span></strong>
            </p>
            <hr>
            <span class="centrado">NO VALIDO COMO TIQUETE</span>
            <hr>
            <span class="centrado">- Cuenta Cerrada -</span>
            <span class="centrado">Transacción en dolares Americanos.</span>
        </article>
        <?php } ?>
        <!-- block activo -->
        <article class="block_activo">
            <h3>Ordenes Abiertas</h3>
            <p class="fecha">Fecha: <?php echo date('d / m / Y'); ?></p>
            <a href="inicio.php"><button style="padding: 8px; font-size: 16px; background: #fff; color: #333; margin: 0 45px; border: 1px solid #333; border-radius: 4px;" >Actualizar</button></a>
            <div class="contenedor_principal">
                <?php 
                $sql = "SELECT * FROM Compartido";
                $query = $conn->prepare($sql);
                $query->execute();
                while($gow = $query->fetch(PDO::FETCH_ASSOC)){
                    if($gow['IDAC'] != null){
                        $xql = "SELECT * FROM Activo_C WHERE IDAC=:id";
                        $xuery = $conn->prepare($xql);
                        $xuery->bindParam(':id' , $gow['IDAC']);
                        $xuery->execute();
                        $row = $xuery->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="contenedor_selectivo">
                    <div class="cs_up">
                        <ul class="cs_info">
                            <li><b>Cliente: </b><?= $row['Cliente']; ?></li>
                            
                            <li><b>Hora: </b> <?= $row['Hora']; ?></li>
                        </ul>
                        <ul class="cs_info">
                            <li><b>Mesa: </b># <?= $row['Mesa']; ?></li>
                            <li><b>Mesero: </b><?= $row['Mesero']; ?></li>
                        </ul>
                        <ul class="cs_info">
                            <li><b>Orden: </b># <?= $row['IDAC']; ?></li>
                            <?php
                            $ins = 0;
                            $f = $conn->prepare("SELECT * FROM Descripcion_C WHERE IDAC=:idac");
                            $f->bindParam(':idac' , $row['IDAC']);
                            $f->execute();
                            $tok = 0;
                            while($e = $f->fetch(PDO::FETCH_ASSOC)){
                                
                                $l = $conn->prepare("SELECT * FROM Menu_C WHERE IDMEC=:idme");
                                $l->bindParam(':idme' , $e['IDMEC']);
                                $l->execute();
                                $m = $l->fetch(PDO::FETCH_ASSOC);
                                $tok = $tok + (Precio($m['IDMEC']) * $e['Cantidad']); 
                            }
                            if(!empty($row['des_alternativo'])){
                                $fac = $row['des_alternativo'];
                                $deal = (($tok/100)*$fac);
                                $book = $tok - $deal;
                                $ins = 1;
                            }
                            ?>
                            <li>
                                <b>Total:</b> $
                                <?php 
                                if($ins == 1){ 
                                    if($row['propina'] == 0){
                                        echo number_format($book , 2) . " . <p style='font-size: 13px; color: darkgreen;'> ($".number_format($tok , 2)." , ".$fac."%)</p>"; 
                                    } else {
                                        $book = $book * 1.10;
                                        echo number_format($book , 2) . " . <p style='font-size: 13px; color: darkgreen;'> ($".number_format($tok , 2)." , ".$fac."%)</p>"; 
                                    }
                                } else { 
                                    if($row['propina'] == 1){
                                        $tok = $tok * 1.10;
                                        echo number_format($tok , 2);  
                                    } else {
                                        echo number_format($tok , 2) . "<sup>*no incluye propina*</sup>";   
                                    }
                                } 
                                ?>
                            </li>
                        </ul>
                    </div>
                    <div class="cs_down">
                        <ul class="cs_boton">
                            <li><a href="php/fun/eliminar_orden.php?final=<?= $row['IDAC']; ?>&compartido=<?= $gow['IDCompartido']; ?>"><button style="background: darkred; color: #fff;">Eliminar</button></a></li>
                            <li><a href="?ver=<?= $row['IDAC']; ?>"><button>Detalles</button></a></li>
                            <li><a href="print/pre_cuenta.php?final=<?= $row['IDAC']; ?>"><button>Pre Orden</button></a></li>
                            <li><a href="orden_edit.php?menu=<?= $row['IDAC']; ?>"><button>Editar</button></a></li>
                            <?php if($row['propina'] == 1){ ?>
                            <li><a href="php/fun/propina.php?ida=<?= $row['IDAC']; ?>&date=1"><button style="background: rgb(0,100,0); color: #fff;">Quitar Propina</button></a></li>
                            <?php } elseif($row['propina'] == 0){ ?>
                            <li><a href="php/fun/propina.php?ida=<?= $row['IDAC']; ?>&date=0"><button style="background: rgb(100,0,0); color: #fff;">Añadir Propina</button></a></li>
                            <?php } ?>
                            <li><a href="print/ticket_cafe.php?id=<?= $row['IDAC']; ?>"><button style="color: #fff; background: darkgreen;">Finalizar</button></a></li>
                        </ul>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </article>
    </section>
</body>
</html>