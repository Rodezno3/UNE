<?php
session_start();
error_reporting(0);
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
if(!isset($_GET['fun'])){
    header("location: menu.php");
}
require "php/fun/conexion.php";
require "php/fun/tiempo.php";
date_default_timezone_set('America/El_Salvador');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <title>Casa Xoxoctic</title>
    <!-- estilos -->
    <link rel="stylesheet" href="css/estilos_header.css">
    <link rel="stylesheet" href="css/estilos_menu.css">
    <!-- scripts -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
</head>
<body>
    <?php require "php/header.php"; ?>
    <section>
        <?php if($_GET['fun'] == 1){
        $pro = $_GET['pro'];
        $sql = "SELECT Producto, Precio FROM Menu_C WHERE IDMEC=:idme";
        $query = $conn->prepare($sql);
        $query->bindParam(':idme' , $pro);
        $query->execute();
        $woz = $query->fetch(PDO::FETCH_ASSOC);
        ?>
        <!-- -->
        <h1 class="titu_edit">Editar Menú</h1>
        <article class="medium">
            <form action="php/fun/actpro.php?menu=<?= $pro; ?>" method="post">
                <label for="" class="lab-descrip">Descripción: </label>
                <input type="text" value="<?= $woz['Producto']; ?>" name="producto" id="descrip"><br>
                <label for="" class="lab-precio">Precio: <span class="leter-d-edi">$</span></label>
                <input type="number" value="<?= number_format($woz['Precio'] , 2); ?>" id="precio" name="precio" step="any">
                <div class="buttons">
                    <a href="menu.php" class="regre">Regresar</a>
                    <input type="submit" value="Actualizar">
                </div>
            </form>
        </article>
        <?php } elseif($_GET['fun'] == 2){ ?>
        <!-- -->
        <h1 class="titu_edit">Aplicar Descuento</h1>
        <?php 
        $s = "SELECT Producto, Precio FROM Menu_C WHERE IDMEC=:id";
        $q = $conn->prepare($s);
        $q->bindParam(':id' , $_GET['pro']);
        $q->execute();
        $f = $q->fetch(PDO::FETCH_ASSOC);

        $xql = "SELECT * FROM Descuento_C WHERE IDMEC=:id";
        $xuery = $conn->prepare($xql);
        $xuery->bindParam(':id' , $_GET['pro']);
        $xuery->execute();
        $full = false;

        if($xow = $xuery->fetch(PDO::FETCH_ASSOC)){
            $full = true;
        }
        ?>
        <article class="medium">
            <form action="php/fun/add_descuento.php?menu=<?= $_GET['pro']; ?>&tipo=<?php if($full){ echo "2"; } else { echo "1"; } ?>" method="post">
                
                <h3>Producto: <span style="margin-bottom: 10px; display: inline-block;"><?= $f['Producto']; ?></span> <br> Precio: <span>$<?= number_format($f['Precio'], 2); ?></span></h3>
                
                <section>
                    <?php if(!$full){ ?>
                    <label for="dd" class="tipo-check">Tipo descuento </label> <input type="checkbox" id="dd" class="dd" value="1" name="check">
                    <?php } ?>
                    <article class="dp" <?php if($full){ if(empty($xow['DescuentoPo'])){ echo "style='display: none;'"; } } ?> >
                        <label for="" class="label-porcent">Descuento Porcentaje: <span class="leter-porcent">%</span></label>
                        <input type="number" placeholder="100" id="precio" name="percent"
                        <?php if($full){ echo "value='".$xow['DescuentoPo']."'"; }  ?> max="100" min="0" step="any">
                    </article>
                    <article class="di" <?php if($full){ if(empty($xow['DescuentoDi'])){ echo "style='display: none;'"; } } ?> >
                        <label for="" class="label-d-des">Descuento Directo: <span class="leter-d-des">$</span></label>
                        <input type="number" placeholder="0.00" id="precio" name="directo"
                        <?php if($full){ echo "value='".$xow['DescuentoDi']."'"; } ?> min="0" max="<?= $f['Precio']; ?>" step="any">
                    </article>
                </section>
                <label class="fecha-in">Fecha de Inicio: </label>
                <input type="date" value="<?php if($full){ echo $xow['FechaIn']; } else { echo date('Y-m-d'); } ?>" min="<?= date('Y-m-d'); ?>" required name="inicio"><br>
                <label class="fecha-ex">Fecha Expiraci&oacute;n: </label>
                <input type="date" value="<?php if($full){ echo $xow['FechaFi']; } else { echo date('Y-m-d'); } ?>" min="<?= date('Y-m-d'); ?>" required name="fin"><br><br>
                <a href="menu.php" class="regre">Regresar</a>
                <?php 
                if($full){ ?>
                <a href="php/fun/dlt_descuento.php?menu=<?= $_GET['pro']; ?>" class="regre">Eliminar</a>
                <?php }  ?>
                <?php if($full){  ?>
                    <input type="submit" value="Actualizar">
                <?php } else { ?>
                <input type="submit" value="Ingresar">
                <?php }  ?>
            </form>
        </article>
        <!-- -->
        <?php } elseif($_GET['fun'] == 3){ ?>
        <h1 class="titu_edit">Agregar Producto</h1>
        <article class="medium">
            <form action="php/fun/ingresar_menu.php" method="post">
                <label for="">Producto: </label>
                <input type="text" placeholder="" id="caja_uni" required name="pro_ing"><br>
                <label for="" class="lab-precio">Precio: <span class="leter-d-edi">$</span></label>
                <input type="number" placeholder="0.00" id="precio" required name="pre_ing" step="any"><br>
                <input type="text" value="<?= $_GET['tipo']; ?>" style="display: none;" name="tipo" required><br>
                <a href="menu.php" class="regre">Regresar</a>
                <input type="submit" value="Ingresar" class="ingerir">
            </form>
        </article>
        <?php } ?>
    </section>
</body>
</html>