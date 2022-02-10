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
    <section class="menu">
        <article class="contenedor_cubo">
            <?php
            $bloc = "SELECT * FROM secciones_c";
            $blac = $conn->prepare($bloc);
            $blac->execute();
            while($b = $blac->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="cubo color<?= $b['color']; ?>" id="tipo<?= $b['id']; ?>">
                <div class="blur"></div>
                <img src="img/iconos/<?= $b['icono']; ?>" alt="">
                <p><?= $b['nombre']; ?></p>
            </div>
            <?php
            }
            ?>
            <a href="secciones.php"><div class="cubo" id="">
                <p>+</p>
            </div></a>
        </article>
        <?php 
        $tab = "SELECT * FROM secciones_c";
        $tub = $conn->prepare($tab);
        $tub->execute();
        while($t = $tub->fetch(PDO::FETCH_ASSOC)){
            $css = "";
            $open = 0;
            if($t['habil'] == 1){
                $css = "deshabil";
                $open = 1;
            }
        ?>
        
        <article class="menu_detalle <?= $css; ?>" id="menu<?= $t['id']; ?>">
            <div class="option-menu color<?= $t['color']; ?>-blur">
                <a href="menu_edit.php?fun=3&tipo=<?= $t['id']; ?>"><p><!--Añardir un producto-->A</p></a>
                <a href="config_section.php?id=<?= $t['id']; ?>"><p><!--Configuración-->C</p></a>
                <a href="addmasivo.php?id=<?= $t['id']; ?>"><p><!--Añadir Descuentos Masivos-->M+</p></a>
                <a href="php/fun/dlt_descuento_masivo.php?id=<?= $t['id']; ?>"><p><!--Quitar Descuentos Masivos-->M-</p></a> 
                <?php if($t['habil'] == 0){ ?>
                <a href="php/fun/habil.php?h=1&id=<?= $t['id']; ?>"><p><!--Deshabilitar-->D</p></a>
                <?php } else { ?>
                <a href="php/fun/habil.php?h=0&id=<?= $t['id']; ?>"><p><!--Deshabilitar-->H</p></a>
                <?php } ?>
                <p class="cancel-box"><!--Cerrar-->X</p>
            </div>
            <ul>
                <li></li>
            <?php
            $sql = "SELECT * FROM Menu_C WHERE Grupo = :i";
            $query = $conn->prepare($sql);
            $query->bindParam(':i' , $t['id']);
            $query->execute();
            while($a = $query->fetch(PDO::FETCH_ASSOC)){
                $css3 = "";
                $door = 0;
                if($open == 0){
                    if($a['habil'] == 1){
                        $css3 = "deshabil-only";
                        $door = 1;
                    }
                }
            ?>
                <li class="<?= $css3; ?>">
                    <div class="md_info">
                        <p><?= $a['Producto']; ?></p>
                        <p>$<?php echo Precio($a['IDMEC'] , 1); ?></p>
                    </div>
                    <div class="md_boton">
                        <a <?php if($open == 0 && $door == 0){ ?>href="menu_edit.php?fun=1&pro=<?= $a['IDMEC']; ?>" <?php } ?> >
                            <button>Editar</button>
                        </a>
                        <a <?php if($open == 0 && $door == 0){ ?>href="menu_edit.php?fun=2&pro=<?= $a['IDMEC']; ?>" <?php } ?> >
                            <button>Descuento</button>
                        </a>
                        <?php if($a['habil'] == 0){ ?>
                        <a <?php if($open == 0){ ?>href="php/fun/habil_only.php?h=1&id=<?= $a['IDMEC']; ?>" <?php } ?> >
                            <button>Deshabilitar</button>
                        </a>
                        <?php } else { ?>
                        <a <?php if($open == 0){ ?>href="php/fun/habil_only.php?h=0&id=<?= $a['IDMEC']; ?>" <?php } ?> >
                            <button style="background-color: #fff !important;">Habilitar</button>
                        </a>
                        <?php } ?>
                        <a <?php if($open == 0 && $door == 0){ ?>href="php/fun/eliminar_menu.php?menu=<?= $a['IDMEC']; ?>" <?php } ?> >
                            <button class="but-dlt"> Eliminar</button>
                        </a>
                    </div>
                </li>
            <?php } ?>
                <li></li>
            </ul>
        </article>
        <?php } ?>
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.menu_detalle').hide();
            var doll = 0;
            <?php
            $kim = "SELECT * FROM secciones_c";
            $kun = $conn->prepare($kim);
            $kun->execute();
            while($k = $kun->fetch(PDO::FETCH_ASSOC)){
            ?>
            $('#tipo<?= $k['id']; ?>').click(function(){
                $('.menu_detalle').hide();
                $('#menu<?= $k['id']; ?>').show();
                $('.cubo .blur').css({'background':'transparent'});
                $('#tipo<?= $k['id']; ?> .blur').css({'background' : 'rgba(0,0,0,0.2)'});
                
            });
            <?php } ?>
            $('.cancel-box').click(function(){
                $('.menu_detalle').hide();
                $('.cubo .blur').css({'background':'transparent'});
            });
        });
    </script>
</body>
</html>