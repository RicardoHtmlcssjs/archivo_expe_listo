<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$r_ci = $class->limpiar_cadena($_POST["ci"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->expedientes_solicitados($r_ci);
	echo $result;
?>