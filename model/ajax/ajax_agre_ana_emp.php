<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$cedula = $class->limpiar_cadena($_POST['cedula']);
	$nombre = $class->limpiar_cadena($_POST['nombre']);
	$piso = $class->limpiar_cadena($_POST['piso']);
	$unida = $_POST["unidad"];
	$result = $cl_usuario->agre_ana_emo($cedula, $nombre, $piso, $unida);
	echo $result;
?>