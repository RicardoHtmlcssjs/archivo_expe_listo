<?php
include("../class_usuario_model.php");
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->mos_tabla_emp_ana();
	echo $result;
?>