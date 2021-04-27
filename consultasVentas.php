<?php

include_once "venta.php";
include_once "pizza.php";

/* Cantidad vendida de un producto por un usuario------------*/
echo '-Cantidad total vendida: ' . "\n";
$ventas = Venta::CantidadVendidaPizza();
foreach($ventas as $ven)
{
    echo  "Total: " . $ven["cantidad"] . "\n";
}

/*Ventas entre fechas-------------------------------*/
echo  "\n". '-Ventas entre Fechas : ' . "\n";
$ventas = Venta::VentaEntreFechas("2021-04-26","2021-04-28");
$dibujo = Venta::DibujarListado($ventas);
echo $dibujo;

/*Ventas de un usuario-------------------------------*/
echo "\n". '-Ventas de un Usuario: ' . "\n";
$ventas = Venta::VentasDeUsuario("lucas@lucas.com.ar");
$dibujo2 = Venta::DibujarListado($ventas);
echo $dibujo2;

/*Ventas por un sabor-------------------------------*/
echo "\n". '-Ventas de un sabor: ' . "\n";
$ventas = Venta::VentasPorSabor("Jamon");
$dibujo2 = Venta::DibujarListado($ventas);
echo $dibujo2;



?>