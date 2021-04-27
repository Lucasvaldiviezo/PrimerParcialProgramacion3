<?php
include_once "pizza.php";


    $sabor = $_POST["sabor"];
    $tipo = $_POST["tipo"];
    
    if(Pizza::VerificarPizza($sabor,$tipo,"Pizza.json"))
    {
        echo "Si Hay";
    }else
    {
        echo 'No hay';
    }
    

?>