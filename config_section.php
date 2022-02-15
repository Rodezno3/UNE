<?php 
session_start();
error_reporting(0);
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
date_default_timezone_set('America/El_Salvador'); 
require "php/fun/conexion.php";
require "php/fun/funciones.php";

$prueba = "SELECT * FROM secciones_c WHERE id=:id";
$beta = $conn->prepare($prueba);
$beta->bindParam(':id', $_GET['id']);
$beta->execute();
$z = $beta->fetch(PDO::FETCH_ASSOC);
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
    <script type="text/javascript" src="js/pre-icono.js"></script>
    <script type="text/javascript">
    function color(num){
        var colores = "color" + num;
        $('#icon-prueba').removeAttr('class');
        $('#icon-prueba').addClass(colores);
    }
    function images(img, gup){
        $('#prub-img').removeAttr('src');
        $('#prub-img').attr("src", "img/iconos/" + gup + "/" + img);
    }
    </script>
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
            <section class="contenedor-colors">
                <?php
                $color = 1;
                for($j=1 ; $j<=5 ; $j++){ ?>
                <article class="box-colors">
                    <?php for($k=1 ; $k<=4 ; $k++){ ?>
                    <input type="radio" id="<?= $color; ?>" name="color" value="<?= $color; ?>" class="radio">
                    <label for="<?= $color; ?>" onclick="color(<?= $color; ?>)"><div class="colors color<?php echo $color; $color++; ?>"></div></label>
                    <?php } ?>
                </article>
                <?php } ?>
            </section>
            <section>
                <div id="icon-prueba">
                   <!-- solo prueba, despues quitar la ruta -->
                    <img src="img/iconos/antiguo/<?= $z['icono']; ?>" id="prub-img">
                    <p></p>
                </div>
                <div class="info-prueba">
                    <ul>
                        <li class="shadow-icon"></li>
                        <li class="shadow-icon"></li>
                        <li class="shadow-icon"></li>
                        <li class="shadow-icon"></li>
                        <li class="empty-icon"></li>
                        <li class="shadow-icon"></li>
                    </ul>
                    <ul>
                        <li class="shadow-info"></li>
                        <li class="shadow-info"></li>
                        <li class="shadow-info"></li>
                        <li class="shadow-info"></li>
                        <li class="shadow-info"></li>
                    </ul>
                </div>
            </section>
        </article>
        <article>
            <div>
                <label for="">Icono Activo:</label>
                <img src="" alt="">
            </div>
            <section class="contenedor-icon">
            <?php 
                $listIcon = ['antiguo', 'coffee', 'beer', 'delivery', 'gastronomy', 'farming', 'international', 'bakery', 'tea', 'wine']; 
                $itemIcon = count($listIcon);
                $listName = ['Iconos Antiguos', 'Café', 'Cerveza', 'Comida Rápida', 'Gastronomía', 'Granja', 'Internacional', 'Panadería', 'Té', 'Vino'];
                $itemName = count($listName);
                $id = 0;
                
                for($i=0 ; $i<=$itemIcon ; $i++){
                    $lich = "SELECT * FROM icons WHERE grupo = :item";
                    $chill = $conn->prepare($lich);
                    $chill->bindParam(':item' , $listIcon[$i]);
                    $chill->execute();
                    
                    $c = $chill->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="titulo-icon">
                    <p><?= $listName[$i]; ?></p>
                    <div></div>
                </div>
                <section class="content-iconos">
                    <?php do{ ?>
                    <input type="radio" id="<?= $id; ?>" name="icono" value="<?= $c['id']; ?>" class="radio">
                    <article class="box-icon" onclick="images('<?= $c['iconame']; ?>', '<?= $c['grupo'] ?>')">
                        <label for="<?= $id; ?>">
                        <div class="item-icon">
                            <img src="img/iconos/<?= $c['grupo'] . "/" . $c['icon']; ?>" alt="<?= $c['iconame']; ?>">
                            <p><?= $c['iconame']; ?></p>
                        </div>
                        </label>
                    </article>
                    <?php $id++; } while($c = $chill->fetch(PDO::FETCH_ASSOC)); ?>
                </section>
            <?php } ?>
            </section>
        </article>
        </form>
    </section>
</body>
</html>