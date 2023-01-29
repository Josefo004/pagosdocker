<?php 
require('security.php');
$data = json_decode($_POST['data'],true);
$fecha = $data['fecha'];
$lug_id = $data['lug_id'];

if(empty($data['fecha'])){
    echo "ERROR, Uno de los campos o los dos estan vacios"; 
}
else{
    $usuario = $_SESSION["usuario"];
    if($data['lug_id']>2){
        $can_entregadas = Entrega::cant_entregadas(Conexion::getInstancia(),$fecha,$lug_id,0); 
        $conteo = Entrega::conteo_entrega(Conexion::getInstancia(),$fecha,$lug_id,0); 
    }
    else{
        $can_entregadas = Entrega::cant_entregadas(Conexion::getInstancia(),$fecha,0,$usuario); 
        $conteo = Entrega::conteo_entrega(Conexion::getInstancia(),$fecha,0,$usuario);
    }
    if(!$can_entregadas){
        echo "SIN RESULTADOS PARA $fecha"; 
    }
    else{
        require('../vistas/cc_evw_reporte_entregas.php');
    }
    unset($can_entregadas); 
    unset($conteo); 
}
Conexion::cerrar();
?>