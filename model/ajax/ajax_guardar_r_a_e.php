<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$unidad = $class->limpiar_cadena($_POST["unidad"]);
	$activo = $class->limpiar_cadena($_POST["activo"]);
	$id_ae = $class->limpiar_cadena($_POST["id_ae"]);
	$cedula = $class->limpiar_cadena($_POST["cedula"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->guardar_r_a_e($unidad, $activo, $id_ae, $cedula);
	echo $result;
?>