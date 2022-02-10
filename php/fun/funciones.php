<?php 
//ingresar el id del menú
function Precio($menu , $param){
    require "conexion.php";
    $man = "SELECT Precio FROM menu_c WHERE IDMEC=:idme";
    $men = $conn->prepare($man);
    $men->bindParam(':idme' , $menu);
    $men->execute();
    $min = $men->fetch(PDO::FETCH_ASSOC);
    
    $dan = "SELECT * FROM descuento_c WHERE IDMEC=:id";
    $den = $conn->prepare($dan);
    $den->bindParam(':id' , $menu);
    $den->execute();
    
    if($din = $den->fetch(PDO::FETCH_ASSOC)){
        $hoy = strtotime(date('Y-m-d'));
        $fechaIn = strtotime($din['FechaIn']);
        $fechaFi = strtotime($din['FechaFi']);
        
        if($fechaIn <= $hoy && $fechaFi >= $hoy){
            //Si la fecha esta en el rango
            if(!empty($din['DescuentoPo'])){
                $descuento = (($min['Precio'] * $din['DescuentoPo'])/100);
                $cuenta = $min['Precio'] - $descuento;
            } elseif(!empty($din['DescuentoDi'])){
                $cuenta = $din['DescuentoDi'];
                $descuento = $min['Precio'] - $cuenta;
            } else {
                $precio = number_format($min['Precio'], 2);
            }
            
            if(!empty($param)){
                if($param == 1){
                    //Si se necesita con el precio original y tachado
                    $procesado = "<span class='pre-new'>". number_format($cuenta , 2) ."</span>
                    <span class='pre-old'>$". number_format($min['Precio'] , 2) ."</span>";
                    $precio = $procesado;
                } elseif($param == 2){
                    //Si necesita sólo el precio de descuento
                    $precio = number_format($cuenta , 2);
                } elseif($param == 3){
                    //Si necesita sólo el descuento
                    $precio = number_format($descuento , 2);
                } else {
                    $precio = "Parametro desconocido";
                }
            } else {
                $precio = var_dump($param);
            }
            
        } elseif($fechaFi < $hoy){
            //Si la fecha ya expiró o paso del rango
            $sql = "DELETE FROM Descuento_C WHERE IDMEC=:id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id' , $_GET['menu']);
            $query->execute();
            $precio = number_format($min['Precio'], 2);
        } elseif($fechaIn > $hoy){
            //Si la fecha aún no ha llegado al rango
            $precio = number_format($min['Precio'] , 2);
        } else {
            //Si no se encontró ninguna de las anteriores
            $precio = number_format($min['Precio'], 2);
        }
    } else {
        $precio = number_format($min['Precio'] , 2);
    }
    
    return $precio;
}

//ingresar el id del menú
function PrecioFac($menu){
    require "conexion.php";
    $man = "SELECT Precio, Descuento FROM Menu WHERE IDME=:idme";
    $men = $conn->prepare($man);
    $men->bindParam(':idme' , $menu);
    $men->execute();
    $min = $men->fetch(PDO::FETCH_ASSOC);
    if($min['Descuento'] == 0){
        $pri = $min['Precio'];
    } else {
        $mon = (($min['Descuento']/100)*$min['Precio']);
        $pri = $min['Precio'] - $mon;
    }
    return $pri;
}
?>