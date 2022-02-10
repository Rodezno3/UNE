<?php 
session_start();
if(!isset($_SESSION['mesero'])){
    header("location: index.php");
}
date_default_timezone_set('America/El_Salvador'); 
require "php/fun/conexion.php";
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
        var cook = 0;
        var total = 0; 
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
        <h3>Pre Orden</h3>
        <hr>
        <div id="prepa">
        <?php 
        $can = "SELECT * FROM Descripcion_C WHERE IDAC=:idac";
        $cen = $conn->prepare($can);
        $cen->bindParam(':idac' , $_GET['menu']);
        $cen->execute();
        $tock = 0;
        while($cin = $cen->fetch(PDO::FETCH_ASSOC)){
            $dan = "SELECT Producto, Precio FROM Menu_C WHERE IDMEC=:idmec";
            $den = $conn->prepare($dan);
            $den->bindParam(':idmec' , $cin['IDMEC']);
            $den->execute();
            $din = $den->fetch(PDO::FETCH_ASSOC);
            $dun = $cin['Cantidad'] * $din['Precio'];
            $tock = $tock + $dun;
        ?>
            <p><span><?= $cin['Cantidad'] ?> <?= $din['Producto'] ?></span> <span> $<?= number_format($din['Precio'] , 2); ?></span></p>
        <?php } ?>
        <script>
            total = <?= number_format($tock); ?>
        </script>
        </div>
        <hr>
        <p><span class="toty">Total:</span> <span class="toty">$<input type="text" value="<?= number_format($tock); ?>" id="tere"> </span></p>
        <a href="orden_edit.php"><button id="limpiar">Limpiar Orden</button></a>
    </section>
    <script type="text/javascript">
        $('#limpiar').click(function(){
            var cero = (0).toFixed(2);
            $('#tere').val(cero);
            $('#prepa').empty();
            var x = 0;
            var a = 'a' + x;
            var b = 'b' + x;
            while(x < 24){
                a = 'a' + x;
                b = 'b' + x;
                if(Cookies.get(a)){
                    Cookies.set(a , false , { expires: -1 , path: '/' });
                    Cookies.set(b , false , { expires: -1 , path: '/' });
                }
                x++;
            }
        });
    </script>
    <section class="menu_contenedor">
        <form action="php/fun/add_orden.php" method="post">
            <article id="info_cliente">
                <input type="text" placeholder="Nombre Cliente" id="name_cliente" name="name" value="Anónimo" required>
                <p id="mesa_btn">Mesa</p>
                <input type="text" style="display:none;" name="mesa" id="mesa" required>
                <label for="llevar" id="palle">Para llevar</label>
                <input type="checkbox" id="llevar" name="llevar" value="1">
                <input type="submit" value="Agregar Orden" id="enviar">
            </article>
            <article></article>
        </form>
        <article class="contenedor_cubo">
            <div class="cc_box">
                <div class="cubo" id="tipo1">
                    <img src="img/iconos/004-taza-de-caf-1.png" alt="">
                    <p>Espresso</p>
                </div>
                <div class="cubo" id="tipo2">
                    <img src="img/iconos/005-taza-de-caf-2.png" alt="">
                    <p>Iced Coffee</p>
                </div>
                <div class="cubo" id="tipo3">
                    <img src="img/iconos/006-t-helado.png" alt="">
                    <p>Cold Drinks</p>
                </div>
                <div class="cubo" id="tipo4">
                    <img src="img/iconos/002-t-verde.png" alt="">
                    <p>Hot Drinks</p>
                </div>
                <div class="cubo" id="tipo5">
                    <img src="img/iconos/001-maquina-de-cafe.png" alt="">
                    <p>Specialty Coffe</p>
                </div>
                <div class="cubo" id="tipo6">
                    <img src="img/iconos/008-panadera.png" alt="">
                    <p>Bread order</p>
                </div>
                <div class="cubo" id="tipo7">
                    <img src="img/iconos/007-tarta-de-queso.png" alt="">
                    <p>House Sweets</p>
                </div>
                <div class="cubo" id="tipo8">
                    <img src="img/iconos/009-galleta-salada.png" alt="">
                    <p>Snacks</p>
                </div>
            </div>
        </article>
        <article class="menu_detalle" id="menu1">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 1";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 1;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu2">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 2";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 2;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu3">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 3";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 3;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu4">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 4";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 4;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu5">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 5";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 5;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu6">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 6";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 6;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu7">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 7";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 7;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu8">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 8";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 8;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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
        <article class="menu_detalle" id="menu9">
            <ul>
            <?php 
            $sql = "SELECT * FROM Menu WHERE Grupo = 9";
            $query = $conn->prepare($sql);
            $query->execute();
            $kil = 8;
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
                            Cookies.set(supcook , '<?= $a['IDME']; ?>' , { expires: 1 , path: '/' });
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