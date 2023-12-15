<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$val1 = $_POST["val1"];
	$ci_per_s = $_POST["ci_per_s"];
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->solicitar_exp_analista($val1, $ci_per_s);
	echo $result;
?>