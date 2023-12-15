<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");	
	$val = $class->limpiar_cadena($_POST["val"]);
	$num = $class->limpiar_cadena($_POST["num"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->buscar_u_l($val, $num);
	echo $result;
?>