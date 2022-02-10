<?php
//require "php/fun/conexion.php"; 
var_dump($_COOKIE);
/*$a = 0;
$b = "a".$a;
while(isset($_COOKIE[$b])){
    $b = "a".$a;
    $c = "b".$a;
    foreach($_COOKIE[$b] as $k => $v){
        $m = $_COOKIE[$b][$k];
        $n = $_COOKIE[$c][$k];
        echo $m[$k];
        echo $n[$k];
    }
    setcookie($b , false , $expire = time() -1 , "/");
    setcookie($c , false , $expire = time() -1 , "/");
    $a++;
}
/*$sql = "INSERT INTO Description (IDA , IDME , Cantidad) VALUES (1 , 1 , 1)";
$query = $conn->prepare($sql);
if($query->execute()){
    echo "bien";
} else {
    echo "mal";
}*/
    
?>