<?php 
session_start();
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
require "php/fun/conexion.php";
require "php/fun/funciones.php";
require "php/fun/tiempo.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- estilos -->
    <link rel="stylesheet" href="css/estilos_header.css">
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/boilerplate.css">
    <link rel="stylesheet" href="css/estilos_block_activos.css">
    <link rel="stylesheet" href="css/estilos_factura.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Dosis:wght@500&display=swap" rel="stylesheet">
    <!-- scripts -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <?php if($fdate == '1899/12/31'){ ?>
    <script>
      alert("Error de Hora, intentando reconectar...");
      function Redireccion(){
        window.location = 'inicio.php';
      }
      setTimeout("Redireccion()" , 1000);
    </script>
    <?php } ?>
    <script type="text/javascript" src="js/panel.js"></script>
    <?php 
    $fstar = strtotime("20:00:00");
    if($clock >= $fstar){
    ?>
    <script type="text/javascript">
      var cont = confirm("Hora de cierre de día.");
      if(cont == true){
          window.location="count.php";
       }
    </script>
    <?php } ?>

</head>
<body>
    <?php require "php/header.php"; ?>
    <!-- factura -->
    <section class="inicio">
        <!-- block activo -->
        <article class="block_activo">
            <h3>Ordenes Abiertas</h3>
            <p class="fecha">Fecha: <?php echo $fdate; ?></p>
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
                    <h5 style="text-align: center;">Café <span class="icon-coffee"></span></h5>
                    <div class="cs_up">
                        <ul class="cs_info">
                            <li><b>Cliente: </b><?= $row['Cliente']; ?></li>
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
                                $l = $conn->prepare("SELECT IDMEC , Precio FROM Menu_C WHERE IDMEC=:idme");
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
                            <li><b>Total: </b> $<?php if($ins == 1){ echo number_format($book , 2) . " . <p style='font-size: 13px; color: darkgreen;'> ($".number_format($tok , 2)." , ".$fac."%)</p>"; } else { echo number_format($tok , 2); } ?></li>
                            <li><b>Hora: </b> <?= $row['Hora']; ?></li>
                        </ul>
                    </div>
                    <div class="cs_down">
                        <ul class="cs_boton">
                            <li><a href="print/sub_ticket_cafe.php?final=<?= $row['IDAC']; ?>"><button>Pre Orden</button></a></li>
                            <li><a href="orden_edit_cafe.php?menu=<?= $row['IDAC']; ?>"><button>Editar Café</button></a></li>
                            <li><a href="facturar.php?final=<?= $row['IDAC']; ?>&tipo=1&orden=2"><button>Facturar Correo</button></a></li>
                            <li><a href="facturar.php?final=<?= $row['IDAC']; ?>&tipo=1&orden=1"><button style="background: darkgreen; color:#fff;">Facturar</button></a></li>
                            <li><a href="?ver=<?= $gow['IDAC']; ?>&case=coffee"><button>Detalles</button></a></li>
                            <?php if($row['propina'] == 1){ ?>
                            <li><a href="php/fun/propina.php?ida=<?= $row['IDAC']; ?>&date=1"><button style="background: rgb(0,100,0); color: #fff;">Quitar Propina</button></a></li>
                            <?php } elseif($row['propina'] == 0){ ?>
                            <li><a href="php/fun/propina.php?ida=<?= $row['IDAC']; ?>&date=0"><button style="background: rgb(100,0,0); color: #fff;">Añadir Propina</button></a></li>
                            <?php } ?>
                            <li><a href="php/fun/eliminar_orden.php?final=<?= $row['IDAC']; ?>&compartido=<?= $gow['IDCompartido']; ?>"><button class="clr_red" style="background: darkred; color:#fff;">Eliminar</button></a></li>
                        </ul>
                    </div>
                </div>
                <?php } elseif($gow['IDAT'] != null){
                        $xql = "SELECT * FROM Activo_T WHERE IDAT=:id";
                        $xuery = $conn->prepare($xql);
                        $xuery->bindParam(':id' , $gow['IDAT']);
                        $xuery->execute();
                        $row = $xuery->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="contenedor_selectivo">
                    <h5 style="text-align: center;">Tienda <span class="icon-shopping-basket"></span></h5>
                    <div class="cs_up">
                        <ul class="cs_info">
                            <li><b>Cliente: </b><?= $row['Cliente']; ?></li>
                            <li><b>Hora: </b> <?= $row['Hora']; ?></li>
                        </ul>
                        <ul class="cs_info">
                            <li><b>Orden: </b># <?= $row['IDAT']; ?></li>
                            <?php
                            $f = $conn->prepare("SELECT * FROM Descripcion_T WHERE IDAT=:idac");
                            $f->bindParam(':idac' , $row['IDAT']);
                            $f->execute();
                            $tok = 0;
                            while($e = $f->fetch(PDO::FETCH_ASSOC)){
                                $l = $conn->prepare("SELECT Precio FROM Articulo_T WHERE IDART=:idme");
                                $l->bindParam(':idme' , $e['IDART']);
                                $l->execute();
                                $m = $l->fetch(PDO::FETCH_ASSOC);
                                $tok = $tok + ($m['Precio'] * $e['Cantidad']); 
                            }
                            ?>
                            <li><b>Total: </b> $<?= number_format($tok , 2); ?></li>
                        </ul>
                    </div>
                    <div class="cs_down">
                        <ul class="cs_boton">
                            <li><a href="print/sub_ticket_tienda.php?final=<?= $row['IDAT']; ?>"><button>Pre Orden</button></a></li>
                            <li><a href="orden_edit_tienda.php?menu=<?= $row['IDAT']; ?>"><button>Editar Tienda</button></a></li>
                            <li><a href="facturar.php?final=<?= $row['IDAT']; ?>&tipo=2&orden=2"><button>Facturar Correo</button></a></li>
                            <li><a href="facturar.php?final=<?= $row['IDAT']; ?>&tipo=2&orden=1"><button style="background: darkgreen; color: #fff;">Facturar</button></a></li>
                            <li><a href="?ver=<?= $gow['IDAT']; ?>&case=tienda"><button>Detalles</button></a></li>
                            <li><a href="php/fun/eliminar_orden_tienda.php?final=<?= $row['IDAT']; ?>&compartido=<?= $gow['IDCompartido']; ?>"><button class="clr_red" style="background: darkred; color:#fff;">Eliminar</button></a></li>
                        </ul>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </article>
       
        <?php if(isset($_GET['ver'])){ 
        
        if($_GET['case'] == 'coffee'){
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
                <p>Fecha: <?= $fdate; ?></p>
                <p>Hora: <?= $clock; ?></p>
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
        
        <?php } elseif($_GET['case'] == 'tienda'){ 
        $s = "SELECT * FROM Activo_T WHERE IDAT=:ida";
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
                <p>Fecha: <?= date('d/m/Y'); ?></p>
                <p>Hora: <?= $r['Hora']; ?></p>
            </div>
            <h5>**** PRE - CUENTA ****</h5>
            <hr>
            <p><span>Cant. Descripción</span><span>Total</span></p>
            <hr>
            <?php 
            $pp = $r['IDAT'];
            $pre = "SELECT * FROM Descripcion_T WHERE IDAT=$pp";
            $consul = $conn->prepare($pre);
            $consul->execute();
            $total = 0;
            while($six = $consul->fetch(PDO::FETCH_ASSOC)){
                $cf = $conn->prepare("SELECT * FROM Articulo_T WHERE IDART=:six");
                $cf->bindParam(':six' , $six['IDART']);
                $cf->execute();
                $cb = $cf->fetch(PDO::FETCH_ASSOC);
            ?>
            <p>
                <span><?= $six['Cantidad'] ?> <?= $cb['Producto']; ?></span>
                <span>$<?= number_format($cb['Precio'] , 2); ?></span><span>$<?php $fan = number_format(($six['Cantidad'] * $cb['Precio']) , 2); echo $fan; ?></span>
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
        <?php } else {
            header("location: inicio.php");
        } ?>
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
        
    </section>
    <!-- -->
    <div id="panel_mesa">
        <section id="cubo">
            <h1>Número de mesa</h1>
                <input type="text" name="pin" maxlength="5" id="pin"><button>X</button><br>
            <article id="panel">
                <ul>
                    <li id="1">1</li>
                    <li id="2">2</li>
                    <li id="3">3</li>
                </ul>
                <ul>
                    <li id="4">4</li>
                    <li id="5">5</li>
                    <li id="6">6</li>
                </ul>
                <ul>
                    <li id="7">7</li>
                    <li id="8">8</li>
                    <li id="9">9</li>
                </ul>
                <ul>
                    <li id="p" class="cancel">.</li>
                    <li id="0">0</li>
                    <li id="ok" class="go">Ok</li>
                </ul>
            </article>
        </section>
    </div>
    <div id="panel_cliente">
        <section id="cubo">
            <h1>Número de Clientes</h1>
                <input type="text" name="pin" maxlength="5" id="pins"><br>
            <article id="panel">
                <ul>
                    <li id="1s">1</li>
                    <li id="2s">2</li>
                    <li id="3s">3</li>
                </ul>
                <ul>
                    <li id="4s">4</li>
                    <li id="5s">5</li>
                    <li id="6s">6</li>
                </ul>
                <ul>
                    <li id="7s">7</li>
                    <li id="8s">8</li>
                    <li id="9s">9</li>
                </ul>
                <ul>
                    <li id="xs" class="cancel">X</li>
                    <li id="0s">0</li>
                    <li id="oks" class="go">Ok</li>
                </ul>
            </article>
        </section>
    </div>
    <!-- -->
</body>
</html>