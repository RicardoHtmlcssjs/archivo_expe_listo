<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");	
	$analis = $class->limpiar_cadena($_POST["analis"]);
	$p_entregado = $class->limpiar_cadena($_POST["p_entregado"]);
	$ci_entregar_exp = $class->limpiar_cadena($_POST["ci_entregar_exp"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->entregar_expediente($analis, $p_entregado, $ci_entregar_exp);
	echo $result;
?>