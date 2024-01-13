<?php
include("../class_usuario_model.php");
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->mostrar_unidad_usu_cre();
	echo $result;
?>