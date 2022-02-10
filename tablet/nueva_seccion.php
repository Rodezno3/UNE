<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <title>Casa Xoxoctic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- estilos -->
    <link rel="stylesheet" href="css/estilos_header.css">
    <link rel="stylesheet" href="css/estilos_menu.css">
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/boilerplate.css">
    <!-- scripts -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <script type="text/javascript" src="js/secciones.js"></script>
</head>
<body>
    <?php require "php/header.php"; ?>
    <section>
        <h1 class="titu_edit">Agregar Sección</h1>
        <article class="medium">
            <form action="php/fun/add_section.php" method="post">
                <label for="">Nombre: </label>
                <input type="text" placeholder="" id="caja_uni" required name="name"><br><br>
                <label for="img" id="open" style="padding: 7px; border-radius: 7px; border: 1px solid #999; margin: 15px;">Imagen</label><br>
                <input type="text" id="img" style="display:none;" name="img" required><br>
                <input type="submit" value="Ingresar" class="ingerir">
            </form>
        </article>
    </section>
    <section id="addimg">
        <div id="ai_cubo">
            <h1>Escoge una imágen</h1>
            <ul>
                <li id="1"><label for="sel1"><img src="img/iconos/1.png" alt="img"></label> <input type="radio" name="select" id="sel1"></li>
                <li id="2"><label for="sel2"><img src="img/iconos/2.png" alt="img"></label> <input type="radio" name="select" id="sel2"></li>
                <li id="3"><label for="sel3"><img src="img/iconos/3.png" alt="img"></label> <input type="radio" name="select" id="sel3"></li>
                <li id="4"><label for="sel4"><img src="img/iconos/4.png" alt="img"></label> <input type="radio" name="select" id="sel4"></li>
                <li id="5"><label for="sel5"><img src="img/iconos/5.png" alt="img"></label> <input type="radio" name="select" id="sel5"></li>
                <li id="6"><label for="sel6"><img src="img/iconos/6.png" alt="img"></label> <input type="radio" name="select" id="sel6"></li>
                <li id="7"><label for="sel7"><img src="img/iconos/7.png" alt="img"></label> <input type="radio" name="select" id="sel7"></li>
                <li id="8"><label for="sel8"><img src="img/iconos/8.png" alt="img"></label> <input type="radio" name="select" id="sel8"></li>
                <li id="9"><label for="sel9"><img src="img/iconos/9.png" alt="img"></label> <input type="radio" name="select" id="sel9"></li>
                <li id="10"><label for="sel10"><img src="img/iconos/10.png" alt="img"></label> <input type="radio" name="select" id="sel10"></li>
            </ul>
            <button id="close">Aceptar</button>
        </div>
    </section>
</body>
</html>