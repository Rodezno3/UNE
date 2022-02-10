<?php 
error_reporting(0);
session_start();
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
date_default_timezone_set('America/El_Salvador'); 
require "php/fun/conexion.php";
require "php/fun/tiempo.php";
if(isset($_COOKIE['menu'])){
    var_dump($_COOKIE);
    echo "Si hay una coookie";
}
for($i=0 ; $i<=24 ; $i++){
    $a = "a".$i;
    $b = "b".$i;
    if(isset($_COOKIE[$a])){
        setcookie($a , false , $expire = time() -100 , "/");
        setcookie($b , false , $expire = time() -100 , "/");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Casa Xoxoctic</title>
    <!-- estilos -->
    <link rel="stylesheet" href="css/estilos_header.css">
    <link rel="stylesheet" href="css/estilos_menu.css">
    <link rel="stylesheet" href="css/estilos_orden.css">
    <link rel="stylesheet" href="css/estilos_index.css">
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/boilerplate.css">
    <!-- scripts -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script type="text/javascript">
    var total = 0;
    var cook = 0;
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        var llevar = 0;
        $('#palle').click(function(){
            if(llevar == 0){
                $('#palle').css({'background':'forestgreen'});
                llevar = 1;
            } else {
                $('#palle').css({'background':'#fff'});
                llevar = 0;
            }
        });
    });
    </script>
    <script type="text/javascript" src="js/panel.js"></script>
	<script src="js/js.cookies.js"></script>
</head>
<body>
    <?php require "php/header.php"; ?>
    <div id="contenedor_preorden">
    <section class="preorden">
        <h3>Pre Orden Tienda</h3>
        <hr>
        <div id="prepa">
        </div>
        <hr>
        <p><span class="toty">Total:</span> <span class="toty">$ <input type="text" value="0.00" id="tere"> </span></p>
        <a href="nueva_orden_tienda.php"><button id="limpiar">Limpiar Orden</button></a>
    </section>
    <section class="menu_contenedor">
        <form action="php/fun/add_orden_tienda.php" method="post">
            <article id="info_cliente">
                <input type="text" placeholder="Nombre Cliente" id="name_cliente" name="name" value="Anónimo" required>
                <input type="submit" value="Agregar Orden" id="enviar">
            </article>
            <article></article>
        </form>
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
        $xql = "SELECT * FROM Secciones_T";
        $xuery = $conn->prepare($xql);
        $xuery->execute();
        for($i=1 ; $i<=$contador ; $i++){
            $xow = $xuery->fetch(PDO::FETCH_ASSOC);
        ?>
        <article class="menu_detalle" id="menu<?= $i; ?>">
            <ul>
            <?php 
            $sql = "SELECT * FROM Articulo_T WHERE IDSE=:i";
            $query = $conn->prepare($sql);
            $query->bindParam(':i' , $xow['ID']);
            $query->execute();
            $kil = $i;
            $idu = $kil . 10;
            while($a = $query->fetch(PDO::FETCH_ASSOC)){
            ?>
                <li>
                    <div class="md_info">
                        <p><?= $a['Producto']; ?></p>
                        <p>$<?= number_format($a['Precio'] , 2); ?></p>
                    </div>
                    <div class="md_boton">
                        <span id="less<?= $idu; ?>" class="minus">-</span>
                        <input type="text" value="1" max="100" id="uni<?= $idu; ?>" class="formate">
                        <span id="plus<?= $idu; ?>" class="plusle">+</span>
                        <button id="s<?= $idu; ?>"><span></span> Agregar</button>
                        <button id="n<?= $idu; ?>"><span></span> Quitar</button>
                    </div>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        //número
                        var uni<?= $idu; ?> = 1;
                        $('#plus<?= $idu; ?>').click(function(){
                            if(uni<?= $idu; ?> < 100){
                                uni<?= $idu; ?>++;
                                $('#uni<?= $idu; ?>').val(uni<?= $idu; ?>);
                            }
                        });
                        $('#less<?= $idu; ?>').click(function(){
                            if(uni<?= $idu; ?> > 1){
                                uni<?= $idu; ?>--;
                                $('#uni<?= $idu; ?>').val(uni<?= $idu; ?>);
                            }
                        });
                        //'cookie
                        $('#n<?= $idu; ?>').hide();
                        var ki<?= $idu; ?> = 0;
                        var ko<?= $idu; ?> = 0;
                        var hu<?= $idu; ?> = 0;
                        $('#s<?= $idu; ?>').click(function(){
                            //funcion de cookie
                            var pri = <?= $a['Precio']; ?>;
                            var rip = $('#uni<?= $idu; ?>').val();
                            var pir = (pri * rip).toFixed(2);
                            var supcook = 'a' + cook;
                            var subcook = 'b' + cook;
                            ko<?= $idu; ?> = supcook;
                            hu<?= $idu; ?> = subcook;
                            Cookies.set(supcook , '<?= $a['IDART']; ?>' , { expires: 1 , path: '/' });
                            Cookies.set(subcook , rip , { expires: 1 , path: '/' });
                            ki<?= $idu; ?> = rip;
                            cook++;
                            total = (parseFloat(total) + parseFloat(pir)).toFixed(2);
                            $('#tere').val(total);
                            $('#prepa').append('<p id="<?= $idu; ?>"><span>'+rip+' <?= $a['Producto']; ?></span> <span> $'+pir+'</span></p>');
                            $('#n<?= $idu; ?>').show();
                            $('#s<?= $idu; ?>').hide();
                        });
                        $('#n<?= $idu; ?>').click(function(){
                            //funcion de cookie
                            var fir = <?= $a['Precio']; ?>;
                            var rif = $('#uni<?= $idu; ?>').val();
                            if(rif > ki<?= $idu; ?>){
                                rif = ki<?= $idu; ?>;
                            }
                            var fri = (fir * rif).toFixed(2);
                            Cookies.set(ko<?= $idu; ?> , '<?= $a['Producto']; ?>' , { expires: -1 , path: '/' });
                            Cookies.set(hu<?= $idu; ?> , rif , { expires: -1 , path: '/' });
                            total = (parseFloat(total) - parseFloat(fri)).toFixed(2);
                            $('#tere').val(total);
                            $('#<?= $idu; ?>').remove();
                            $('#s<?= $idu; ?>').show();
                            $('#n<?= $idu; ?>').hide();
                        });
                    });
                    </script>
                </li>
            <?php $idu++; } ?>
                <li></li>
            </ul>
        </article>
        <?php } ?>
        
    </section>
    </div>
    <div id="panel_mesa">
        <section id="cubo">
            <h1>Número de mesa</h1>
                <input type="text" name="pin" maxlength="5" id="pin"><br>
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
                    <li id="x" class="cancel">X</li>
                    <li id="0">0</li>
                    <li id="ok" class="go">Ok</li>
                </ul>
            </article>
        </section>
    </div>
</body>
</html>
