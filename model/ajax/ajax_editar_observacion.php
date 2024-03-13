<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
    
	$ci = $class->limpiar_cadena($_POST["ci"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->editar_observacion($ci);
	echo $result;
?>