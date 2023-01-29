<?php 
require('security.php');
// $proceso = General::get_proceso(Conexion::getInstancia(), 1);
// Conexion::cerrar();
$version = "v1.0.0";
$nombre_corto = "Editar  Pagos <small>$version</small>";
$tie_msg = "";
$anio = date("Y");
$ges = get_gestiones(Conexion::getInstancia(), $anio);
//echo '<pre>'.var_export($ges,true).'</pre>';
Conexion::cerrar();
?>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
  <span class="navbar-brand"><?php echo "$nombre_corto $tie_msg";?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
    </ul>
  </div>
</nav>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">BUSQUEDA DEL PROCESO</div>
      <div class="card-body">
        <form id="procesoform" autocomplete="off" onsubmit="enviar_formulario('procesoform','cuerpo2','scripts_php/pq_buscar_proceso.php')">
          <div class="form-row">
            <div class="card col-md-2 border-0">
              <div class="form-row p-2">
                <div class="form-group col-md-12">
                  <label for="id_proceso">Id Proceso:</label>
                  <input type="text" class="form-control form-control-sm" id="id_proceso" value="<?php echo $proceso[0]['id_proceso'];?>">
                </div>
              </div>
            </div>
            <div class="card col-md-6 border-0">
              <div class="form-row p-2">
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-4">
                  <label for="nro_proceso">Nro Proceso:</label>
                  <input type="text" class="form-control form-control-sm" id="nro_proceso" value="<?php echo $proceso[0]['nro_proceso'];?>">
                </div>
                <div class="form-group col-md-4">
                  <label for="gestion">Gestión:</label>
                  <select class="form-control form-control-sm" id="gestion">
                    <?php echo $ges;?>
                  </select>
                </div>
              </div>
            </div>
            <div class="card col-md-4 border-0">
              <div class="form-row p-2">
                <div class="form-group col-md-12">
                  <label for="motivo_id">.</label>
                  <button type="submit" class="btn btn-primary btn-sm btn-block">BUSCAR PROCESO</button>
                </div>
              </div>
            </div>
          </div>
        </form>    
        </div>
    </div>
    <br>
    <div id="cuerpo2"></div>
  </div>
</div>

