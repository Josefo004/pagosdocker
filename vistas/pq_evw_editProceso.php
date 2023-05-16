<div class="row">
    <div class="col-md-12">
        <form id="form_formulario" autocomplete="off">
            <div class="card">
                <div class="card-header">PROCESO</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="id_proceso">Id Proceso:</label>
                            <input type="text" class="form-control form-control-sm" id="id_proceso" value="<?php echo $proceso[0]['id_proceso'];?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nro_proceso">Nro Proceso:</label>
                            <input type="text" class="form-control form-control-sm" id="nro_proceso" value="<?php echo $proceso[0]['nro_proceso'];?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cite">Cite:</label>
                            <input type="text" class="form-control form-control-sm" id="cite" onkeyup="this.value=mayusc(this.value)" value="<?php echo $proceso[0]['cite'];?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fecha_emision">Fecha Emisión:</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_emision" value="<?php echo $proceso[0]['fecha_emision'];?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nro_preventivo">Nro. Preventivo:</label>
                            <input type="text" class="form-control form-control-sm" id="nro_preventivo" value="<?php echo $proceso[0]['nro_preventivo'];?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="monto">Monto:</label>
                            <input type="text" class="form-control form-control-sm" id="nomto" value="<?php echo $proceso[0]['monto'];?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="ci_bene">CI Beneficiario:</label>
                            <input type="text" class="form-control form-control-sm" id="ci_bene" value="<?php echo $proceso[0]['ci_beneficiario'];?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="beneficiario">Beneficiario:</label>
                            <input type="text" class="form-control form-control-sm" id="beneficiario" onkeyup="this.value=mayusc(this.value)" value="<?php echo $proceso[0]['beneficiario'];?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="referencia">Referencia</label>
                            <textarea class="form-control form-control-sm" id="referencia" onkeyup="this.value=mayusc(this.value)" rows="2"><?php echo $proceso[0]['referencia'];?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="motivo_id">Motivo:</label>
                        <select class="form-control form-control-sm" id="motivo_id">
                          <?php echo $motivos;?>
                        </select>
                      </div>
                      <div class="form-group col-md-8">
                        <label for="dependencia_id">Dependencia:</label>
                        <select class="form-control form-control-sm" id="dependencia_id">
                          <?php echo $dependencias;?>
                        </select>
                      </div>
                    </div>
                </div>
            </div>
        </form>    
        <div class="form-row">
            <div class="form-group col-md-4">
                <button type="button" class="btn btn-success btn-block" onclick="enviar_formulario('form_formulario','cuerpo2','scripts_php/pg_save_proceso.php')">GUARDAR PROCESO</button>
            </div>
            <div class="form-group col-md-4">
                <button type="button" class="btn btn-success btn-block" onclick="enviar_formulario('form_formulario','cuerpo2','scripts_php/pg_delete_proceso.php')">BORRAR PROCESO</button>
            </div>
            <div class="form-group col-md-4">
                <?php
                $enlace_a_pagos = 'https://pagos.chuquisaca.gob.bo/procesos/pdf2/'.$proceso[0]['id_proceso'];
                echo "<a class='btn btn-success btn-block' href='".$enlace_a_pagos."' target='_blank'>SOLO IMPRIMIR</a>";
                ?>
            </div>
        </div>
    </div>
</div>

