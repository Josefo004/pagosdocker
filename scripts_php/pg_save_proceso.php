<?php 
require('security.php');
$enlace_a_pagos = 'https://pagos.chuquisaca.gob.bo/procesos/pdf2';
//echo $enlace_a_pagos;
$data = json_decode($_POST['data'],true);
foreach ($data as &$valor) {$valor = trim($valor);}
//echo '<pre>'.var_export($data,true).'</pre>';
$np['id'] = $data['id_proceso'];
$np['cite'] = $data['cite'];
$np['fecha_emision'] = $data['fecha_emision'];
$np['nro_preventivo'] = $data['nro_preventivo'];
$np['monto'] = $data['nomto'];
$np['beneficiario_documento'] = $data['ci_bene'];
$np['beneficiario_nombre'] = strtoupper($data['beneficiario']);
$np['referencia'] = strtoupper($data['referencia']);
$np['motivo_id'] = $data['motivo_id'];
$np['dependencia_id'] = $data['dependencia_id'];
//echo '<pre>'.var_export($np,true).'</pre>';
$enlace_a_pagos .= '/'.$np['id'];
//echo $enlace_a_pagos;
$r1 = "ERRRRRRROOOORRRR NO PUEDE EXISTIR CAMPOS VACIOS!!!!!";
if ($np['motivo_id']!='0' && $np['dependencia_id']!='0' && $np['fecha_emision']!='' && $np['cite']!='' && $np['nro_preventivo'] && is_numeric($np['monto'])) {
  $res = General::update_proceso(Conexion::getInstancia(), $np);
  ($res>0) ? $r1 = "EDITAR OK!!</br> <a href='".$enlace_a_pagos."' target='_blank'>CLICK AQUI (hay que estar logeado al sistema de pagos)</a> " : $r1 = "ERRRRRRROOOORRRR INTERNO del SERVIDOR de BD!!!!!";
}
echo $r1;
Conexion::cerrar();
?>
