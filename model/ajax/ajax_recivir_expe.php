<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$ci = $class->limpiar_cadena($_POST["ci"]);
	$per_recivido = $_POST["per_recivido"];
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->recivir_expediente($ci, $per_recivido);
	echo $result;
?>