<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$form_data = $_FILES["form_data"];
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->subir_expediente($form_data);
	echo $result;
?>