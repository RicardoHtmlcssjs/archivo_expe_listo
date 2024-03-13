<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$ci = $class->limpiar_cadena($_POST["ci"]);
    $observacion = $class->limpiar_cadena($_POST["observacion_nv"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->guardar_edit_obs($ci, $observacion);
	echo $result;
?>