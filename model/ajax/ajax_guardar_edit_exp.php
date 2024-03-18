<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
    $cedula_vieja = $class->limpiar_cadena($_POST['cedula_vieja']);
	$cedula = $class->limpiar_cadena($_POST['cedula']);
    $nombre = $class->limpiar_cadena($_POST['nombre']);
    $cargo = $class->limpiar_cadena($_POST['cargo']);
    $status = $class->limpiar_cadena($_POST['status']);
    $region = $class->limpiar_cadena($_POST['region']);
    $fila = $class->limpiar_cadena($_POST['fila']);
    $columna = $class->limpiar_cadena($_POST['columna']);
	$result = $cl_usuario->guardar_edit_exp($cedula_vieja, $cedula, $nombre, $cargo, $status, $region, $fila, $columna);
	echo $result;
?>