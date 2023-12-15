<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");	
$cont_v = $class->limpiar_cadena($_POST["cont_v"]);
$cont_n1 = $class->limpiar_cadena($_POST["cont_n1"]);
$cont_n2 = $class->limpiar_cadena($_POST["cont_n2"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->cam_cont_perfil($cont_v, $cont_n1, $cont_n2);
	echo $result;
?>