<?php 
session_start();
error_reporting(0);
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
date_default_timezone_set('America/El_Salvador'); 
require "php/fun/conexion.php";
require "php/fun/funciones.php";
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
    <link rel="stylesheet" href="css/colores.css">
    <!-- Para hacer colores con php, hay que enviar parametros por .css? para que pueda resivirlos y se puedan mover desde este lado -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Dosis:wght@500&display=swap" rel="stylesheet">
    <!-- scripts -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <?php require "php/header.php"; ?>
    <h1 class="titu_edit">Editar Menú</h1>
    <section>
        <h4>Opciones de Edici&oacute;n</h4>
        <form action="">
        <article>
            <label for=""></label>
            <input type="text">
            <label for=""></label>
            <section>
                article.box-colors*5>div.colors*4>
            </section>
        </article>
        <article>
            <label for=""></label>
            <section>
            <?php  ?>
            </section>
        </article>
        </form>
    </section>
</body>
</html>