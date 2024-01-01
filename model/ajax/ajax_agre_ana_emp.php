<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$nombre = $class->limpiar_cadena($_POST['nombre']);
	$piso = $class->limpiar_cadena($_POST['piso']);
	$unida = $_POST["unidad"];
	$tipo = $_POST["tipo"];
	$result = $cl_usuario->agre_ana_emo($nombre, $piso, $unida, $tipo);
	echo $result;
?>