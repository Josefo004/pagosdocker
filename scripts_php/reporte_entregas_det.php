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
    $entregas = false;
    if($data['lug_id']>2){
        $entregas = Entrega::entregas_detalladas(Conexion::getInstancia(),$fecha,$lug_id,0); 
    }
    else{
        $entregas = Entrega::entregas_detalladas(Conexion::getInstancia(),$fecha,0,$usuario);
    }
    if(!$entregas){
        echo "SIN RESULTADOS PARA $fecha"; 
    }
    else{
        require('../vistas/cc_evw_reporte_entregas_det.php');
    }
    unset($entregas);  
}
Conexion::cerrar();
?>