<?php

//completar ceros
function complete($entrega){
	$re = "";
	$lng = strlen($entrega);
	for ($i = 1; $i <= (6-$lng); $i++) {
	  $re.="0";
	}
	return $re.$entrega;
}

function namedir($ndir){
	$orig = array("Á","É","Í","Ó","Ú","Ñ","ñ");
	$remp = array("A","E","I","O","U","NI","NI");
	$orig2= array("'",'"','-');
	$ndir = str_replace($orig, $remp, $ndir);
	$ndir = str_replace($orig2, "", $ndir);
    $re = str_replace(" ","_",mb_strtolower($ndir));
	$re = trim($re);
    return $re;
}

function crear_directorio($mkdir){
    if (!file_exists($mkdir)) {
        if (mkdir($mkdir, 0755)) {
            echo "$mkdir Directorio CREADO EXITOSAMENTE </br>".PHP_EOL;
        }
        else{
            echo "$mkdir ERROR AL CREAR DIRECTORIO </br>".PHP_EOL;
        }
        
    }
    else{
        echo "$mkdir Directorio ya creado </br>".PHP_EOL;
    }
}

function getAhoraBoliviaTime(){
	date_default_timezone_set('America/La_Paz');
	return time();
}

function getAhoraBolivia(){
	date_default_timezone_set('America/La_Paz');
	return date('d-m-Y H:i:s',time());
}

function getAhora(){
	date_default_timezone_set('America/La_Paz');
	return date('Y-m-d H:i:s',time());
}

function gethoy(){
	date_default_timezone_set('America/La_Paz');
	return date('Y-m-d',time());
}

function format_FH($feho){
	$nfeho = strtotime($feho);
	return date('d-m-Y H:i:s',$nfeho);
}

function format_FH2($feho){
	$nfeho = strtotime($feho);
	return date('d-m-Y',$nfeho);
}

//listar gente de
function listarGentede($conexion,$idpe,&$salida){
	$sql ="SELECT per_id, per_gentede FROM per_persona WHERE per_id = :idpe;";
	$consulta = $conexion->prepare($sql);
	$consulta->bindParam(':idpe', $idpe);
	$consulta->execute();
	$registro = $consulta->fetch();
	$gede = $registro['per_gentede'];
	if($gede!=-1){
		array_push($salida,$gede);
		listarGentede($conexion,$gede,$salida);
	}
}

//verificar si una persona tiene 
function buscar_gd($conexion,$idpe){
	$sql ="SELECT per_id, per_gentede FROM per_persona WHERE per_gentede = :idpe;";
	$consulta = $conexion->prepare($sql);
	$consulta->bindParam(':idpe', $idpe);
	$consulta->execute();
	$registros = $consulta->fetchAll();
	if (!empty($registros)){
        return 1;
    }
    else{
        return 0;
    }
}

//listar gente de con PDF
function listarGentedePDF($conexion,$idpe,&$salida){
	$xaux = array('per_id'=>$idpe,'jefe'=>'SI');
	array_push($salida,$xaux);
	$sql ="SELECT per_id, per_gentede FROM per_persona WHERE per_gentede = :idpe ORDER BY per_id, per_apellidop, per_apellidom, per_nombre;";
	$consulta = $conexion->prepare($sql);
	$consulta->bindParam(':idpe', $idpe);
	$consulta->execute();
	$registros = $consulta->fetchAll();
	foreach ($registros as &$valor) {
		$hay_gd = buscar_gd($conexion,$valor['per_id']); //hay gente de??
		if ($hay_gd==1) {
			listarGentedePDF($conexion,$valor['per_id'],$salida);
		}
		else{
			$xaux = array('per_id'=>$valor['per_id'],'jefe'=>'NO'); array_push($salida,$xaux);
		}
	}
}

