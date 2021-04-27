<?php
include_once "pizza.php";
include_once "AccesoDatos.php";
class Venta{
    
    public $mail;
    public $sabor;
    public $tipo;
    public $cantidad;
    public $fechaVenta;
    public $numeroPedido;
    public $destino;


    public function __construct()
    {

    }

    public function __construct1($sabor,$mail,$tipo,$cantidad,)
    {
        $this->sabor = $sabor;
        if($tipo == "piedra" || $tipo == "molde")
        {
            $this->tipo = $tipo;
            
        }else
        {   
            $this->tipo = "molde";
        }
        $this->mail = $mail;
        $this->cantidad = $cantidad;
        $this->fechaVenta = date("y-m-d");
        $this->numeroPedido = rand(1,100000);
        $usuario = strstr($this->mail, '@', true);
        $this->destino = "Pizzas/ImagenesDeLaVenta/" . $this->tipo. "+" . $this->sabor ."+". $usuario. "+" . $this->fechaVenta . ".jpg";
        move_uploaded_file($_FILES["foto"]["tmp_name"],$this->destino);
    }

    //FILTROS-----

    public static function DibujarListado($arrayVentas)
    {
        $cadena = "<ul>";
        foreach($arrayVentas as $venta)
        {
            $cadena .= "<li> Mail: ". $venta->mail. " - Numero de Pedido: " . $venta->numeroPedido . " - Tipo: " . $venta->tipo . " - Sabor: " . $venta->sabor . " - Cantidad: " . $venta->cantidad . 
            " - Fecha de Venta: " . $venta->fechaVenta  .  "</li>";
        }
        $cadena .= "</ul>";
     
        return $cadena;
    }

    public static function CantidadVendidaPizza()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select ventas.id as id, SUM(cantidad) as cantidad FROM ventas");
        $consulta->execute();			
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public static function VentaEntreFechas($fecha1,$fecha2)
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select mail as mail,numero_pedido as numeroPedido, tipo as tipo,sabor as sabor,cantidad as cantidad,fecha_venta as fechaVenta from ventas WHERE fecha_venta BETWEEN :fecha1 AND :fecha2 ORDER BY sabor" );
        $consulta->bindValue(':fecha1', $fecha1, PDO::PARAM_STR);
        $consulta->bindValue(':fecha2', $fecha2, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");
	}

    public static function VentasDeUsuario($mail)
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select mail as mail,numero_pedido as numeroPedido, tipo as tipo,sabor as sabor,cantidad as cantidad,fecha_venta as fechaVenta from ventas WHERE mail = :mail" );
        $consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");
	}

    public static function VentasPorSabor($sabor)
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select mail as mail,numero_pedido as numeroPedido, tipo as tipo,sabor as sabor,cantidad as cantidad,fecha_venta as fechaVenta from ventas WHERE sabor = :sabor" );
        $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");
	}

    //FILTROS

    public function RealizarVenta($ruta)
    {
        $retorno = "No se realizo la venta";
        if(Pizza::VerificarPizza($this->sabor,$this->tipo,$this->cantidad,$ruta))
        {
            $retorno = $this->InsertarUsuarioParametros();
            Pizza::DescontarStock($ruta,$this->cantidad,$this->sabor,$this->tipo);
        }
        return $retorno;
    }

    public function InsertarUsuarioParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into ventas(mail,numero_pedido,tipo,sabor,cantidad,fecha_venta)values(:mail,:numero_pedido,:tipo,:sabor,:cantidad,:fecha_venta)");
        $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':numero_pedido', $this->numeroPedido, PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':sabor', $this->sabor, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_venta', $this->fechaVenta, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        return $consulta->execute();
    }

    
}


?>