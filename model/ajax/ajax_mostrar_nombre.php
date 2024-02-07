<?php
	include("../class_usuario_model.php");
    include("../class_limpiar_cadena.php");
	$cl_usuario = new Usuario("","");
	$ci = $class->limpiar_cadena($_POST["ci"]);
	$result = $cl_usuario->mostrar_nombre($ci);
	echo $result;
?>