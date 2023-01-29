<?php

class Conexion extends PDO {
  // private $puerto = '5432';
  // private $tipo_de_base = 'pgsql';
  // private $host = '192.168.200.61';
  // private $nombre_de_base = 'gadch_bdpagos';
  // private $usuario = 'postgres';
  // private $contrasena = 'p0sTgr35*gadCH.';
  private $puerto = '5432';
  private $tipo_de_base = 'pgsql';
  private $host = '192.168.200.64';
  private $nombre_de_base = 'pagosmigrado';
  private $usuario = 'postgres';
  private $contrasena = 'p0sTgr35*gadCH.';

  private static $instancia = null;

  public function __construct() {
    try {
        self::$instancia = new PDO($this->tipo_de_base . ':host=' . $this->host . ';port=' . $this->puerto . ';dbname=' . $this->nombre_de_base, $this->usuario, $this->contrasena);
    } catch (PDOException $e) {
        echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
        exit;
    }
  }
  public static function getInstancia(){
    if(!self::$instancia){
        new self();
    }
    return self::$instancia;
  }
  public static function cerrar(){
    self::$instancia = null;
  }
}
?>
