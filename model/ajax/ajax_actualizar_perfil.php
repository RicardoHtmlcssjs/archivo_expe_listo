<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");
$usu = $class->limpiar_cadena($_POST["usu"]);
$nom = $class->limpiar_cadena($_POST["nom"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->actualizar_perfil($usu, $nom);
	echo $result;
?>