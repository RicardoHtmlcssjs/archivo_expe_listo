<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");
$id_cargo_act = $class->limpiar_cadena($_POST["id_cargo_act"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->cargo_act($id_cargo_act);
	echo $result;
?>