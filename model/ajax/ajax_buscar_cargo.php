<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$val_car_bus = $class->limpiar_cadena($_POST["val_car_bus"]);
	$result = $cl_usuario->buscar_cargo($val_car_bus);
	echo $result;
?>