//listar mostrar gente de en una lista ordenada
function listar($ppp,$cx){
    $re = "";
    if (count($ppp)>1) {
        $re = "<ol>";
        foreach ($ppp as &$valor) {
            $per = Persona::buscarPorId($cx,$valor);
            $m02 = $per->getNombreC();
            $re.="<li>".$m02."</li>";
        }
        $re.="</ol>";
    }
    return $re;
}

//calcular la edad 
function getEdad($fechanacimiento){
	date_default_timezone_set('America/La_Paz');
	$fena = strtotime($fechanacimiento);
	$hoy = time();
	$anios = (($hoy-$fena)/86400)/365;
	return intval($anios);
  }

//mostrar usuario (sacar en una sola cadena concatenada usuario, nombre y apellidop)
function showUsuario($conexion,$usua){
	$sql ="SELECT concat(usu.niv_id,'*',per.per_nombre, ' ', per.per_apellidop, ' ', per.per_apellidom,' - ',usu.usu_usuario, ' ') as nombre FROM usu_usuario usu JOIN per_persona per ON usu.per_id=per.per_id WHERE usu_usuario=:usua;";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':usua', $usua);
    $consulta->execute();
    $registro = $consulta->fetch();
    return $registro['nombre'];
}

//devolver departamentos
function get_departamento($conexion, $dep_id){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM dep_departamento";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$departamentos = $consulta->fetchAll();
	foreach ($departamentos as &$valor) {
		if ($valor['dep_id']==$dep_id){
			$re.="<option value='".$valor['dep_id']."' selected>".$valor['dep_descripcion']."</option>";
		}
		else{
			$re.="<option value='".$valor['dep_id']."'>".$valor['dep_descripcion']."</option>";
		}
	}
	return $re;
}

//devolver distrtos
function get_distritos($conexion, $dis_id){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM dis_distrito";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$distritos = $consulta->fetchAll();
	foreach ($distritos as &$valor) {
		if ($valor['dis_id']==$dis_id){
			$re.="<option value='".$valor['dis_id']."' selected>".$valor['dis_descripcion']."</option>";
		}
		else{
			$re.="<option value='".$valor['dis_id']."'>".$valor['dis_descripcion']."</option>";
		}
	}
	return $re;
}

//devolver genero
function get_genero($conexion, $geid){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM gen_genero";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$genero = $consulta->fetchAll();
	foreach ($genero as &$valor) {
		if ($valor['gen_id']==$geid){
			$re.="<option value='".$valor['gen_id']."' selected>".$valor['gen_descripcion']."</option>";
		}
		else{
			$re.="<option value='".$valor['gen_id']."'>".$valor['gen_descripcion']."</option>";
		}
	}
	return $re;
}

//devolver tipo de formulario
function get_tipoform($conexion, $tif_id){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM tif_tipoformulario";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$genero = $consulta->fetchAll();
	foreach ($genero as &$valor) {
		if ($valor['tif_id']==$tif_id){
			$re.="<option value='".$valor['tif_id']."' selected>".$valor['tif_descripcion']."</option>";
		}
		else{
			$re.="<option value='".$valor['tif_id']."'>".$valor['tif_descripcion']."</option>";
		}
	}
	return $re;
}

//devolver tipo de formulario
function get_gestiones($conexion, $anioa){
	$re = "";
	$sql ="SELECT EXTRACT(YEAR FROM fecha_emision) as anio FROM pag_procesos
	GROUP BY EXTRACT(YEAR FROM fecha_emision);";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$anios = $consulta->fetchAll();
	foreach ($anios as $valor) {
		if ($valor['anio']==$anioa){
			$re.="<option value='".$valor['anio']."' selected>".$valor['anio']."</option>";
		}
		else{
			$re.="<option value='".$valor['anio']."'>".$valor['anio']."</option>";
		}
	}
	return $re;
}

