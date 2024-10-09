<?php
	include("../class_usuario_model.php");
    $cedula = $_POST["cedula"];
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->mostrar_expedientes_img($cedula);
	echo $result;
?>