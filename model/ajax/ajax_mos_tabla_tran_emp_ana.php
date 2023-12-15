<?php
include("../class_usuario_model.php");
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->mos_tabla_tran_emp_ana();
	echo $result;
?>