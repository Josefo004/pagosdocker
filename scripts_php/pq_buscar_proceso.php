<?php 
require('security.php');
$data = json_decode($_POST['data'],true);
foreach ($data as &$valor) {$valor = trim($valor);}
//echo '<pre>'.var_export($data,true).'</pre>';

if ( !empty($data['nro_proceso']) ) {
  $proceso = General::get_proceso_by_no(Conexion::getInstancia(), $data['nro_proceso'], $data['gestion']);
} else {
  $proceso = empty($data['id_proceso'])? false : General::get_proceso(Conexion::getInstancia(), $data['id_proceso']);
}

//echo '<pre>'.var_export($proceso,true).'</pre>';
if ($proceso!==false){
  $motivos = get_pgmotivos(Conexion::getInstancia(),$proceso[0]['id_motivo']);
  //echo '<pre>'.var_export($motivos,true).'</pre>';
  $dependencias = get_dependencias(Conexion::getInstancia(),$proceso[0]['dependencia_id']);
  //echo '<pre>'.var_export($dependencias,true).'</pre>';
  require('../vistas/pq_evw_editProceso.php');
}
Conexion::cerrar();
?>