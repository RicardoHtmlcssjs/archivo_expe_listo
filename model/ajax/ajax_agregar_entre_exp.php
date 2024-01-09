<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");
	$analis = $class->limpiar_cadena($_POST["analis"]);
	$ci_entregar_exp = $class->limpiar_cadena($_POST["ci_entregar_exp"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->entregar_expediente($analis, $ci_entregar_exp);
	echo $result;
?>