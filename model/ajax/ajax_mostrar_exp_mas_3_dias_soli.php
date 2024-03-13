<?php
	include("../class_usuario_model.php");
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->mostrar_exp_mas_3_dias_soli();
	echo $result;
?>