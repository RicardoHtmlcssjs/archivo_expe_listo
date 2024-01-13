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
		// comprobacion cuando el usuario se logea
		public function login_usuarios(){
			parent::conecta();
			$db = $this->conn;
			$contra = md5($this->con);
			$sql = "SELECT idusuario, login, syspassword, id_permisos, sysnombre FROM vsistema WHERE login = '".$this->usu."' AND syspassword = '".$contra."'";
			$query = $db->execute($sql);
			foreach ($query as $key) {
				$usuario = $key["login"];
				$password = $key["syspassword"];
				$idusuario = $key["idusuario"];
				$permisos = $key["id_permisos"];
				$nombre= $key["sysnombre"];
				$sql2 = "SELECT idsolicita FROM solicitante WHERE snombres = '".$nombre."'";
				$query2 = $db->execute($sql2);
				foreach($query2 as $key2){
					$id_solicita = $key2["idsolicita"];
				}
			}
			if(empty($this->usu || empty($this->con))){
				return 2;
			}elseif(isset($usuario)){
				if(md5($this->con) == $password){
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
			$query = $db->execute("SELECT login from vsistema where idusuario = $id_usu");
			foreach ($query as $key) {
				$usuario = $key['login'];
			}
			return $usuario;
		}
		public function mostrar_personal(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT personal.cedula, personal.nombres, tblestatus.dstatus, tblestatus.cstatus, personal.nfil, personal.ncol, personal.statra, personal.destno  FROM personal INNER JOIN tblprpyac ON personal.cdprpyac = tblprpyac.cdprpyac INNER JOIN tblestatus ON personal.idstatus = tblestatus.idstatus");

			$array = array();
			foreach ($query as $key) {
				$array[] = $key;
			}
			$result = json_encode($array);
			return $result;
		}

		// opcion nabvar expedientes sin devolber mostrar todos expedientes que noha sido devueltos
		public function todos_exp_sin_dev(){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, controle.cedula, controle.id_controle, personal.nombres, controle.fentrega, controle.fdevolucion, controle.eanalista, controle.ranalista FROM controle INNER JOIN solicitante ON controle.id_solicita = solicitante.idsolicita INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad INNER JOIN personal ON controle.cedula = personal.cedula");
			$solicitados_ex = "";
			$array = array();
			foreach ($query as $key) {
				if(strlen($key["ranalista"]) == 0){
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
                	
                	$snombres = $key['snombres'];
		            $solicitados_ex .= "<tr>";
		            $solicitados_ex .= "<td class=''><button type='submit' class='btn_mos_solicitud' onclick='entre_exp(".$key['cedula'].")'>D</button>".$key['snombres']."</td>
		                        <td class=''>".$key['micro']."</td>
		                        <td class=''>".$key['piso']."</td>
		                        <td class=''>".$key['unombre']."</td>
		                        <td class=''>".$key['cedula']."</td>
		                        <td class=''>".$key['nombres']."</td>
		                        <td class=''>".$key['fentrega']."</td>
		                        <td class=''>$eanal</td>
		                    </tr>";
                }
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
			$query = $db->execute("SELECT solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, controle.cedula, controle.id_controle, personal.nombres, controle.fentrega, controle.fdevolucion, controle.eanalista, controle.ranalista FROM controle INNER JOIN solicitante ON controle.id_solicita = solicitante.idsolicita INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad INNER JOIN personal ON controle.cedula = personal.cedula WHERE controle.cedula = $r_ci");
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
					$snombres = $key['snombres'];
					$solicitados_ex .= "<tr>";
					$solicitados_ex .= "<td class=''>".$key['snombres']."</td>
								<td class=''>".$key['micro']."</td>
								<td class=''>".$key['piso']."</td>
								<td class=''>".$key['unombre']."</td>
								<td class=''>".$key['cedula']."</td>
								<td class=''>".$key['nombres']."</td>
								<td class=''>".$key['fentrega']."</td>
								<td class=''>".$key['fdevolucion']."</td>
								<td class=''>$eanal</td>
								<td class=''>$ranal</td>
								</tr>";
                }
				$solicitados_ex .= "</tbody>
				</table>
				</div>";
				if(!isset($snombres)){
					$solicitados_ex = 0;
				}
			return $solicitados_ex;
		}
		// class borrar btn y si se solicitado expediente
		public function borra_btn_sol_exp($ci){
			parent::conecta();
			$db = $this->conn;
			$query = $db->execute("SELECT fdevolucion, ranalista FROM controle WHERE cedula = $ci");
			$count = 0;
			foreach ($query as $key) {
				$count = $count + 1;
				$fde = $key["fdevolucion"];
				$rana = $key["ranalista"];
			}
			if($count == 0){
				$result = 1;
			}elseif((strlen($fde) == 0 && $count > 0) || (strlen($rana) == 0 && $count > 0)){
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
			// parent::conecta();
			// $db = $this->conn;
			// $query = $db->execute("SELECT idsolicita, snombres FROM solicitante WHERE tipo = 'E'");
			$select_entregado_por = "<select class='form-control' id='entregado_por'>";
			$q1 = parent::consulta("s","SELECT idsolicita, snombres FROM solicitante WHERE tipo = 'E' AND  activo = 'S'");

			foreach ($q1 as $key) {
				$select_entregado_por .= "<option value='".$key["idsolicita"]."'>".$key["snombres"]."</option>";
			}
			$select_entregado_por .= "</select>";
			return $select_entregado_por;
		}
		// entregar expediente solicitado
		public function entregar_expediente($analis, $ci_entregar_exp){
			parent::conecta();
			$db = $this->conn;
			
			$query =$db->execute("SELECT id_controle from controle");
			foreach ($query as $key) {
				$ult_id_controle = $key["id_controle"];
			}
			$ult_id_controle = $ult_id_controle + 1;
			session_start();
			$id_usu_log = $_SESSION["id_solicita"];
			$query2 = $db->execute("INSERT INTO controle (id_controle, cedula, id_solicita, fentrega, eanalista) VALUES ($ult_id_controle, $ci_entregar_exp, $analis, now(), $id_usu_log)");
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
		// tabla de mostrar usuarios que se logean
		public function mostrar_usu_login(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT vsistema.idusuario, vsistema.login, vsistema.correo, vsistema.sysnombre, vsistema.sysactivo, login_activo.desc_activo, vsistema.sysfechal, permisos_usu_log.desc_permisos, vsistema.id_permisos  FROM vsistema INNER JOIN permisos_usu_log ON vsistema.id_permisos = permisos_usu_log.id_permisos INNER JOIN login_activo ON vsistema.sysactivo = login_activo.id_activo");
			$solicitados_us = "";
			$aray = array();
			foreach ($query as $key) {
				$array[] = $key;

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
			$query = $conexion->consulta("s","SELECT vsistema.idusuario, vsistema.login, vsistema.sysnombre, vsistema.correo, vsistema.sysfechal, login_activo.desc_activo, permisos_usu_log.desc_permisos  FROM vsistema INNER JOIN permisos_usu_log ON vsistema.id_permisos = permisos_usu_log.id_permisos INNER JOIN login_activo ON vsistema.sysactivo = login_activo.id_activo WHERE vsistema.idusuario = $id_usuario");
			$array = array();
			foreach($query as $key){
				$array [] = $key;
			}
			$result2 = json_encode($array);
			
			return $result2;
		}
		// actualizacion de datos del usuario siendo administrador
		public function actualizar_usu_adm($id_u, $usu, $nom, $act, $adm, $cor){
			$conexion = new Conexion();					

			$query = $conexion->consulta("s","SELECT id_activo FROM login_activo WHERE desc_activo = '$act'");
			$query2 = $conexion->consulta("s","SELECT id_permisos FROM permisos_usu_log WHERE desc_permisos = '$adm'");
			foreach ($query as $key) {
				$id_act_s = $key["id_activo"];
				foreach ($query2 as $key2) {
					$id_per_s = $key2["id_permisos"];
				}
			}


			$query5 = $conexion->consulta("s","SELECT login, sysnombre, id_permisos, sysactivo, correo FROM vsistema WHERE idusuario = $id_u");
			foreach ($query5 as $key5) {
				$usu_ante = $key5["login"];
				$nombre_ante = $key5["sysnombre"];
				$permisos_ante = $key5["id_permisos"];
				$activo_ante = $key5["sysactivo"]; 
				$correo_ante = $key5["correo"];
			}
			$cont_cor_no = 0;
			$cont_usu_no = 0;
			$query6 =  $conexion->consulta("s","SELECT login FROM vsistema WHERE login = '".$usu."'");
			foreach ($query6 as $key6) {
				if($key6["login"] == $usu){
					if($usu != $usu_ante){
						$cont_usu_no = $cont_usu_no + 1;
					}
				}	
			}
			$query7 =  $conexion->consulta("s","SELECT correo FROM vsistema WHERE correo = '".$cor."'");
			foreach ($query7 as $key7) {
				if($key7["correo"] == $cor){
					if($cor != $correo_ante){
						$cont_cor_no = $cont_cor_no + 1;
					}
				}	
			}

			if($cont_cor_no >= 1){
				$result = 0;
			}elseif($cont_usu_no >= 1){
				$result = 1;
			}else{

			$cont = 0;
			$text1 = "";
			$text2 = "";
			$text3 = "";
			$text4 = "";
			$text5 = "";
			if($usu_ante != $usu){
				$cont = $cont + 1;
				$text1 = "el usuario";
			}
			if($nombre_ante != $nom){
				$cont = $cont + 1;
				if($cont == 1){
					$text1 = "el nombre";	
				}
				if ($cont == 2) {
					$text2 = "el nombre";
				}
				
			}
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
				if($cont == 0){
					$descipcion = "Datos actualizados son los mismos";
				}

			$query3 = $conexion->consulta("s","UPDATE vsistema SET login = '$usu', sysnombre = '$nom', id_permisos = $id_per_s, sysactivo = $id_act_s, correo = '$cor'  WHERE idusuario = $id_u");

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
				$query = $conexion->consulta("s","SELECT login, correo FROM vsistema  WHERE idusuario = '".$id."'");
				foreach ($query as $key) {
					$usu = $key["login"];
					$correo = $key["correo"];
				}
			$num_ram = mt_rand(1,1000);
			$nueva_con_ne = $usu . $num_ram; 
				$nueva_con = md5($nueva_con_ne);

			$query2 = $conexion->consulta("s","UPDATE vsistema SET syspassword = '".$nueva_con."' WHERE idusuario = $id");

			$descipcion = "Dato actualizado: Cambio de contraseña.";
			session_start();
			$id_usu_admin = $_SESSION["id_usu_log"];
			$query3 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id, $id_usu_admin, now(), '". $descipcion ."', now())");
			// $cuerpo[]=array("login" => "".$usu."", "con" => "".$nueva_con."");

			if($correo == null){
				return 2;
			}else{
				include("class_email.php");
				$ema = new Email();			
				return $ema->enviar_email($nueva_con_ne, $usu, $correo);	
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
				$query2 = $conexion->consulta("s","SELECT login  FROM vsistema WHERE idusuario = $usu_adm");
				foreach ($query2 as $key2) {
					$usuario_adm = $key2["login"];
					$array[]=array("login" => "".$key['login']."", "sysnombre" => "".$key['sysnombre']."", "idd" => "".$key2["login"]."", "fecha_tran" => "".$key['fecha_tran']."", "hora_tran" => "".$horas."", "desc_tran" => "".$key['desc_tran']."");
				}
			}
			$result = json_encode($array);
			return $result;
			// return $solicitados_us;
		}
		// agregar nuevo usuario  $usu, $nom, $act, $adm, $corr
		public function agre_usu_adm($usu, $nom, $act, $adm, $corr, $piso, $unidad){
			$conexion = new Conexion();
			if(empty($usu) || empty($nom) || empty($corr)){
				$result = 2;
			}else{
					$cont_usu = 0;
					$query = $conexion->consulta("s","SELECT login FROM vsistema");
					foreach ($query as $key) {
						if($key["login"] == $usu){
							$cont_usu ++;
						}
					}
					$query_correo = $conexion->consulta("s","SELECT correo FROM vsistema WHERE correo = '".$corr."'");
					foreach ($query_correo as $key_correo) {
						$existe_correo = $key_correo["correo"];
					}
					if($cont_usu > 0){
						// $result = "El usuario ya existe";
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
						$contra_nueva = $usu . mt_rand(1, 1000);
						$enc_cnt_nue = md5("$contra_nueva");
						$query5 = $conexion->consulta("s","INSERT INTO vsistema (idusuario, login, sysnombre, syspassword, sysfechal, id_permisos, sysactivo, correo) VALUES ($idusuario,'".$usu."', '".$nom."', '".$enc_cnt_nue."', now(), $id_p_n, $id_a_n, '".$corr."')");

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
						return $ema->enviar_email($contra_nueva, $usu, $corr);
					}

			}
			return $result;
		}
		// mostrar tabla empleados y analistas
		public function mos_tabla_emp_ana(){
			$conexion = new Conexion();
			$query = $conexion->consulta("s","SELECT solicitante.idsolicita, solicitante.snombres, solicitante.micro, solicitante.piso, tblunidad.unombre, solicitante.tipo, solicitante.activo FROM solicitante INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad ORDER BY solicitante.idsolicita DESC");
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
		public function agre_ana_emo($nombre, $piso, $unidad, $tipo){
			$conexion = new Conexion();
			// select * from solicitante order by idsolicita desc
			$ul_id = $this->id_uin();
			$ul_id = $ul_id + 1;
			$id_unidad = $this->mos_id_uni($unidad);
			$query1 = $conexion->consulta("s","INSERT INTO solicitante (idsolicita, snombres, micro, piso, idunidad, tipo, activo) VALUES ($ul_id, '".$nombre."', 0, $piso, $id_unidad, '".$tipo."', 'S')");
			session_start();
			$id_usu_admin = $_SESSION["id_usu_log"];
			$query3 = $conexion->consulta("s","INSERT INTO transaccion_soli (id_s_tran, id_u_adm, fecha_tran, desc_tran, hora_tran) VALUES ($ul_id, $id_usu_admin, now(), 'Creacion de personal', now())");
			return 1;
		}
		// guardar cambios modal empleados y analistas
		public function guardar_r_a_e($unidad, $activo, $tipo, $id_ae){
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
			if($ac_tipo != $tipo){
				$count = $count + 1;
				if($count == 1){
					$text1 = "Campo tipo";
				}
				if($count == 2){
					$text2 = "Campo tipo"; 
				}
				if($count == 3){
					$text3 = "Campo tipo"; 
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
			$query2 = $conexion->consulta("s","UPDATE solicitante SET idunidad = $id_unidad, tipo = '".$tipo."', activo = '".$activo."' WHERE idsolicita = $id_ae");


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
                        <label for='usuario_per' class='form-label'>Usuario</label>
                        <input type='text'class='form-control' id='usuario_per' name='usuario_per' value='".$key['login']."'>
                    </div>
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
		public function actualizar_perfil($usu, $nom){
			 
			$conexion = new Conexion();
			session_start();
			$id_u = $_SESSION['id_usu_log'];
			$query1 = $conexion->consulta("s","SELECT login, sysnombre FROM vsistema WHERE idusuario = $id_u");
			foreach ($query1 as $key1) {
				$usu_exi = $key1["login"];
				$nom_exi = $key1["sysnombre"]; 
			}
			$query2 = $conexion->consulta("s","SELECT login FROM vsistema WHERE login = '$usu'");		
			foreach ($query2 as $key2) {
					$usu_esco =$key2["login"];					
				}
				if(isset($usu_esco)){
					if($usu_esco == $usu_exi){
						$result = 1;
					}else{
						$result = 0;
					}
				}else{
					$result = 1;
				}	
				if($result == 1){
					$query3 = $conexion->consulta("s","UPDATE vsistema SET  login = '".$usu."',  sysnombre = '".$nom."'  WHERE idusuario = $id_u");

					$descipcion = "Actualizacion de usuario y nombre por el usuario propietario.";
					$query4 = $conexion->consulta("s","INSERT INTO transaccion_usu (id_usu_tran, id_usu_adm, fecha_tran, desc_tran, hora_tran) VALUES ($id_u, $id_u, now(), '". $descipcion ."', now())");
				}

			return $result;

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
					// $array[] = $key1;
					$array[]=array("snombres" => "".$key['snombres']."", "login" => "".$key['login']."", "fecha_tran" => "".$key["fecha_tran"]."", "desc_tran" => "".$key['desc_tran']."", "hora_tran" => "".$horas."");
					$result = json_encode($array);
			}
			return $result;
			// return $solicitados_us;
		}
	}
?>