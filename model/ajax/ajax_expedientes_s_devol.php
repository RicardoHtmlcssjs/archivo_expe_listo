<?php
	include("../class_usuario_model.php");
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->todos_exp_sin_dev();
	echo $result;
?>