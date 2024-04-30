<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$id = $class->limpiar_cadena($_POST['id']);
	$result = $cl_usuario->mostrar_cedula($id);
	echo $result;
?>