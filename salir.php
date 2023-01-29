<?php
session_start();
//aqui se puede registrar la salida de la sesion
session_unset();
session_destroy();
header ("Location: http://".$_SERVER["SERVER_NAME"].":3000");
exit;
?>
