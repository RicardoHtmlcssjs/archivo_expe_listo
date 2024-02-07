<?php
    include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$ci = $class->limpiar_cadena($_POST["ci"]);
	$nac = $class->limpiar_cadena($_POST["nac"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->buscar_usu_vsaime($ci, $nac);
	echo $result;
?>