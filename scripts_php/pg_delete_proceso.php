<?php 
require('security.php');
//$enlace_a_pagos = 'https://pagos.chuquisaca.gob.bo/procesos/pdf2';
//echo $enlace_a_pagos;
$data = json_decode($_POST['data'],true);
foreach ($data as &$valor) {$valor = trim($valor);}
//echo '<pre>'.var_export($data,true).'</pre>';
$data['id_proceso'];
$r1 = "";
$res = General::delete_observaciones(Conexion::getInstancia(), $data['id_proceso']);
($res>0) ? $r1.= "BORADO OBSERVACIONES OK!!</br>" : $r1 .= "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD OBSERVACIONES!!!!!</br>";

$res = General::delete_procesos_estados(Conexion::getInstancia(), $data['id_proceso']);
($res>0) ? $r1.= "BORADO ESTADOS DEL PROCESO OK!!</br>" : $r1 .= "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD ESSTADOS!!!!!</br>";

$res = General::delete_proceso(Conexion::getInstancia(), $data['id_proceso']);
($res>0) ? $r1.= "BORADO PROCESO OK!!</br>" : $r1 .= "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD PROCESO!!!!!</br>";

echo $r1;
Conexion::cerrar();
?>
