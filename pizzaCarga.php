<?php
include_once "pizza.php";

if(isset($_GET["sabor"]) && isset($_GET["precio"]) && isset($_GET["tipo"]) && isset($_GET["cantidad"]))
{

    $sabor = $_GET["sabor"];
    $precio = $_GET["precio"];
    $tipo = $_GET["tipo"];
    $cantidad = $_GET["cantidad"];
    
    $pizza = new Pizza();
    $pizza->__construct1($sabor,$precio,$tipo,$cantidad);
    
    if($pizza->GuardarPizza("Pizza.json"))
    {
        echo "Se guardo la pizza";
    }else
    {
        echo 'No se guardo la pizza';
    }
}else
{
    echo 'Complete todos los datos';
}
?>

