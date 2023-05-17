<?php

require_once 'clase.Conex.php';

class General {
	
	//obtener lugares de entrega
	public static function get_lugares($conexion) {
		$sql = "SELECT * FROM lug_lugar lug WHERE lug.lug_borrado='N' AND lug.lug_id>2;";
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
    
    public static function borrar_lugar($conexion, $luid, $usu) {
        $re = 0;
		$sql = "UPDATE lug_lugar lug SET lug.lug_borrado='S', lug.last_edited_user='$usu', lug.last_edited_date=now() WHERE lug.lug_id=$luid;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
        if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
        $re = $consulta->rowCount();
        return $re;
    }
    
    public static function insertar_lugar($conexion, $lude, $usu) {
		$sql = "INSERT INTO lug_lugar (lug_descripcion,created_user,created_date,last_edited_user,last_edited_date) VALUES ('$lude','$usu',now(),'$usu',now());";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
    }
    
    public static function get_cronogramas($conexion, $usu) {
		$sql = "SELECT cro.cro_id, lug.lug_descripcion as lugar, DATE_FORMAT(cro.cro_fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(cro.cro_fecha_fin, '%d-%m-%Y') as fecha_fin, cro.created_user  
        FROM cro_cronograma cro 
        JOIN lug_lugar lug ON lug.lug_id = cro.lug_id
        WHERE cro.cro_borrado='N' AND 
              cro.created_user='$usu' AND
			  lug.lug_borrado = 'N' AND
              lug.lug_id > 2
        ORDER BY cro.cro_id DESC";
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

    public static function borrar_cronograma($conexion, $crid, $usu) {
		$re = 0; $crid = trim($crid);
		if(!empty($crid)){
			$sql = "UPDATE cro_cronograma cro SET cro.cro_borrado='S', cro.last_edited_user='$usu', cro.last_edited_date=now() WHERE cro.cro_id=$crid;";
			$consulta = $conexion->prepare($sql);
			$consulta->execute();
			$arr = $consulta->errorInfo();
			if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
			$re = $consulta->rowCount();
		}
        return $re;
    }

    public static function borrar_programaciones($conexion, $crid) {
		$re = 0; $crid = trim($crid);
		if(!empty($crid)){
			$sql = "UPDATE ref_regformulario ref set ref.cro_id=1 WHERE ref.cro_id=$crid AND ref.ent_id=0;";
			$consulta = $conexion->prepare($sql);
			$consulta->execute();
			$arr = $consulta->errorInfo();
			if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
			$re = $consulta->rowCount();
		}
        return $re;
    }

    public static function insertar_cronograma($conexion, $luid, $f1, $f2, $usu, $teid) {
		$sql = "INSERT INTO cro_cronograma (lug_id, cro_fecha_inicio, cro_fecha_fin, tie_id, created_user, created_date, last_edited_user, last_edited_date) VALUES ($luid,'$f1','$f2','$teid','$usu',now(),'$usu',now());";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
	}
	
	public static function get_cronogramas_by_lugar($conexion, $usu, $ludes) {
		$sql = "SELECT cro.cro_id, lug.lug_descripcion as lugar, DATE_FORMAT(cro.cro_fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(cro.cro_fecha_fin, '%d-%m-%Y') as fecha_fin, cro.created_user  
        FROM cro_cronograma cro 
        JOIN lug_lugar lug ON lug.lug_id = cro.lug_id
        WHERE cro.cro_borrado='N' AND 
              cro.created_user='$usu' AND
			  lug.lug_borrado = 'N' AND
              lug.lug_id > 2 AND
      		  lug.lug_descripcion LIKE '%$ludes%' 
        ORDER BY cro.cro_id DESC";
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

	public static function get_cronograma_by_ID($conexion, $crid) {
		$sql = "SELECT cro.cro_id, lug.lug_descripcion as lugar, DATE_FORMAT(cro.cro_fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(cro.cro_fecha_fin, '%d-%m-%Y') as fecha_fin 
        FROM cro_cronograma cro 
        JOIN lug_lugar lug ON lug.lug_id = cro.lug_id
        WHERE cro.cro_borrado='N' AND 
			  lug.lug_borrado = 'N' AND
              lug.lug_id > 2 AND
      		  cro.cro_id = $crid ";
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
	
	//devulve ides por ides o por id de barrio siempre y cuando no hayan sido programados ni entregados, el ultimo campo indica el tipo de entrega
	public static function get_IDS($conexion, $ids, $por, $teid) {
		if ($por==1){$au=" AND ref.ref_id IN ($ids) ";}
		elseif ($por==2){$au=" AND ref.dir_id IN ($ids) ";}
		$sql = "SELECT ref.ref_id as ID
		FROM tif_tipoformulario tif, per_persona per, ref_regformulario ref
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar ON dir.bar_id = bar.bar_id 
		JOIN dis_distrito dis ON bar.dis_id = dis.dis_id
		WHERE ref.tif_id = tif.tif_id AND
			  ref.per_id = per.per_id AND
			  ref.ref_borrado = 'N' AND
			  ref.ref_repetido = 0 AND
			  ref.tif_id = 1 AND
              ref.tie_id = $teid and
			  ref.ref_earchivos = 'S' AND
			  per.per_identificacion<>'' AND
			  ref.ent_id = 0 AND 
			  ref.cro_id = 1 
			  $au 
		ORDER BY ID";
		//echo "<hr>".$sql."<hr>";
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

	//devulve ides por por ultimo digito del ci y por distrito
	public static function get_IDS_dig($conexion, $dig, $dis, $teid) {
		$sql = "SELECT ref.ref_id as ID
		FROM tif_tipoformulario tif, per_persona per, ref_regformulario ref
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar ON dir.bar_id = bar.bar_id 
		JOIN dis_distrito dis ON bar.dis_id = dis.dis_id
		WHERE ref.tif_id = tif.tif_id AND
			  ref.per_id = per.per_id AND
			  ref.ref_borrado = 'N' AND
			  ref.ref_repetido = 0 AND
			  ref.tif_id = 1 AND
			  ref.tie_id = $teid and
			  ref.ref_earchivos = 'S' AND
			  per.per_identificacion<>'' AND
			  dis.dis_id = $dis AND
			  ref.ent_id = 0 AND 
			  ref.cro_id = 1 AND
			  RIGHT(per.per_identificacion,1) = '$dig'
		ORDER BY ID";
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

	//devulve los nombres de las personas de una determinada programción
	public static function get_lista($conexion, $crid) {
		$sql = "SELECT ref.ref_id as ID, per.per_identificacion as CI, per.per_apellidop as paterno, per.per_apellidom as materno, per.per_nombre as nombres 
		FROM  per_persona per, ref_regformulario ref
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar ON dir.bar_id = bar.bar_id 
		JOIN dis_distrito dis ON bar.dis_id = dis.dis_id
		WHERE ref.per_id = per.per_id AND
			  ref.ref_borrado = 'N' AND
			  ref.ref_repetido = 0 AND
			  ref.tif_id = 1 AND
			  per.per_identificacion<>'' AND
			  ref.cro_id = $crid 
		ORDER BY ID";
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

	public static function programaciones($conexion, $crid, $list) {
		$ids = "";  $re = 0;
		foreach ($list as $valor) {
			$ids.=$valor['ID'].", ";
		}
		$ids = substr($ids,0,-2);
		$sql = "UPDATE ref_regformulario ref set ref.cro_id=$crid WHERE ref.ref_id IN ($ids);";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
        if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
        $re = $consulta->rowCount();
        return $re;
    }

	public static function tiene_archivos($conexion, $reid) {
		$sql = "SELECT ref.ref_id, ref.ref_earchivos FROM ref_regformulario ref 
		JOIN att_formulario att ON att.ref_id = ref.ref_id
		WHERE ref.ref_id = $reid AND
			  att.att_borrado = 'N' LIMIT 1";
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

	public static function update_tiene_fotos($conexion, $reid, $vx) {
		$sql = "UPDATE ref_regformulario ref SET ref.ref_earchivos='$vx' WHERE ref.ref_id=$reid;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
        if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
	}
	
	public static function get_tipoentrega($conexion) {
		$sql = "SELECT * FROM tie_tipoentrega;";
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

	public static function totales_groupby_lugarfecha($conexion,$luid,$teid) {
		$sql = "SELECT lug.lug_id, lug.lug_descripcion as lugar, date_format(ent.created_date,'%d-%m-%Y') as fecha, date_format(ent.created_date,'%Y-%m-%d') as fecha2, COUNT(*) as total, ent.tie_id, tie.tie_descripcion as tipo_entrega    
		FROM tie_tipoentrega tie, per_persona per, lug_lugar lug, ent_entrega ent 
		JOIN ref_regformulario ref ON ent.ref_id = ref.ref_id
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar on dir.bar_id =  bar.bar_id
		JOIN dis_distrito dis on bar.dis_id =  dis.dis_id 
		WHERE ent.ent_borrado = 'N' AND
			  per.per_id = ref.per_id AND 
			  ent.lug_id = lug.lug_id AND
			  ent.tie_id = tie.tie_id AND
			  lug.lug_id = $luid AND
			  ent.tie_id = $teid 
		GROUP BY lugar, fecha 
		ORDER BY ent.created_date;";
		//echo $sql;
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

	public static function entregas_detallada_by_fecha($conexion, $luid, $teid, $fecha ) {
		$sql = "SELECT ref.ref_id as ID_frm, ent.ent_id as ID_ent, lug.lug_descripcion as lugar, per.per_identificacion as CI, concat(per.per_apellidop,' ',per.per_apellidom,' ',per.per_nombre) as nombrec, dis.dis_descripcion as distrito, bar.bar_descripcion as barrio_comunidad, ent.created_user as quien, date_format(ent.created_date,'%d-%m-%Y %H:%i:%s') as cuando, tie.tie_descripcion as tipo_entrega    
		FROM tie_tipoentrega tie, per_persona per, lug_lugar lug, ent_entrega ent 
		JOIN ref_regformulario ref ON ent.ref_id = ref.ref_id
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar on dir.bar_id =  bar.bar_id
		JOIN dis_distrito dis on bar.dis_id =  dis.dis_id 
		WHERE ent.ent_borrado = 'N' AND
			  per.per_id = ref.per_id AND 
			  ent.lug_id = lug.lug_id AND
			  ent.tie_id = tie.tie_id AND
			  lug.lug_id = $luid AND
			  ent.tie_id = $teid AND 
			  ent.created_date BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59' 
		ORDER BY ent.created_date;";
		//echo $sql;
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

	public static function detalle_entrega($conexion, $iden) {
		$sql = "SELECT ref.ref_id, ref.ref_nu, CONCAT(per.per_identificacion,' ',dep.dep_abreviatura) as CI, per.per_apellidop as paterno, per.per_apellidom as materno, per.per_nombre as nombres, dis.dis_descripcion as distrito, bar.bar_descripcion as barrio_comunidad, ref.created_user as quienr, date_format(ref.created_date,'%d-%m-%Y %H:%i:%s') as cuandor, tie.tie_descripcion as tipo_entrega, ent.ent_id, lug.lug_descripcion as lugar, ent.created_user as quiene, date_format(ent.created_date,'%d-%m-%Y %H:%i:%s') as cuandoe, ent.tie_id, ent.lug_id     
		FROM dep_departamento dep, tie_tipoentrega tie, per_persona per, lug_lugar lug, ent_entrega ent 
		JOIN ref_regformulario ref ON ent.ref_id = ref.ref_id
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar on dir.bar_id =  bar.bar_id
		JOIN dis_distrito dis on bar.dis_id =  dis.dis_id 
		WHERE ent.ent_borrado = 'N' AND 
			  per.per_id = ref.per_id AND 
			  per.dep_id = dep.dep_id AND 
			  ent.lug_id = lug.lug_id AND 
			  ent.tie_id = tie.tie_id AND 
			  ent.ent_id = $iden;";
		//echo $sql;
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

	/* //total de entregas de un lugar por tipo de entrega
	public static function total_lugar_tie($conexion, $luid, $enid) {
		$sql = "SELECT COUNT(*) as total FROM ent_entrega ent WHERE ent.lug_id=$luid AND ent.tie_id=$enid AND ent.ent_borrado='N'";
		//echo $sql;
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
	} */

	//solo IDs por lugar de entrega y tipo de entrega
	public static function just_ids($conexion, $luid, $enid) {
		$sql = "SELECT ent.ent_id FROM ent_entrega ent WHERE ent.lug_id=$luid AND ent.tie_id=$enid AND ent.ent_borrado='N' ORDER BY ent.ent_id";
		//echo $sql;
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


	public static function total_gob($conexion) {
		$sql = "SELECT COUNT(*) as total 
		FROM per_persona per, lug_lugar lug, ent_entrega ent 
		JOIN ref_regformulario ref ON ent.ref_id = ref.ref_id
		JOIN dir_dirigente dir ON ref.dir_id = dir.dir_id
		JOIN bar_barrio bar on dir.bar_id =  bar.bar_id
		JOIN dis_distrito dis on bar.dis_id =  dis.dis_id 
		WHERE ent.ent_borrado = 'N' AND
			  per.per_id = ref.per_id AND 
			  ent.lug_id = lug.lug_id AND  
			  ent.lug_id in (SELECT lug2.lug_id FROM lug_lugar lug2 WHERE lug2.created_user IN ('R.MARTINEZ.31718','J.FERNANDEZ.32123','V.SERRUDO.32004','J.CUELLAR.32125','J.CERVANTES.32131'));";
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

	public static function get_proceso($conexion, $idproc) {
		$sql = "select pp.id as id_proceso, pp.cite, pp.nro_proceso, pp.fecha_emision, pp.nro_preventivo, pp.beneficiario_documento as ci_beneficiario, pp.beneficiario_nombre as beneficiario, pp.referencia, mo.id as id_motivo, mo.nombre as motivo, pp.monto, pp.dependencia_id, dp.nombre as dependencia  
		from pag_procesos pp, pag_motivos mo, per_dependencias dp  
		where pp.motivo_id = mo.id and 
					pp.dependencia_id = dp.id and 
					pp.id = '$idproc'";
		//echo $sql."<br>";
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

	public static function get_proceso_by_no($conexion, $no_pro, $anio) {
		$sql = "select pp.id as id_proceso, pp.cite, pp.nro_proceso, pp.fecha_emision, pp.nro_preventivo, pp.beneficiario_documento as ci_beneficiario, pp.beneficiario_nombre as beneficiario, pp.referencia, mo.id as id_motivo, mo.nombre as motivo, pp.monto, pp.dependencia_id, dp.nombre as dependencia  
		from pag_procesos pp, pag_motivos mo, per_dependencias dp  
		where pp.motivo_id = mo.id and 
			pp.dependencia_id = dp.id and 
			pp.nro_proceso = '$no_pro' and 
			EXTRACT(YEAR FROM pp.fecha_emision) = $anio";
		//echo $sql."<br>";
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

	public static function get_motivos($conexion) {
		$sql = "SELECT * FROM pag_motivos;";
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

	public static function get_dependencias($conexion) {
		$sql = "SELECT * FROM per_dependencias;";
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

	public static function update_proceso($conexion, $lista) {
		$sql = "UPDATE pag_procesos SET cite='".$lista['cite']."', fecha_emision='".$lista['fecha_emision']."', nro_preventivo='".$lista['nro_preventivo']."', beneficiario_documento='".$lista['beneficiario_documento']."', beneficiario_nombre='".$lista['beneficiario_nombre']."', referencia='".$lista['referencia']."', monto = '".$lista['monto']."', motivo_id = '".$lista['motivo_id']."', dependencia_id = '".$lista['dependencia_id']."' WHERE id = ".$lista['id'].";";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
		$re = $consulta->rowCount();
		return $re;
	}

	public static function delete_observaciones($conexion, $id_proceso){
		$sql = "DELETE FROM pag_observaciones WHERE proceso_id = $id_proceso;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
		$re = $consulta->rowCount();
		return $re;
	}

	public static function delete_procesos_estados($conexion, $id_proceso){
		$sql = "DELETE FROM pag_procesos_estados WHERE proceso_id = $id_proceso;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
		$re = $consulta->rowCount();
		return $re;
	}

	public static function delete_proceso($conexion, $id_proceso){
		$sql = "DELETE FROM pag_procesos WHERE id = $id_proceso;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$arr = $consulta->errorInfo();
		if($arr[0]!='00000'){echo "\nPDOStatement::errorInfo():\n"; print_r($arr);}
		$re = $consulta->rowCount();
		return $re;
	}

	public static function exits_observaciones($conexion, $id_proceso) {
		$sql = "SELECT * FROM pag_observaciones WHERE proceso_id = $id_proceso;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$registros = $consulta->fetchAll();
    if ($registros) {
			return $registros;
		} else {
			return false;
		};
	}

	public static function exits_procesos_estados($conexion, $id_proceso) {
		$sql = "SELECT * FROM pag_procesos_estados WHERE proceso_id = $id_proceso;";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();
		$registros = $consulta->fetchAll();
    if ($registros) {
			return $registros;
		} else {
			return false;
		};
	}

}
?>