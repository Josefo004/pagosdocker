<?php 
require('security.php');
$id_proceso = $_GET['id_proceso'];

$r1 = "";

$eobs = General::exits_observaciones(Conexion::getInstancia(), $id_proceso);
$epro = General::exits_procesos_estados(Conexion::getInstancia(), $id_proceso);
// echo '<pre>'.var_export($eobs,true).'</pre>';
// echo '<pre>'.var_export($epro,true).'</pre>';

if ($eobs) {
  $res = General::delete_observaciones(Conexion::getInstancia(), $id_proceso);
  ($res>0) ? $r1.= "BORADO OBSERVACIONES OK!!</br>" : $r1 .= "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD OBSERVACIONES!!!!!</br>";
}
else{$r1.="NO hay Observaciones para borrar!! </br>";}

if ($epro) {
  $res = General::delete_procesos_estados(Conexion::getInstancia(), $id_proceso);
  ($res>0) ? $r1.= "BORADO ESTADOS DEL PROCESO OK!!</br>" : $r1 .= "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD ESSTADOS!!!!!</br>";
}
else{$r1.="NO hay Estados para borrar!! </br>";}

$res = General::delete_proceso(Conexion::getInstancia(), $id_proceso);
($res>0) ? $r1.= "BORADO PROCESO OK!!</br>" : $r1 .= "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD PROCESO!!!!!</br>";

echo $r1;
Conexion::cerrar();
?>
