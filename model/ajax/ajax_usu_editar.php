<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$id_usuario = $class->limpiar_cadena($_POST["id_usuario"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->usu_editar($id_usuario);
	echo $result;
?>