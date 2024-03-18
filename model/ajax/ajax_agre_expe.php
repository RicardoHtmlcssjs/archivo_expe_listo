<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$cedula = $class->limpiar_cadena($_POST['cedula']);
	$nombre = $class->limpiar_cadena($_POST['nombre']);
    $cargo = $class->limpiar_cadena($_POST['cargo']);
    $estatus = $class->limpiar_cadena($_POST['estatus']);
	$region = $class->limpiar_cadena($_POST['region']);
	$fila = $class->limpiar_cadena($_POST['fila']);
    $columna = $class->limpiar_cadena($_POST['columna']);
	$result = $cl_usuario->agre_expe($cedula, $nombre, $cargo, $estatus, $region, $fila, $columna);
	echo $result;
?>