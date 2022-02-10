<?php 
session_start();
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- estilos -->
    <link rel="stylesheet" href="css/estilos_header.css">
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/boilerplate.css">
    <link rel="stylesheet" href="css/estilos_menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Dosis:wght@500&display=swap" rel="stylesheet">
    <!-- scripts -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
</head>
<body>
    <?php require "php/header.php"; ?>
    <section class="menu">
        <article class="contenedor_cubo">
            <div class="cc_box">
                <?php
                $zql = "SELECT * FROM Secciones_T";
                $zuery = $conn->prepare($zql);
                $zuery->execute();
                $contador = 0;
                while($zow = $zuery->fetch(PDO::FETCH_ASSOC)){
                    $contador++;
                ?>
                <div class="cubo" id="tipo<?= $contador; ?>">
                    <img src="img/iconos/<?= $zow['Img']; ?>" alt="">
                    <p><?= $zow['Nombre']; ?></p>
                </div>
                <?php } ?>
                <a href="nueva_seccion.php" id="add_sec"><div class="cubo">
                    <span>+</span>
                </div></a>
            </div>
        </article>
        <?php 
        $xql = "SELECT ID FROM Secciones_T";
        $xuery = $conn->prepare($xql);
        $xuery->execute();
        for($i=1 ; $i<=$contador ; $i++){
            $xow = $xuery->fetch(PDO::FETCH_ASSOC);
        ?>
        <article class="menu_detalle" id="menu<?= $i; ?>">
            <ul>
            <?php
            $sql = "SELECT * FROM Articulo_T WHERE IDSE = :i";
            $query = $conn->prepare($sql);
            $query->bindParam(':i' , $xow['ID']);
            $query->execute();
            while($a = $query->fetch(PDO::FETCH_ASSOC)){
            ?>
                <li>
                    <div class="md_info">
                        <p><?= $a['Producto']; ?></p>
                        <p>$<?= number_format($a['Precio'] , 2); ?></p>
                    </div>
                    <div class="md_boton">
                        <a href="articulo_edit.php?fun=1&pro=<?= $a['IDART']; ?>"><button><span></span> Editar</button></a>
                        <a href="php/fun/eliminar_menu.php?menu=<?= $a['IDART']; ?>"><button><span></span> Eliminar</button></a>
                    </div>
                </li>
            <?php } ?>
                <li>
                    <a href="articulo_edit.php?fun=3&tipo=<?= $i; ?>&id=<?= $xow['ID']; ?>"><button>Agregar Artículo</button></a> <br>
                    <a href="php/fun/delete_section.php?art=<?= $xow['ID']; ?>"><button style="background: indianred; color: #000;">Eliminar Sección</button></a>
                </li>
            </ul>
        </article>
        <?php } ?>
    </section>
</body>
</html>