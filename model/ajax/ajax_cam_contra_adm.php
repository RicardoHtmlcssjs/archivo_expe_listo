<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$id = $class->limpiar_cadena($_POST["id"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->cam_contra_adm($id);
	echo $result;
?>