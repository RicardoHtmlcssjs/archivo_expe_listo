<?php
	include("lib/conexion.php");

	class Usuario extends Conexion{
		public function __construct($usuario, $contrasena){
			$this->usu = $usuario;
			$this->con = $contrasena;
		}
		public function hora_normal($hora){
			$horas = substr($hora, 0, 2);
			if($horas > 12){
				$horas = $horas - 12;
				$mp = "PM";
			}elseif($horas == 00){
				$horas = 12;
				$mp = "AM";
			}else{
				$mp = "AM";
			}
			$result = $horas . substr($hora, 2, 6) . " " . $mp;

			return $result;
		}
		// establecer fecha mas legible
		public function fecha_leg($fec){
			$result = "";
			if(empty($fec)){
				return $result;
			}
			$ano = substr($fec, 0, 4);
			$mes = substr($fec, 5, 2);
			$dia = substr($fec, 8, 2);
			if($mes == "01"){$mes = "ENE";}
			elseif ($mes == "02") {$mes = "FEB";}
			elseif ($mes == "03") {$mes = "MAR";}
			elseif ($mes == "04") {$mes = "ABR";}
			elseif ($mes == "05") {$mes = "MAY";}
			elseif ($mes == "06") {$mes = "JUN";}
			elseif ($mes == "07") {$mes = "JUL";}
			elseif ($mes == "08") {$mes = "AGO";}
			elseif ($mes == "09") {$mes = "SEP";}
			elseif ($mes == "10") {$mes = "OCT";}
			elseif ($mes == "11") {$mes = "NOV";}
			elseif ($mes == "12") {$mes = "DIC";}
			$result = $dia . "-" . $mes . "-" . $ano;
			return $result;
		}
		// quitar acentos de un texto
		public function quitar_acentos($cadena){
			$cadena = mb_strtolower($cadena, "UTF-8");
			$cadena_nueva = str_replace("á", "a", $cadena);
			$cadena_nueva2 = str_replace("é", "e", $cadena_nueva);
			$cadena_nueva3 = str_replace("í", "i", $cadena_nueva2);
			$cadena_nueva4 = str_replace("ó", "o", $cadena_nueva3);
			$cadena_nueva5 = str_replace("ú", "u", $cadena_nueva4);
			return $cadena_nueva5;
		}
		// comprobacion cuando el usuario se logea
		public function login_usuarios(){
			parent::conecta();
			$db = $this->conn;
			$contra = md5($this->con);
			$sql = "SELECT idusuario, login, syspassword, id_permisos, sysnombre, sysactivo FROM vsistema WHERE login = '".$this->usu."' AND syspassword = '".$contra."'";
			$query = $db->execute($sql);
			foreach ($query as $key) {
				$usuario = $key["login"];
				$password = $key["syspassword"];
				$idusuario = $key["idusuario"];
				$permisos = $key["id_permisos"];
				$nombre= $key["sysnombre"];
				$activo = $key["sysactivo"];
				$nombre_com_vsistema = $this->quitar_acentos($nombre);
				// $sql2 = "SELECT idsolicita FROM solicitante WHERE snombres = '".$nombre."'";
				$sql2 = "SELECT idsolicita, snombres FROM solicitante";
				$query2 = $db->execute($sql2);
				foreach($query2 as $key2){
					$nombre_con_solicitante = $this->quitar_acentos($key2["snombres"]);
					if($nombre_con_solicitante == $nombre_com_vsistema){
						$id_solicita = $key2["idsolicita"];
					}
				}
			}
			if(empty($this->usu || empty($this->con))){
				return 2;
			}elseif(isset($usuario)){
				if(md5($this->con) == $password){
					if($activo == 1){
						return 3;
					}
					session_start();
					$_SESSION["id_usu_log"] = $idusuario;
					$_SESSION["admin_usu_p"] = $permisos;
					$_SESSION["nombre_u"] = $nombre;
					$_SESSION["id_solicita"] = $id_solicita;
					if($permisos == 2){
						return 1.1;
					}else{
						return 1;
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
			// mostrar todo el personal
		}
		// mostrar usuario en el header
		public function mostrar_usuario(){
			parent::conecta();
			$db = $this->conn;
			session_start();
			$id_usu = $_SESSION["id_usu_log"];
			$query = $db->execute("SELECT sysnombre from vsistema where idusuario = $id_usu");
			foreach ($query as $key) {
				$usuario = $key['sysnombre'];
			}
			return $usuario;
		}
		public function mostrar_personal(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT personal.cedula, personal.nombres, cargos.desc_cargo, tblestatus.dstatus, tblestatus.cstatus, personal.nfil, personal.ncol, personal.statra, personal.destno  FROM personal INNER JOIN tblprpyac ON personal.cdprpyac = tblprpyac.cdprpyac INNER JOIN tblestatus ON personal.idstatus = tblestatus.idstatus LEFT JOIN cargos  ON personal.cargo = id_cargo ORDER BY cedula ASC");

			$array = array();
			foreach ($query as $key) {
				// $array[] = $key;
				$array[]=array("cedula" => "".$key['cedula']."","nombres" => "".$key['nombres']."", "cargo" => "".$key['desc_cargo']."", "dstatus" => "".$key['dstatus']."", "cstatus" => "".$key['cstatus']."", "nfil" => "".$key['nfil']."", "ncol" => "".$key['ncol']."", "statra" => "".$key['statra']."", "destno" => "".$key['destno']."");
			}
			$result = json_encode($array);
			return $result;
		}
		public function mostar_cargo_espesifico($id_cargo){
			parent::conecta();
			$db = $this->conn;
			$query2 = $db->execute("SELECT desc_cargo FROM cargos WHERE id_cargo = '".$id_cargo."'");
				foreach ($query9 as $key9) {
					$cargoo = $key9["desc_cargo"];
				}
		}

		// opcion nabvar expedientes sin devolber mostrar todos expedientes que noha sido devueltos
		public function todos_exp_sin_dev(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, controle.cedula, controle.id_controle, personal.nombres, controle.fentrega, controle.fdevolucion, controle.eanalista, controle.ranalista, controle.observacion FROM controle INNER JOIN solicitante ON controle.id_solicita = solicitante.idsolicita INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad INNER JOIN personal ON controle.cedula = personal.cedula WHERE ranalista ISNULL ORDER BY id_controle ASC");
			$solicitados_ex = "";
			$array = array();
			foreach ($query as $key) {
				// if(strlen($key["ranalista"]) == 0){
                	$query2 = $db->execute("SELECT snombres from solicitante where idsolicita = '".$key['eanalista']."'");
                	$query3 = $db->execute("SELECT snombres from solicitante where idsolicita = '".$key['ranalista']."'");
                	foreach ($query2 as $key2) {
                		$eanal = $key2["snombres"];
                	}
                	if($key['ranalista'] != ""){
                		foreach ($query3 as $key3) {
                		$ranal = $key3["snombres"];
                	}
                	}else{
                		$ranal = "";
                	}
					$tiempo_retraso = 0;
					$año_act = date("Y");
					$mes_act = date("m");
					$dia_act = date("d");
					$fec_entre_edi = $key['fentrega'];
					$año_sol = substr($fec_entre_edi, 0, 4);
					$mes_sol = substr($fec_entre_edi, 5, 2);
					$dia_sol = substr($fec_entre_edi, 8, 2);

					if($año_sol <= $año_act){
						if($mes_sol < $mes_act){
							$tiempo_retraso = $tiempo_retraso + 1;
						}elseif($mes_sol == $mes_act && ($dia_sol+3) < $dia_act){
							$tiempo_retraso = $tiempo_retraso + 1;
						}
					}

                	$fec_entre = $this->fecha_leg($key['fentrega']);
                	$snombres = $key['snombres'];
		            $solicitados_ex .= "<tr>";
		            $solicitados_ex .= "<td class=''><button type='submit' class='btn_mos_solicitud' onclick='entre_exp(".$key['cedula'].")'>D</button>".$key['snombres']."</td>
		                        <td class=''>".$key['micro']."</td>
		                        <td class=''>".$key['piso']."</td>
		                        <td class=''>".$key['unombre']."</td>
		                        <td class=''>".$key['cedula']."</td>
		                        <td class=''>".$key['nombres']."</td>
		                        <td class=''>".$fec_entre."</td>
		                        <td class=''>$eanal</td>
								<td class='text-center'><button class='btn btn-success py-0 px-1 btn-sm mr-1' onclick='modal_edit_observacion(".$key['cedula'].", 2)'>E</button>".$key['observacion']."</td>";
					if($tiempo_retraso > 0){
						$solicitados_ex .= "<td class='text-center text-danger'><b>X</b></td>";
					}else{
						$solicitados_ex .= "<td class='text-center'></td>";
					}
		            $solicitados_ex .="</tr>";
                // }
            }
                if($solicitados_ex == " "){
                	$solicitados_ex = 0;
                }                $result = json_encode($array);
                return $solicitados_ex;
		}
		// mostrar expediente solicitados de un usuario en espesifico o devolber expediente
		public function expedientes_solicitados($r_ci){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, controle.cedula, controle.id_controle, personal.nombres, controle.fentrega, controle.fdevolucion, controle.observacion, controle.eanalista, controle.ranalista FROM controle INNER JOIN solicitante ON controle.id_solicita = solicitante.idsolicita INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad INNER JOIN personal ON controle.cedula = personal.cedula WHERE controle.cedula = $r_ci");
			$solicitados_ex = "<div class='col-sm-12 col-md-12 col-lg-12 col-xl-12 exp_soli cont_col_tab1 my-3'>
            <h4 class='text-center'>Control de expedientes solicitados</h4>
            <table class='' style='width: 100%;'>
                <thead class='thead_tab1'>
                    <tr>
                        <th class='text-center tit_c_tab1'>Solicitante</th>
                        <th class='text-center tit_c_tab1'>Micro</th>
                        <th class='text-center tit_c_tab1'>Piso</th>
                        <th class='text-center tit_c_tab1'>Unidad Solicitante</th>
                        <th class='text-center tit_c_tab1'>Cedula</th>
                        <th class='text-center tit_c_tab1'>Nombres</th>
                        <th class='text-center tit_c_tab1'>Observacion</th>
                        <th class='text-center tit_c_tab1'>F.Entregado</th>
                        <th class='text-center tit_c_tab1'>F.Devuelto</th>
                        <th class='text-center tit_c_tab1'>Entregado por</th>
                        <th class='text-center tit_c_tab1'>Devuelto por</th>
                    </tr>
                </thead>
                <tbody class='tbody_tab1'>";
                foreach ($query as $key) {
					$query2 = $db->execute("SELECT snombres FROM solicitante WHERE idsolicita = '".$key['eanalista']."'");
					$query3 = $db->execute("SELECT snombres from solicitante where idsolicita = '".$key['ranalista']."'");
					// $query2 = $db->execute("SELECT login FROM vsistema WHERE idsolicita = '".$key['eanalista']."'");
					// $query3 = $db->execute("SELECT login FROM vsistema WHERE idsolicita = '".$key['ranalista']."'");

					foreach ($query2 as $key2) {
						$eanal = $key2["snombres"];
					}
					if($key['ranalista'] != ""){
						foreach ($query3 as $key3) {
							$ranal = $key3["snombres"];
						}
					}else{
						$ranal = "";
					}
					$fec_entre = $this->fecha_leg($key['fentrega']);
					$fec_rec = $this->fecha_leg($key['fdevolucion']);	
					
					$snombres = $key['snombres'];
					$solicitados_ex .= "<tr>";
					$solicitados_ex .= "<td class=''>".$key['snombres']."</td>
								<td class=''>".$key['micro']."</td>
								<td class=''>".$key['piso']."</td>
								<td class=''>".$key['unombre']."</td>
								<td class=''>".$key['cedula']."</td>
								<td class=''>".$key['nombres']."</td>
								<td class=''>".$key['observacion']."</td>
								<td class=''>".$fec_entre."</td>
								<td class=''>".$fec_rec."</td>
								<td class=''>$eanal</td>
								<td class=''>$ranal</td>
								</tr>";
                }
				$solicitados_ex .= "</tbody>
				</table>
				</div>";
				if(!isset($snombres)){
					$solicitados_ex = 0;
				}else{
					return $solicitados_ex;
				}
			return $solicitados_ex;
		}
		// mostrar expedientes solicitados con mas de 3 dias de retraso
		public function mostrar_exp_mas_3_dias_soli(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, controle.cedula, controle.id_controle, personal.nombres, controle.fentrega, controle.fdevolucion, controle.eanalista, controle.ranalista FROM controle INNER JOIN solicitante ON controle.id_solicita = solicitante.idsolicita INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad INNER JOIN personal ON controle.cedula = personal.cedula WHERE ranalista ISNULL");
			$solicitados_ex = 0;

			$array = array();
			foreach ($query as $key) {
				// if(strlen($key["ranalista"]) == 0){
                	$query2 = $db->execute("SELECT snombres from solicitante where idsolicita = '".$key['eanalista']."'");
                	$query3 = $db->execute("SELECT snombres from solicitante where idsolicita = '".$key['ranalista']."'");
                	foreach ($query2 as $key2) {
                		$eanal = $key2["snombres"];
                	}
                	if($key['ranalista'] != ""){
                		foreach ($query3 as $key3) {
                		$ranal = $key3["snombres"];
                	}
                	}else{
                		$ranal = "";
                	}
					$año_act = date("Y");
					$mes_act = date("m");
					$dia_act = date("d");
					$fec_entre_edi = $key['fentrega'];
					$año_sol = substr($fec_entre_edi, 0, 4);
					$mes_sol = substr($fec_entre_edi, 5, 2);
					$dia_sol = substr($fec_entre_edi, 8, 2);

					if($año_sol <= $año_act){
						if($mes_sol < $mes_act){
							$solicitados_ex = $solicitados_ex + 1;
						}elseif($mes_sol == $mes_act && ($dia_sol+3) < $dia_act){
							$solicitados_ex = $solicitados_ex + 1;
						}
					}

                	
                // }
            }
                // if($solicitados_ex == " "){
                // 	$solicitados_ex = 0;
                // }                
				// $result = json_encode($array);
                return $solicitados_ex;
		}
		// class borrar btn y si se solicitado expediente
		public function borra_btn_sol_exp($ci){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT fdevolucion, fentrega, ranalista FROM controle WHERE cedula = $ci ORDER BY id_controle DESC LIMIT 1");
			$fde = "";
			$fen = "";
			$rana = "";
			foreach ($query as $key) {
				$fde = $key["fdevolucion"];
				$rana = $key["ranalista"];
				$fen = $key["fentrega"];
			}
			if((strlen($fde) == 0) || (strlen($rana) == 0) && (strlen($fen) >= 1)){
				$result = 0;
			}else{
				$result = 1;
			}
			return $result;
		}
		// mostrara el que solicita el expediente analista
		public function solicitar_exp_analista($val1, $ci_per_s){
			$q1 = parent::consulta("s","SELECT idsolicita, snombres FROM solicitante WHERE tipo = 'S' AND activo = 'S' ORDER BY snombres ASC");
			$val1 = ucwords($val1);
			$q2 = parent::consulta("s","SELECT idsolicita, snombres FROM solicitante WHERE tipo = 'S' AND activo = 'S' AND snombres LIKE '%$val1%' ORDER BY snombres ASC");
			$select_soli = "<select class='form-control' style='text-center' id='analista'>";
			if(empty($val1)){
				foreach ($q1 as $key) {
					$select_soli .= "<option value='".$key["idsolicita"]."'>".$key["snombres"]."</option>";
				}
			}else{
				foreach ($q2 as $key2) {
					$select_soli .= "<option value='".$key2["idsolicita"]."'>".$key2["snombres"]."</option>";
				}
			}
			$select_soli .= "</select>";
			$select_soli .= "<input type='hidden' id='ci_per_agre_exp' value='".$ci_per_s."'>";
			return $select_soli;
		}
		// mostrar en el modal entrgado por
		public function entrgado_por(){
			$select_entregado_por = "<select class='form-control' id='entregado_por'>";
			$q1 = parent::consulta("s","SELECT idsolicita, snombres FROM solicitante WHERE tipo = 'E' AND  activo = 'S'");

			foreach ($q1 as $key) {
				$select_entregado_por .= "<option value='".$key["idsolicita"]."'>".$key["snombres"]."</option>";
			}
			$select_entregado_por .= "</select>";
			return $select_entregado_por;
		}
		// entregar expediente solicitado
		public function entregar_expediente($analis, $ci_entregar_exp, $observacion){
			parent::conecta();
			$db = $this->conn;
			$query =$db->execute("SELECT id_controle from controle order by id_controle desc limit 1");
			foreach ($query as $key) {
				$ult_id_controle = $key["id_controle"];
			}
			$ult_id_controle = $ult_id_controle + 1;
			session_start();
			$id_usu_log = $_SESSION["id_solicita"];
			$query2 = $db->execute("INSERT INTO controle (id_controle, cedula, id_solicita,  fentrega, eanalista, observacion) VALUES ($ult_id_controle, $ci_entregar_exp, $analis, now(), $id_usu_log, '".$observacion."')");
			return $id_usu_log;
		}
		// recvir expedien normal de la opc 2
		public function recivir_expediente($ci){
			parent::conecta();
			$db = $this->conn;
			// ver el ultimo id de la tabla controle en la bbdd
			$query1 = $db->execute("SELECT id_controle FROM controle WHERE cedula = $ci ORDER BY id_controle DESC LIMIT 1");
			foreach ($query1 as $key) {
				$ult_id = $key["id_controle"];
			}
			session_start();
			$id_usu_log = $_SESSION["id_solicita"];
			$db->execute("UPDATE controle SET fdevolucion = now(), ranalista = ".$id_usu_log." WHERE id_controle = ".$ult_id."");
			$result = 1;
			return  $result;
		}
		// DEBOLVER EXPEDIENTE SOLICITADOS EN LA OPCIN DE NADA MAS DEBOLVER EXPEDIENTE
		public function debolver_expe_solo($ci){
			parent::conecta();
			$db = $this->conn;
			// ver el ultimo id de la tabla controle en la bbdd
			$query1 = $db->execute("SELECT id_controle FROM controle WHERE cedula = $ci ORDER BY id_controle DESC LIMIT 1");
			foreach ($query1 as $key) {
				$ult_id = $key["id_controle"];
			}
			session_start();
			$id_usu_log = $_SESSION["id_solicita"];
			$re = $db->execute("UPDATE controle SET fdevolucion = now(), ranalista = ".$id_usu_log." WHERE id_controle = ".$ult_id."");
			if($re){
				$result = 1;
			}else{
				$result = 0;
			}
			// $result = $re;
			return  $result;
		}
		// mostra ultima observacion 
		public function editar_observacion($ci){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT id_controle, observacion FROM controle  WHERE cedula = $ci order by id_controle desc limit 1");
			foreach ($query as $key) {
				$id_controle = $key["id_controle"];
				$edit_observacion = $key["observacion"];
			}
			return $edit_observacion;
		}
		// guardar valor editado en la bbdd edtar observacion
		public function guardar_edit_obs($ci, $observacion){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT id_controle FROM controle  WHERE cedula = $ci order by id_controle desc limit 1");
			foreach ($query as $key) {
				$id_controle = $key["id_controle"];
			}
			$listo = $db->execute("UPDATE controle SET observacion = '".$observacion."' WHERE id_controle = $id_controle");
			if($listo){
				return 1;
			}else{
				return 0;
			}
		}
		// mostrar todos los resultados de status
		public function mostrar_estatus(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT idstatus, dstatus FROM tblestatus");
			$select_status = "";
			foreach($query as $key){
				$select_status .= "<option value='".$key["dstatus"]."'>".$key["dstatus"]."</option>";
			}
			return $select_status;
		}
		// mostrar todos los resultadus de las regiones
		public function mostrar_region(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT cdprpyac, nombreprpyac FROM tblprpyac WHERE cdprpyac BETWEEN '050001' AND '050024'");
			$select_status = "";
			foreach($query as $key){
				$select_status .= "<option value='".$key["nombreprpyac"]."'>".$key["nombreprpyac"]."</option>";
			}
			return $select_status;
		}
		// mostrar todos los cargos
		public function mostrar_cargo(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT id_cargo, desc_cargo FROM cargos ORDER BY id_cargo ASC");
			$select_status = "";
			foreach($query as $key){
				$select_status .= "<option value='".$key["id_cargo"]."'>".$key["desc_cargo"]."</option>";
			}
			return $select_status;
		}
		// buscar cargo y mostrarlo en un selec
		public function buscar_cargo($val_car_bus){
			
			$q2 = parent::consulta("s","SELECT id_cargo, desc_cargo FROM cargos WHERE desc_cargo ILIKE '%".$val_car_bus."%';");
			$select_car = "";
			
			foreach ($q2 as $key2) {
				$select_car .= "<option value='".$key2["id_cargo"]."'>".$key2["desc_cargo"]."</option>";
			}
			return $select_car;
		}
		// obtener cargo de un personal ene espesifico ya con el id ya listo
		public function cargo_act($id_cargo_act){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT desc_cargo FROM cargos WHERE id_cargo = $id_cargo_act");
			$cargo = "";
			foreach($query as $key){
				$cargo = $key["desc_cargo"];
			}
			return $cargo;
		}
		// guar la edicion de un expediente
		public function guardar_edit_exp($cedula_vieja, $cedula, $nombre, $cargo, $status, $region, $fila, $columna){
			parent::conecta();
			$db = $this->conn;
			
			$query2 = $db->execute("SELECT cdprpyac FROM tblprpyac WHERE nombreprpyac = '".$region."'");
			foreach ($query2 as $key2) {
				$id_region = $key2["cdprpyac"];
			}
			$con = 0;
			$query3 = $db->execute("SELECT cedula FROM personal");
			foreach ($query3 as $key3) {
				if($key3["cedula"] == $cedula){
					if($key3["cedula"] == $cedula_vieja){
						
					}else{
						$con = $con + 1;
					}
				}
			}
			if($con > 0){
				$res = 0;
			}else{
				$query4 = $db->execute("SELECT id_cargo FROM cargos WHERE desc_cargo = '".$cargo."'");
				foreach ($query4 as $key4) {
					$id_cargo = $key4["id_cargo"];
				}
				$query5 = $db->execute("SELECT idstatus FROM tblestatus WHERE dstatus = '".$status."'");
				foreach ($query5 as $key5) {
					$id_status = $key5["idstatus"];
				}

				$cc = $db->execute("UPDATE personal SET cedula = cedula, nombres = 'GIL BORGES ALBERTO', cdprpyac = '050001', idstatus = $id_status, nfil = $fila, ncol = $columna, cargo = $id_cargo WHERE cedula = $cedula_vieja");
				if($cc){
					$res = 1;
				}else{
					$res = 2;
				}
			}

			return $res;

		}
		// guardar expediente nuevo
		public function agre_expe($cedula, $nombre, $cargo, $estatus, $region, $fila, $columna){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT cedula FROM personal WHERE cedula = $cedula");
			$con = 0;
			foreach ($query as $key) {
				$con = $con + 1;
			}
			if($con > 0){
				$res = 0;
			}else{
				$query2 = $db->execute("SELECT idstatus FROM tblestatus WHERE dstatus = '".$estatus."'");
				$query3 = $db->execute("SELECT cdprpyac FROM tblprpyac WHERE nombreprpyac = '".$region."'");
				foreach($query2 as $key2){
					$id_sta = $key2["idstatus"];
				}
				foreach($query3 as $key3){
					$id_reg = $key3["cdprpyac"];
				}
				$c = $db->execute("INSERT INTO personal (cedula, nombres, cdprpyac, idstatus, nfil, ncol, cargo) VALUES ($cedula, '".$nombre."', '".$id_reg."', $id_sta, $fila, $columna, $cargo)");
				if($c){
					$res = 1;
				}else{
					$res = 2;
				}
				
			}
			return $res;
		}
		// editar expediente
		public function obtener_reg_edi_exp($cedula){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT personal.cedula, personal.nombres, tblestatus.dstatus, tblprpyac.nombreprpyac, personal.nfil, personal.ncol, cargos.desc_cargo  FROM personal INNER JOIN tblprpyac ON personal.cdprpyac = tblprpyac.cdprpyac INNER JOIN tblestatus ON personal.idstatus = tblestatus.idstatus LEFT JOIN cargos ON personal.cargo = cargos.id_cargo WHERE cedula = $cedula");
			
			$result = "";
			$array = array();
			foreach($query as $key){
				$array [] = $key;
			}
			$result = json_encode($array);
			return $result;
		}
		// guardar expediente en pdf 
		public function subir_expediente($gg){
			return $gg;
		}
		// tabla de mostrar usuarios que se logean
		public function mostrar_usu_login(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT vsistema.idusuario, vsistema.login, vsistema.correo, vsistema.sysnombre, vsistema.syscedula, vsistema.sysactivo, login_activo.desc_activo, vsistema.sysfechal, permisos_usu_log.desc_permisos, vsistema.id_permisos  FROM vsistema INNER JOIN permisos_usu_log ON vsistema.id_permisos = permisos_usu_log.id_permisos INNER JOIN login_activo ON vsistema.sysactivo = login_activo.id_activo");
			$solicitados_us = "";
			$aray = array();
			session_start();
			foreach ($query as $key) {
				if($key["idusuario"] != $_SESSION["id_usu_log"]){
					$fec1 = $this->fecha_leg($key["sysfechal"]);
					// $array[] = $key;
					// $array[]=array("idusuario" => "".$key['idusuario']."", "login" => "".$key['login']."", "correo" => "".$key["correo"]."", "sysnombre" => "".$key['sysnombre']."", "syscedula" => "".$key['syscedula']."", "sysactivo" => "".$key['sysactivo']"", "desc_activo" => "".$key['desc_activo']."", "sysfechal" => "".$key['sysfechal']."", "desc_permisos" => "".$key['desc_permisos']."", "id_permisos" => "".$key['id_permisos']."");
					$array[]=array("idusuario" => "".$key['idusuario']."","login" => "".$key['login']."", "correo" => "".$key["correo"]."", "sysnombre" => "".$key['sysnombre']."", "syscedula" => "".$key['syscedula']."", "desc_activo" => "".$key['desc_activo']."", "sysfechal" => "".$fec1."", "desc_permisos" => "".$key['desc_permisos']."", "id_permisos" => "".$key['id_permisos']."");
				}
			}
			$result = json_encode($array);
			return $result;
		}
		// mostrar select de activos
		public function mostrar_activo(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT * FROM login_activo");
			$resq = "";
			foreach ($query as $key) {
				$resq .=	"<option value='".$key['desc_activo']."'>".$key["desc_activo"]."</option>";
				
			}
			return $resq;
		}
		// mostrar select de permisos
		public function mostrar_permisos(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT * FROM permisos_usu_log");
			$res = "";
			foreach ($query as $key) {
				$res .= "<option value='".$key["desc_permisos"] ."'>".$key["desc_permisos"]."</option>";
			}
			return $res;
		}
		// MOSTRAR unidades existentes al crear un usuario
		public function mostrar_unidad_usu_cre(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT * FROM tblunidad");
			$res = "";
			foreach ($query as $key) {
				$res .= "<option value='".$key["idunidad"] ."'>".$key["unombre"]."</option>";
			}
			return $res;
		}
		// mostrar datos existentes en modal 3 actualizar usuario login 
		public function usu_editar($id_usuario){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT vsistema.idusuario, vsistema.login, vsistema.sysnombre, vsistema.correo, vsistema.syscedula, vsistema.sysfechal, login_activo.desc_activo, permisos_usu_log.desc_permisos  FROM vsistema INNER JOIN permisos_usu_log ON vsistema.id_permisos = permisos_usu_log.id_permisos INNER JOIN login_activo ON vsistema.sysactivo = login_activo.id_activo WHERE vsistema.idusuario = $id_usuario");
			$array = array();
			foreach($query as $key){
				$array [] = $key;
			}
			$result2 = json_encode($array);
			
			return $result2;
		}
		// actualizacion de datos del usuario siendo administrador
		public function actualizar_usu_adm($id_u, $act, $adm, $cor, $ci){
			$conexion = new Conexion();

			// verificar si existe la cedula
			if($ci != null){
				$query8 = $conexion->consulta("s", "SELECT syscedula FROM vsistema WHERE syscedula = $ci");
				foreach ($query8 as $key8){
					$ci_existe = $key8["syscedula"];
				}
				if(isset($ci_existe)){
					return 3;
				}
			}

			$query = $conexion->consulta("s","SELECT id_activo FROM login_activo WHERE desc_activo = '$act'");
			$query2 = $conexion->consulta("s","SELECT id_permisos FROM permisos_usu_log WHERE desc_permisos = '$adm'");
			foreach ($query as $key) {
				$id_act_s = $key["id_activo"];
				foreach ($query2 as $key2) {
					$id_per_s = $key2["id_permisos"];
				}
			}


			$query5 = $conexion->consulta("s","SELECT  id_permisos, sysactivo, correo FROM vsistema WHERE idusuario = $id_u");
			foreach ($query5 as $key5) {
				$permisos_ante = $key5["id_permisos"];
				$activo_ante = $key5["sysactivo"];
				$correo_ante = $key5["correo"];
			}
			$cont_cor_no = 0;
			$query7 =  $conexion->consulta("s","SELECT correo FROM vsistema WHERE correo = '".$cor."'");
			foreach ($query7 as $key7) {
				if($key7["correo"] == $cor){
					if($cor != $correo_ante){
						$cont_cor_no = $cont_cor_no + 1;
					}
				}
			}

			if($cont_cor_no >= 1){
				return 0;
				// $result = 0;
			}else{

			$cont = 0;
			$text1 = "";
			$text2 = "";
			$text3 = "";
			$text4 = "";
			$text5 = "";
			if($activo_ante != $id_act_s){
				$cont = $cont + 1;
				if($cont == 1){
					$text1 = "campo activo";	
				}
				if ($cont == 2) {
					$text2 = "campo activo";
				}
				if ($cont == 3) {
					$text3 = "campo activo";
				}
			}
			if($permisos_ante != $id_per_s){
				// $text4 = "campo permisos";
				$cont = $cont + 1;
				if($cont == 1){
					$text1 = "campo permisos";	
				}
				if ($cont == 2) {
					$text2 = "campo permisos";
				}
				if ($cont == 3) {
					$text3 = "campo permisos";
				}
				if ($cont == 4) {
					$text4 = "campo permisos";
				}
			}
			if($correo_ante != $cor){
				// $text4 = "campo permisos";
				$cont = $cont + 1;
				if($cont == 1){
					$text1 = "campo correo";
				}
				if ($cont == 2) {
					$text2 = "campo correo";
				}
				if ($cont == 3) {
					$text3 = "campo correo";
				}
				if ($cont == 4) {
					$text4 = "campo correo";
				}
				if ($cont == 5) {
					$text5 = "campo correo";
				}
			}
			if($ci != null){
				$cont = $cont + 1;
				if($cont == 1){
					$text1 = "campo cedula";
				}
				if ($cont == 2) {
					$text2 = "campo cedula";
				}
				if ($cont == 3) {
					$text3 = "campo cedula";
				}
				if ($cont == 4) {
					$text4 = "campo cedula";
				}
				if ($cont == 5) {
					$text5 = "campo cedula";
				}
				if ($cont == 6){
					$text6 = "campo cedula";
				}
			}
				if($cont == 1){
					$descipcion = "Datos actualizados: " . $text1 . ".";
				}
				if ($cont == 2) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ".";
				}
				if ($cont == 3) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ", " . $text3 . ".";
				}
				if ($cont == 4) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ", " . $text3 . ", " . $text4 . ".";
				}
				if ($cont == 5) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ", " . $text3 . ", " . $text4 . ", " . $text5 . ".";
				}
				if ($cont == 6) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ", " . $text3 . ", " . $text4 . ", " . $text5 . ", " . $text6 . ".";
				}
				if($cont == 0){
					$descipcion = "Datos actualizados son los mismos";
				}
			
			if($ci == null){
				$query3 = $conexion->consulta("s","UPDATE vsistema SET id_permisos = $id_per_s, sysactivo = $id_act_s, correo = '$cor'  WHERE idusuario = $id_u");
			}else{
				$query3 = $conexion->consulta("s","UPDATE vsistema SET login = '".$ci."', syspassword = '".md5($ci)."', id_permisos = $id_per_s, sysactivo = $id_act_s, correo = '$cor', syscedula = $ci  WHERE idusuario = $id_u");
			}
			session_start();
				$id_usu_admin = $_SESSION["id_usu_log"];
				$query4 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id_u, $id_usu_admin, now(), '". $descipcion ."', now())");
				$result = 2;
		}
			return $result;
		}
		// cambio de contraseña como administrador
		public function cam_contra_adm($id){
			$conexion = new Conexion();
				$query = $conexion->consulta("s","SELECT login, sysnombre, correo, syscedula FROM vsistema  WHERE idusuario = '".$id."'");
				foreach ($query as $key) {
					$usu = $key["login"];
					$correo = $key["correo"];
					$ci = $key["syscedula"];
					$nombre = $key["sysnombre"];
				}
			if($ci == 0 || empty($ci)){
				// $nueva_con_ne = $usu;
				// $nueva_con = md5($nueva_con_ne);
				return 30;
			}else{
				$nueva_con_ne = $ci;
				$nueva_con = md5($ci);
			}
			

			$query2 = $conexion->consulta("s","UPDATE vsistema SET syspassword = '".$nueva_con."' WHERE idusuario = $id");

			$descipcion = "Dato actualizado: Cambio de contraseña.";
			session_start();

			$id_usu_admin = $_SESSION["id_usu_log"];
			$query3 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id, $id_usu_admin, now(), '". $descipcion ."', now())");
			$cuerpo[]=array("login" => "".$usu."", "con" => "".$nueva_con."");

			if($correo == null){
				return 2;
			}else{
				include("class_email.php");
				$ema = new Email();
				return $ema->enviar_email($nueva_con_ne, $nombre, $correo);
			}
		}
		// tabla de transacciones de usuarios
		public function usus_login_transacciones(){
			$conexion = new Conexion();
			$solicitados_us = "";
			$query = $conexion->consulta("s","SELECT vsistema.idusuario, vsistema.login, vsistema.sysnombre, transaccion_usu.id_usu_adm, transaccion_usu.fecha_tran, transaccion_usu.hora_tran,transaccion_usu.desc_tran FROM transaccion_usu INNER JOIN vsistema ON  vsistema.idusuario = transaccion_usu.id_usu_tran ORDER BY transaccion_usu.id_transaccion DESC");

			

			$array = array();
			foreach ($query as $key) {
				$usu_adm = $key["id_usu_adm"];
				$horas = $this->hora_normal($key['hora_tran']);
				$query2 = $conexion->consulta("s","SELECT sysnombre  FROM vsistema WHERE idusuario = $usu_adm");
				foreach ($query2 as $key2) {
					$fec1 = $this->fecha_leg($key['fecha_tran']);
					$usuario_adm = $key2["sysnombre"];
					$array[]=array("login" => "".$key['login']."", "sysnombre" => "".$key['sysnombre']."", "idd" => "".$key2["sysnombre"]."", "fecha_tran" => "".$fec1."", "hora_tran" => "".$horas."", "desc_tran" => "".$key['desc_tran']."");
				}
			}
			$result = json_encode($array);
			return $result;
			// return $solicitados_us;
		}
		// agregar nuevo usuario 
		public function agre_usu_adm($ci, $nom, $act, $adm, $corr, $piso, $unidad){
			$conexion = new Conexion();
			if(empty($ci) || empty($nom) || empty($corr)){
				$result = 2;
			}else{
					$cont_ci = 0;
					$query = $conexion->consulta("s","SELECT login, syscedula FROM vsistema");
					foreach ($query as $key) {
						if($key["syscedula"] == $ci){
							$cont_ci ++;
						}
					}
					$query_correo = $conexion->consulta("s","SELECT correo FROM vsistema WHERE correo = '".$corr."'");
					foreach ($query_correo as $key_correo) {
						$existe_correo = $key_correo["correo"];
					}
					if($cont_ci > 0){
						return 3;
					}else if(isset($existe_correo)){
						return 4;
					}else{
						$query2 = $conexion->consulta("s","SELECT id_permisos FROM permisos_usu_log WHERE desc_permisos = '".$adm."'");
						foreach ($query2 as $key2) {
							$id_p_n = $key2["id_permisos"];
						}
						$query3 = $conexion->consulta("s","SELECT id_activo FROM login_activo WHERE desc_activo = '".$act."'");
						foreach ($query3 as $key3) {
							$id_a_n = $key3["id_activo"];
						}
						$query4 = $conexion->consulta("s","SELECT idusuario FROM vsistema ORDER BY idusuario DESC LIMIT 1");
					foreach ($query4 as $key4) {
						$idusuario = $key4["idusuario"];
					}

						$idusuario ++;
						$enc_cnt_nue = md5("$ci");
						$query5 = $conexion->consulta("s","INSERT INTO vsistema (idusuario, login, sysnombre, syspassword, sysfechal, syscedula, id_permisos, sysactivo, correo) VALUES ($idusuario,'".$ci."', '".$nom."', '".$enc_cnt_nue."', now(), $ci, $id_p_n, $id_a_n, '".$corr."')");

						session_start();
						$id_usu_admin = $_SESSION["id_usu_log"];
						$descipcion = "Creacion de usuario";
						$query5 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($idusuario, $id_usu_admin, now(), '". $descipcion ."', now())");
						$result = "Usuario creado exitosamente";

						$query6 = $conexion->consulta("s", "SELECT idsolicita FROM solicitante ORDER BY idsolicita DESC LIMIT 1");
						foreach ($query6 as $key6) {
							$ult_id_solicita = $key6["idsolicita"];
						}
						$ult_id_solicita = $ult_id_solicita + 1;

						$query7 = $conexion->consulta("s", "INSERT INTO solicitante (idsolicita, snombres, micro, piso, idunidad, tipo, activo) VALUES ($ult_id_solicita, '".$nom."', 0000, $piso, $unidad, 'E', '".$act."')");

						include("class_email.php");
						$ema = new Email();
						return $ema->enviar_email($ci, $nom, $corr);
					}

			}
			return $result;
		}
		// buscar personal por cedula en vsaime
		public function buscar_usu_vsaime($ci, $nac){
			$conexion = new Conexion();

			if($nac == "V"){
				$tabla = "dsaime";
			}else{
				$tabla = "dsaimextranjero";
			}

			// $query = $conexion->consulta2("s", "SELECT cedula, primer_nombre, primer_apellido FROM $tabla WHERE CAST(cedula AS VARCHAR) LIKE '%$ci%' ORDER BY cedula ASC LIMIT 1");
			$query = $conexion->consulta2("s", "SELECT cedula, primer_nombre, primer_apellido FROM $tabla WHERE cedula = $ci");
			$select_vi_cedu = [];
			foreach ($query as $key) {
				$nom_com = $key["primer_nombre"] . " " . $key["primer_apellido"];
				$select_vi_cedu[] = $key["cedula"];
				$select_vi_cedu[] = $nom_com;
				// $ci = $key["cedula"];
				// $select_vi_cedu .= "<option value='".$key["cedula"]."'>".$key["cedula"]." ".$key["primer_nombre"]." ".$key["primer_apellido"]."</option>";
			}
			$json = json_encode($select_vi_cedu);
			return $json;
		}
		// mostrar nombre del usuario a crear por medio de la cedula
		public function mostrar_nombre($ci){
			$ci_v = intval($ci);
			$conexion = new Conexion();
			$query = $conexion->consulta2("s", "SELECT primer_nombre, primer_apellido FROM dsaime WHERE cedula = $ci_v");
			$nombre_usu_ci= "";
			foreach ($query as $key) {
				$nombre_usu_ci = $key["primer_nombre"] . " " .  $key["primer_apellido"];
			}
			
			return $nombre_usu_ci;
		}
		// mostrar tabla empleados y analistas
		public function mos_tabla_emp_ana(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT solicitante.idsolicita, solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, solicitante.tipo, solicitante.activo FROM solicitante INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad WHERE tipo = 'S' ORDER BY solicitante.idsolicita DESC");
			$solicitados_us = "";
			$array = array();
			foreach ($query as $key) {
				$array[] = $key;
			}
			$result = json_encode($array);
			return $result;
			// return $solicitados_us;
		}
		// option modal del select unidad solicitante de modificar
		public function mostrar_unidad_s_empleado(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT * FROM tblunidad");
			$option = "";
			foreach ($query as $key) {
				$option .= "<option value='".$key['unombre']."'>".$key['unombre']."</option>";
			}

			return $option;
		}
		public function agre_act_tipo($id){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT solicitante.tipo, solicitante.activo, tblunidad.unombre  FROM solicitante INNER JOIN tblunidad ON tblunidad.idunidad = solicitante.idunidad WHERE solicitante.idsolicita = $id");
			$array = array();
			foreach($query as $key){
				$array [] = $key;
			}
			$result = json_encode($array);
			return $result;
		}
		// MOSTRAR ultimo id la tabla unidad
		public function id_uin(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT idsolicita FROM solicitante ORDER BY idsolicita ASC");
			foreach ($query as $key) {
				$id_sol = $key['idsolicita'];
			}
			return $id_sol;
		}
		// mostrar id de tblunidad
		public function mos_id_uni($unidad){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT idunidad FROM tblunidad WHERE unombre = '".$unidad."'");
			foreach ($query as $key) {
				$id_uni = $key['idunidad'];
			}
			return $id_uni;
		}
		// 
		// agregar analista o empleado
		public function agre_ana_emo($nombre, $piso, $unidad){
			$conexion = new Conexion();
			// select * from solicitante order by idsolicita desc
			$ul_id = $this->id_uin();
			$ul_id = $ul_id + 1;
			$id_unidad = $this->mos_id_uni($unidad);
			$query1 = $conexion->consulta("s","INSERT INTO solicitante (idsolicita, snombres, micro, piso, idunidad, tipo, activo) VALUES ($ul_id, '".$nombre."', 0, $piso, $id_unidad, 'S', 'S')");
			session_start();
			$id_usu_admin = $_SESSION["id_usu_log"];
			$query3 = $conexion->consulta("s","INSERT INTO transaccion_soli (id_s_tran, id_u_adm, fecha_tran, desc_tran, hora_tran) VALUES ($ul_id, $id_usu_admin, now(), 'Creacion de personal', now())");
			return 1;
		}
		// guardar cambios modal empleados y analistas
		public function guardar_r_a_e($unidad, $activo, $id_ae){
			$conexion = new Conexion();
			session_start();
			$id_u = $_SESSION['id_usu_log'];

			$query1 = $conexion->consulta("s","SELECT idunidad FROM tblunidad WHERE unombre = '$unidad'");
			foreach ($query1 as $key1) {
				$id_unidad = $key1["idunidad"];
			}
			
			
			$query4 = $conexion->consulta("s","SELECT idunidad, tipo, activo FROM solicitante WHERE idsolicita = $id_ae");
			foreach ($query4 as $key4) {
				$ac_id_uni = $key4["idunidad"];
				$ac_tipo = $key4["tipo"];
				$ac_activo = $key4["activo"];
			}

			$text1 = "";
			$text2 = "";
			$text3 = "";
			$count = 0;
			if($id_unidad != $ac_id_uni){
				$count = $count + 1;
				$text1 = "Unidad solicitante modificada"; 
			}
			if($ac_activo != $activo){
				$count = $count + 1;
				if($count == 1){
					$text1 = "Campo activo";
				}
				if($count == 2){
					$text2 = "Campo activo";
				}
			}
			if($count == 0){
					$descipcion = "Datos actualizados son los mismos.";
				}
			if($count == 1){
					$descipcion = "Datos actualizados: " . $text1 . ".";
				}
				if ($count == 2) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ".";
				}
				if ($count == 3) {
					$descipcion = "Datos actualizados: " . $text1 . ", " . $text2 . ", " . $text3 . ".";
				}
				

			$query3 = $conexion->consulta("s","INSERT INTO transaccion_soli (id_s_tran, id_u_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id_ae, $id_u, now(), '".$descipcion."', now())");
			$query2 = $conexion->consulta("s","UPDATE solicitante SET idunidad = $id_unidad, tipo = '".$ac_tipo."', activo = '".$activo."' WHERE idsolicita = $id_ae");


			return $descipcion;
		}
		// mostrar formulario de mi perfil
		public function perfil(){
			$conexion = new Conexion();
			session_start();
			$id_u = $_SESSION['id_usu_log'];
			
			$query = $conexion->consulta("s","SELECT vsistema.login, vsistema.sysnombre, vsistema.sysactivo, login_activo.desc_activo, vsistema.sysfechal, permisos_usu_log.desc_permisos, vsistema.id_permisos  FROM vsistema INNER JOIN permisos_usu_log ON vsistema.id_permisos = permisos_usu_log.id_permisos INNER JOIN login_activo ON vsistema.sysactivo = login_activo.id_activo WHERE idusuario = $id_u");

			foreach ($query as $key) {
				// <div class='row justify-content-center'> </div>
				 $for_perfil = "<div class='mx-0' style='display: flex; aling-item: center; justify-content: center;'>	
				 <div id='cont_2_tbl class='my-2'></div>			 
            <div class='col-sm-10 col-md-8 col-lg-8 col-xl-8 py-3 mt-5 cont_from_login' style='box-shadow:1px 5px 5px 5px #ccc; border-radius: 1rem;'>       
            	<div class='container'><div style='width: 100px;height: 100px; border-radius: 50%; background-color: #ccc; margin: 0 auto; display: flex; justify-content: center; aling-item: center;'><i class='fa-solid fas fa-user pt-1' style='font-size: 80px;'></i></div></div>                 
                <h2 class='text-center'>Mi perfil</h2>
                <form action=''>
                    <div class='mb-3'>
                        <label for='nombre_per' class='form-label'>nombre</label>
                        <input type='text'class='form-control' id='nombre_per' name='nombre_per' value='".$key['sysnombre']."'>
                    </div>
                    <div class='mb-3'>
                    	<button class='btn btn-primary' type='button' id='camb_contra_perfil' name='camb_contra_perfil' onclick='cambiar_contra_per()'>Cambiar mi contraseña</button>
                    </div>
                    <div class='d-grid gap-2'>
                        <button class='btn btn-success' type='button' id='guardar_perfil' name='guardar_perfil' onclick='guardar_per()'>Guardar</button>
                    <div id='resp_login' name='resp_login'></div>
                </form>                
            </div>
        </div>";
			}

			return $for_perfil;
		}
		// actulizar datos de mi perfil
		public function actualizar_perfil($nom){
			$conexion = new Conexion();
			session_start();
			$id_u = $_SESSION['id_usu_log'];
			$query1 = $conexion->consulta("s","SELECT sysnombre FROM vsistema WHERE idusuario = $id_u");
			foreach ($query1 as $key1) {
				$nom_exi = $key1["sysnombre"];
			}
					$query3 = $conexion->consulta("s","UPDATE vsistema SET  sysnombre = '".$nom."'  WHERE idusuario = $id_u");
					$_SESSION["nombre_u"] = $nom;


					$descipcion = "Actualizacion de nombre por el usuario propietario.";
					$query4 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id_u, $id_u, now(), '". $descipcion ."', now())");

					$id_solicita = $_SESSION["id_solicita"];
					$query5 = $conexion->consulta("s", "UPDATE solicitante SET snombres = '".$nom."' WHERE idsolicita = $id_solicita");

			return 1;

		}
		// guardar cambio de contraseña mi perfil
		public function cam_cont_perfil($cont_v, $cont_n1, $cont_n2){
			$conexion = new Conexion();
			session_start();
			$id_u = $_SESSION['id_usu_log'];
			$cont_v = md5($cont_v);
			$cont_n1 = md5($cont_n1);
			$cont_n2 = md5($cont_n2);
			$query1 = $conexion->consulta("s","SELECT syspassword FROM vsistema WHERE idusuario = $id_u");
			foreach ($query1 as $key1) {
				$cont_actual = $key1["syspassword"];
			}
			if($cont_actual != $cont_v){
				$result = 0;
			}else{
				$contra_existe = 0;
				$query2 = $conexion->consulta("s","SELECT syspassword FROM vsistema");
				foreach ($query2 as $key2) {
					if($key2["syspassword"] == $cont_n1 && $cont_n1 != $cont_actual){
						$contra_existe++;
					}
				}
				if($contra_existe >= 1){
					$result = 2;
				}else{
					$query2 = $conexion->consulta("s","UPDATE vsistema SET syspassword = '".$cont_n1."' WHERE idusuario = $id_u");
					$descipcion = "Cambio de contraseña por el mismo usuario.";
					$query4 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id_u, $id_u, now(), '". $descipcion ."', now())");
					$result = 1;
				}				
			}

			return $result;
		}
		public function mos_tabla_tran_emp_ana(){
			$conexion = new Conexion();
			$query1 = $conexion->consulta("s","SELECT solicitante.snombres, solicitante.idsolicita, vsistema.login, transaccion_soli.fecha_tran, transaccion_soli.desc_tran, transaccion_soli.hora_tran FROM transaccion_soli INNER JOIN solicitante ON solicitante.idsolicita = transaccion_soli.id_s_tran INNER JOIN vsistema ON vsistema.idusuario = id_u_adm ORDER BY transaccion_soli.id_transaccion DESC");
			$solicitados_us = "";
			$array = array();
			foreach ($query1 as $key) {
				$horas = $this->hora_normal($key['hora_tran']);
				$fec1 = $this->fecha_leg($key["fecha_tran"]);
					$array[]=array("snombres" => "".$key['snombres']."", "login" => "".$key['login']."", "fecha_tran" => "".$fec1."", "desc_tran" => "".$key['desc_tran']."", "hora_tran" => "".$horas."");
					$result = json_encode($array);
			}
			return $result;
			// return $solicitados_us;
		}
	}
?>