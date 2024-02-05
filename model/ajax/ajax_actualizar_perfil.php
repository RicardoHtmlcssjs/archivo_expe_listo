<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");
$nom = $class->limpiar_cadena($_POST["nom"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->actualizar_perfil($nom);
	echo $result;
?>