//devolver niveles de usuario menor al nivel de usuario actual
function get_nivel($conexion, $nivselec, $niv_usu){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM niv_nivel WHERE niv_id > :niv_id ORDER BY niv_id";
	$consulta = $conexion->prepare($sql);
    $consulta->bindParam(':niv_id', $niv_usu);
	$consulta->execute();
	$niveles = $consulta->fetchAll();
	foreach ($niveles as &$valor) {
		if ($valor['niv_id']==$nivselec){
			$re.="<option value='".$valor['niv_id']."' selected>".$valor['niv_descripcion']."</option>";
		}
		else{
			$re.="<option value='".$valor['niv_id']."'>".$valor['niv_descripcion']."</option>";
		}
	}
	return $re;
}

/* x1=per_identificacion x2=per_fecha_nacimiento x3=per_nombre x4=per_telefono  */
function no_nulos_per($x3){
    if (empty($x3)) {exit("Campo Nombre Persona Vacio");}
}

/* x1=per_identificacion x2=per_fecha_nacimiento x3=per_nombre x4=per_telefono  */
function no_nulos_dirigente($x1,$x2,$x3){
    if (empty($x1)) {exit("Campo Nombre Persona Vacio");}
	if (empty($x2)) {exit("Campo Telefono  Vacio");}
	if (empty($x3)) {exit("NO Se escogio un Barrio Correctamente");}
}

function no_nulos_formulario($x1,$x2,$x3,$x4,$x5){
	$msg1 = "";
	if (empty($x1)){$msg1="ERROR! Campo Tipo de Formulario Vacio";}
	else if (empty($x2)){$msg1="ERROR! Campo Nombre Persona Vacio";}
	else if (!empty($x3)) {$msg1="ERROR! El Numero de Formulario YA EXISTE";}
	else if (empty($x4)) {$msg1="ERROR! Campo Cedula de Identidad Vacio";}
	else if ($x5=="0"||$x5=="") {$msg1="ERROR! Formulario sin Datos de Identificación Geografica y de Representación";}
	if($msg1!=""){echo "<h2>$msg1<h2>"; exit();}
}

//genera un usuario con las primeras letras de su nombre y 
function generar_user($xno, $xap, $xam){
	$re = "";
	$orig = array("Á","É","Í","Ó","Ú","Ñ","ñ");
	$remp = array("A","E","I","O","U","NI","NI");
	$nxap = str_replace(" ", "", $xap);
	$nxap = str_replace($orig, $remp, $nxap);
	if(strlen($nxap)==0){$nxap=$xam;}
	$hoy = time();
	$hr_act = date('z:i',$hoy);
	list($di,$mi) = explode(":",$hr_act);
	$re = $xno[0].".".$nxap.".".$di.$mi;
	return $re;
}

//Obtener los valores guardados en el formulario 
function get_datosg($conexion, $ref_id){
	if(!empty($ref_id)){
		$sql = "SELECT * FROM daf_datosform daf	WHERE daf.ref_id=$ref_id AND daf.daf_borrado='N' ORDER BY daf.tid_id";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
		$registros = $consulta->fetchAll();
		if ($registros) {
			return $registros;
		} else {
			return false;
		};
	}
	else{
		return false;
	}
}

//obtener tipos de datos en los formularios
function get_datosf($conexion, $tip_id){
	$sql = "SELECT tid.tid_descripcion as titulo, dat.* 
	FROM dat_datos dat, tid_tipodato tid	
	WHERE dat.tid_id=tid.tid_id AND
		  dat.tid_id = $tip_id";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$arr = $consulta->errorInfo();
	if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
	$registros = $consulta->fetchAll();
	if ($registros) {
		return $registros;
	} else {
		return false;
	};
}

function ver_arreglo($dat_id, $arreglo, &$x1, &$x2){
	if($arreglo!=false){
		foreach ($arreglo as $valor){
			if($dat_id==$valor['dat_id']){
				$x1 = $valor['daf_id'];
				$x2 = $valor['daf_valor'];
			break;
			}
		}
	}
}

