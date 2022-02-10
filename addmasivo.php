<?php
session_start();
error_reporting(0);
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
if(!isset($_GET['id'])){
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
        <!-- -->
        <h1 class="titu_edit">Aplicar Descuento Masivo</h1>
        <article class="medium">
            <form action="php/fun/add_descuento_masivo.php?grupo=<?= $_GET['id']; ?>" method="post">  
                <section>
                    <label for="dd" class="tipo-check">Tipo descuento </label> <input type="checkbox" id="dd" class="dd" value="1" name="check">
                    <article class="dp">
                        <label for="" class="label-porcent">Descuento Porcentaje: <span class="leter-porcent">%</span></label>
                        <input type="number" placeholder="100" id="precio" name="percent" max="100" min="0" >
                    </article>
                    <article class="di">
                        <label for="" class="label-d-des">Descuento Directo: <span class="leter-d-des">$</span></label>
                        <input type="number" placeholder="0.00" id="precio" name="directo" min="0">
                    </article>
                </section>
                <label class="fecha-in">Fecha de Inicio: </label>
                <input type="date" value="<?= date('Y-m-d'); ?>" min="<?= date('Y-m-d'); ?>" required name="inicio"><br>
                <label class="fecha-ex">Fecha Expiraci&oacute;n: </label>
                <input type="date" value="<?= date('Y-m-d'); ?>" min="<?= date('Y-m-d'); ?>" required name="fin"><br><br>
                <a href="menu.php" class="regre">Regresar</a>
                <input type="submit" value="Actualizar">
            </form>
        </article>
        <!-- -->
    </section>
</body>
</html>