<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$cedula = $class->limpiar_cadena($_POST['ci']);
	$result = $cl_usuario->obtener_reg_edi_exp($cedula);
	echo $result;
?>