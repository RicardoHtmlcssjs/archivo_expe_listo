<?php 
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$usuario = $class->limpiar_cadena($_POST["usuario_l"]);
	$contrasena = $class->limpiar_cadena($_POST["contrasena"]);
	$cl_usuarios = new Usuario($usuario, $contrasena);
	if(empty($usuario)  OR empty($contrasena)){
		$result = 2;
	}else{
		$result = $cl_usuarios->login_usuarios();
	};

	echo json_encode($result);
?>