//datosf = datos del formulario guardados 
//datos = datos del formulario a llenar
function formulario($datosf, $datosg, $tipo_f, $aux=0){
	$titulo = $datosf[0]['titulo'];
	$cad1 = "<div class='card'>
				<div class='card-header'>$titulo</div>
				<div class='card-body'>
					<div class='form-row'>
						<div class='form-group col-md-12'>";
	$cad3 = "			</div>
					</div>  
				</div>
			  </div>";
	$cad2 = "";

	$temporal="";
	foreach ($datosf as $valor) {
		$ID = $valor['dat_id'];
		$ID2 = $valor['tid_id'];
		$id_daf = "0";
		$va_daf = "0";
		ver_arreglo($ID, $datosg, $id_daf, $va_daf);
		$IDD = $ID2."_".$ID."_".$id_daf;
		$dat_tipdescripcion=$valor['dat_tipdescripcion'];
		if($tipo_f==1){
			if (($ID==71)&&($va_daf!="0")) {
				if(strpos($va_daf,"_")===false){} 
				else{
					list($a1,$a2)=explode("_",$va_daf);
					$va_daf = $a1;
					$temporal=$a2;
				}
			} //otrobono
			$cad2.="<div class='row'>
						<div class='col-md-10'>
							<label for='ref_fecha'>$dat_tipdescripcion</label>
						</div>
						<div class='col-md-2'>
							<input type='text' class='form-control form-control-sm' id='dat_$IDD' onkeypress='return solonumeros(event)' value='$va_daf' maxlength='2' size='3'>
						</div>
					</div>";
		}
		else{
			if($va_daf!="0"){
				$ch="checked";
				if (($ID==19)&&($va_daf!="1")) {$temporal=$va_daf;} //si tiene una enfermendad grave
				if (($ID>=46&&$ID<=49)&&(($va_daf!="1"))) {$temporal=$va_daf;} //cuanto de saario percibe
				if (($ID==70)&&($va_daf!="1")) {$temporal=$va_daf;} //otrobono
			} else{$ch="";}
			$cad2.="<div class='form-check'>
						<input type='checkbox' id='dat_$IDD' $ch>
						<label class='form-check-label' for='dat_$IDD'>$dat_tipdescripcion</label>
					</div>";
		}	
	}
	switch ($aux) {
		case 1:
			$cad2.="<label for='enfermedad'>Cual Enfermedad:</label>
					<input type='text' class='form-control form-control-sm' id='enfermedad' onkeyup='this.value=mayusc(this.value)' value='$temporal'>";
			break;
		case 2:
			$cad2.="<label for='salario'>Cantidad Mensual Familiar:</label>
					<input type='text' class='form-control form-control-sm' id='salario' onkeypress='return solonumeros(event)' value='$temporal'>";
			break;
		case 3:
			$cad2.="<label for='atencion'>Atención Requerida:</label>
					<input type='text' class='form-control form-control-sm' id='atencion' onkeyup='this.value=mayusc(this.value)' value='$temporal'>";
			break;
		case 4:
			$cad2.="<label for='obono'>Descripcion Otro Bono:</label>
					<input type='text' class='form-control form-control-sm' id='obono' value='$temporal'>";
			break;
	}
	if($aux==1){
		
	}
	else{
		$cad2.="";
	}
	return $cad1.$cad2.$cad3;
}

////////////////////////////////////////////////////////////////////
function menu2($me2){
	$re="";
	//echo '<pre>'.var_export($me2,true).'</pre>';
	foreach ($me2 as &$valor) {
		//echo $valor[1];
		if (is_array($valor)){
			$re.="<a class='dropdown-item' onclick=\"loadDoc('cuerpo2','$valor[1]','1')\" href='#'>$valor[0]</a>";
		}
		else{$re.="<div class='dropdown-divider'></div>";}//division en el menu
	}
	return $re;
}

