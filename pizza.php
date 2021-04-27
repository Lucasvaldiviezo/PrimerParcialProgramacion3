<?php

class Pizza{

    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;
    

    public function __construct()
    {

    }

    public function __construct1($sabor,$precio,$tipo,$cantidad,)
    {
        $this->id = rand(1,10000);
        $this->sabor = $sabor;
        if($tipo == "piedra" || $tipo == "molde")
        {
            $this->tipo = $tipo;
            
        }else
        {   
            $this->tipo = "molde";
        }
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    public function GuardarPizza($ruta)
    {
        $arrayPizzas = self::LeerJSON($ruta);
        $flag = 0;
        $retorno = false;
        foreach($arrayPizzas as $pizza)
        {
            if($pizza->tipo == $this->tipo && $pizza->sabor == $this->sabor)
            {
                $retorno = $this->Actualizar($ruta,"+");
                $flag = 1;
                break;
            }
        }
        if($flag == 0)
        {
            $retorno = $this->GuardarJSON($ruta);
        }
        
        return $retorno;

    }

    public function Actualizar($ruta)
    {
        $bool = "false";
        $arrayPizzas = self::LeerJSON($ruta);
        if(isset($arrayPizzas))
        {
        
            foreach($arrayPizzas as $pizza)
            {
                
                if($this->sabor == $pizza->sabor && $pizza->tipo == $this->tipo)
                {
                        $pizza->cantidad = $pizza->cantidad + $this->cantidad;
                        $pizza->cantidad = (string)$pizza->cantidad;
                        $pizza->precio = $this->precio;
                        break;
                }
            }
            
            $bool = $this->SobreEscribirArchivo($ruta,$arrayPizzas);
        }

        return $bool;
    }

    public static function DescontarStock($ruta,$cantidad,$sabor,$tipo)
    {
        $bool = "false";
        $auxPizza = new Pizza();
        $arrayPizzas = self::LeerJSON($ruta);
        if(isset($arrayPizzas))
        {

            foreach($arrayPizzas as $pizza)
            {
                
                if($sabor == $pizza->sabor && $pizza->tipo == $tipo)
                {
                        $pizza->cantidad = $pizza->cantidad - $cantidad;
                        $pizza->cantidad = (string)$pizza->cantidad;
                        $auxPizza->__construct1($pizza->sabor,$pizza->precio,$pizza->tipo,$pizza->cantidad);
                        break;
                }
            }
        }
        $bool = $auxPizza->SobreEscribirArchivo($ruta,$arrayPizzas);
        return $bool;
           
    }
    public function SobreEscribirArchivo($ruta,$array)
    {
        $archivo = fopen($ruta,"w");
        $bool = "false";
        $bool = fwrite($archivo,$this->ArrayPizzaToJson($array));
        fclose($archivo);
        return $bool;
    }

    public static function VerificarPizza($sabor,$tipo,$cantidad,$ruta)
    {
        $retorno = false;
        $arrayPizzas = Pizza::LeerJSON($ruta);
        if(isset($arrayPizzas))
        {
            foreach($arrayPizzas as $pizza)
            {
                if($pizza->sabor == $sabor && $pizza->tipo == $tipo && $pizza->cantidad >= $cantidad)
                {
                    $retorno = true;
                    break;
                }
            }
        }
        return $retorno;
    }


    //FUNCIONES JSON----------------------------------------------------------------------------------------------

    public function GuardarJSON($ruta)
    {
        $archivo = fopen($ruta,"a");
        $bool = fwrite($archivo, Pizza::PizzaToJSON($this));
        fclose($archivo);
        return $bool;
    }

    public function ArrayPizzaToJson($arrayPizzas)
    {
        $cadena = "";
        foreach($arrayPizzas as $pizza)
        {
            $cadena .=  Pizza::PizzaToJSON($pizza);
        }

        return $cadena;
    }

    public static function PizzaToJSON($pizza)
    {
        $cadena =  json_encode($pizza) . "\n";
        return $cadena;
    }

    public static function LeerJSON($ruta)
    {
        $archivo = fopen($ruta,"r");
        $arrayPizzas = [];
        while(!feof($archivo))
        {
            $linea = json_decode(fgets($archivo));
            if(!empty($linea))
            {
                array_push($arrayPizzas,$linea);
            }                
        }
        fclose($archivo);
        return $arrayPizzas;
    }
}

?>