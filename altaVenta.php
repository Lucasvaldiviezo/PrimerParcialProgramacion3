<?php

include_once "venta.php";
include_once "pizza.php";
$sabor = $_POST["sabor"];
$tipo = $_POST["tipo"];
$mail = $_POST["mail"];
$cantidad = $_POST["cantidad"];

$venta = new Venta();
$venta->__construct1($sabor,$mail,$tipo,$cantidad);
$resultado = $venta->RealizarVenta("Pizza.json");

if($resultado == true)
{
    echo 'Se realizo la venta';
}else
{
    echo $resultado;
}

?>