<?php

/*Lucas Valdiviezo Parcial 1 Programacion 3*/

if(isset($_GET["sabor"]) && isset($_GET["precio"]) && isset($_GET["tipo"]) && isset($_GET["cantidad"]))
{
    include "pizzaCarga.php";
}else if(isset($_POST["sabor"]) && isset($_POST["tipo"]) && isset($_POST["mail"]) && isset($_POST["cantidad"]) && isset($_FILES["foto"]))
{
    include "altaVenta.php";
}else if(isset($_POST["sabor"]) && isset($_POST["tipo"]))
{
    include "pizzaConsultar.php";
}else if(isset($_GET["consulta"]))
{
    include "consultasVentas.php";
}
else
{
    echo 'Complete todos los datos';
}

?>