function menu1($menu){
	$re="";
	//echo '<pre>'.var_export($menu,true).'</pre>';
	foreach ($menu as &$valor) {
		if(is_array($valor[1])){
		    $re.="<li class='nav-item dropdown'>
					<a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' id='download'>$valor[0] <span class='caret'></span></a>
					<div class='dropdown-menu' aria-labelledby='download'>".menu2($valor[1])."</div>
          		 </li>";			
		}
		else{
			$re.="<li class='nav-item'><a class='nav-link' onclick=\"loadDoc('cuerpo2','$valor[1]','1')\" href='#'>$valor[0]</a></li>";
		}
	} 
	return $re;
}

function menu0($niv_id){	
	$dir1 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cambiar_pwd.html";// cambiar_password 
	$dir2 = "https://".$_SERVER["SERVER_NAME"]."/familia/401.html"; // salir del sistema 
	$dir3 = "https://".$_SERVER["SERVER_NAME"]."/familia/scripts_php/cc_adm_users.php";// cambiar_password 
	$dir4 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_evw_find_persona.php?para=P";// cambiar_password 
	$dir5 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/add_to_cronograma.php";// 
	$dir6 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_evw_find_Barrio.php";// buscar Barrio
	$dir7 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_evw_find_Dirigente.php";// Buscar Dirigente
	$dir8 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_evw_find_formulario.php";// 
	$dir9 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_find_bydate.php?para=US";// 
	$dir10 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_find_bydate.php?para=TD";// 
	$dir11 = "https://".$_SERVER["SERVER_NAME"]."/familia/scripts_php/cc_total_tipo.php";// cambiar_password 
	$dir12 = "https://".$_SERVER["SERVER_NAME"]."/familia/scripts_php/cc_total_distrito.php";
	$dir13 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_entrega.php"; 
	$dir15 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_entregas.php?rep=1";//
	$dir16 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_entregas.php?rep=2";//
	$dir17 = "https://".$_SERVER["SERVER_NAME"]."/familia/scripts_php/cc_lugares.php";// 
	$dir18 = "https://".$_SERVER["SERVER_NAME"]."/familia/scripts_php/cc_cronograma.php";// 
	$dir19 = "https://".$_SERVER["SERVER_NAME"]."/familia/scripts_php/cc_totalpascar.php";// 
	$dir20 = "https://".$_SERVER["SERVER_NAME"]."/familia/vistas/cc_generar_pdf_entregas.php";//
	$menuA=[];
	switch ($niv_id) {
		case 1:
			$administracion = array(array('Cambiar Contraseña',$dir1),
									array('Administrar Usuarios',$dir3),
									array('Salir del Sistema',$dir2));
			$personas = array(array('Editar o Registrar Una persona',$dir4));	
			$formulario = array(array('Buscar o Registrar un Formulario',$dir8),'ddd',
								array('Formularios por Fechas',$dir10),'ddd',
								array('Solo Entrega Pascar',$dir19),'ddd',
							    array('PDF ENTREGA POR LUGAR',$dir20));
			$barrio_dirigiente = array(array('Buscar ó Registrar Un Barrio',$dir6),'ddd',
									   array('Buscar o Registrar Un Dirigente',$dir7));
			$reportes = array(array('Formularios Por Tipo',$dir11),
							  array('Formularios Por Distrito',$dir12));
			$luga_prog = array(array('Lugares de Entrega',$dir17),
							   array('Generar un Cronograma',$dir18),
							   array('Programar Formularios',$dir5));
			$entrega = array(array('Entrega de Canasta',$dir13),'ddd',
							 array('Mis Entregas',$dir15),
							 array('Entregas del Lugar',$dir16));
			$menuA = array(array('Administración',$administracion),	
			               array('Formularios',$formulario),
			               array('Barrios, Dirigentes',$barrio_dirigiente),
						   array('Personas',$personas),
						   array('Reportes',$reportes),
						   array('Lugares y Cronograma',$luga_prog),
						   array('Entrega',$entrega));
			break;
		case 2:
			$administracion = array(array('Cambiar Contraseña',$dir1),
									array('Administrar Usuarios',$dir3),
									array('Salir del Sistema',$dir2));	
			$formulario = array(array('Buscar o Registrar un Formulario',$dir8),'ddd',
								array('Formularios por Fechas',$dir10),'ddd',
							    array('Solo Entrega Pascar',$dir19));
			$barrio_dirigiente = array(array('Buscar ó Registrar Un Barrio',$dir6),'ddd',
									   array('Buscar o Registrar Un Dirigente',$dir7));
			$reportes = array(array('Formularios Por Tipo',$dir11),
							  array('Formularios Por Distrito',$dir12));
			$luga_prog = array(array('Lugares de Entrega',$dir17),
							   array('Generar un Cronograma',$dir18),
							   array('Programar Formularios',$dir5));
			$entrega = array(array('Entrega de Canasta',$dir13),'ddd',
							 array('Mis Entregas',$dir15),
							 array('Entregas del Lugar',$dir16));
			$menuA = array(array('Administración',$administracion),	
			               array('Formularios',$formulario),
			               array('Barrios, Dirigentes',$barrio_dirigiente),
						   array('Reportes',$reportes),
						   array('Lugares y Cronograma',$luga_prog),
						   array('Entrega',$entrega));
			break;
		case 3:
			$administracion = array(array('Cambiar Contraseña',$dir1),
									array('Salir del Sistema',$dir2));
		
			$formulario = array(array('Buscar o Registrar un Formulario',$dir8),'ddd',
								array('Formularios por Fechas',$dir10),'ddd',
							    array('Solo Entrega Pascar',$dir19));
			$barrio_dirigiente = array(array('Buscar ó Registrar Un Barrio',$dir6),'ddd',
										array('Buscar o Registrar Un Dirigente',$dir7));
			$reportes = array(array('Formularios Por Tipo',$dir11),
							  array('Formularios Por Distrito',$dir12));
			$menuA = array(array('Administración',$administracion),	
							array('Formularios',$formulario),
							array('Barrios, Dirigentes',$barrio_dirigiente),
						    array('Reportes',$reportes));
			break;
		case 4:
			$administracion = array(array('Cambiar Contraseña',$dir1),
									array('Salir del Sistema',$dir2));
			$reportes = array(array('Formularios Por Tipo',$dir11),
							  array('Formularios Por Distrito',$dir12));
			$menuA = array(array('Administración',$administracion),	
						   array('Reportes',$reportes));
			break;
		case 5:
			$administracion = array(array('Cambiar Contraseña',$dir1),
									array('Salir del Sistema',$dir2));
			$entrega = array(array('Entrega de Canasta',$dir13),'ddd',
							 array('Mis Entregas',$dir15),
							 array('Entregas del Lugar',$dir16));
			$menuA = array(array('Administración',$administracion),	
						   array('Entrega',$entrega));
			break;
	}
	return menu1($menuA);
}

//devolver motivos
function get_pgmotivos($conexion, $id_motivo){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM pag_motivos";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$motivos = $consulta->fetchAll();
	foreach ($motivos as &$valor) {
		if ($valor['id']==$id_motivo){
			$re.="<option value='".$valor['id']."' selected>".$valor['nombre']."</option>";
		}
		else{
			$re.="<option value='".$valor['id']."'>".$valor['nombre']."</option>";
		}
	}
	return $re;
}

//devolver dependencias
function get_dependencias($conexion, $id_dependencia){
	$re = "<option value='0'></option>";
	$sql ="SELECT * FROM per_dependencias";
	$consulta = $conexion->prepare($sql);
	$consulta->execute();
	$dependencias = $consulta->fetchAll();
	foreach ($dependencias as &$valor) {
		if ($valor['id']==$id_dependencia){
			$re.="<option value='".$valor['id']."' selected>".$valor['nombre']."</option>";
		}
		else{
			$re.="<option value='".$valor['id']."'>".$valor['nombre']."</option>";
		}
	}
	return $re;
}

?>