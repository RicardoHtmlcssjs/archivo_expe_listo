<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");	
	$usu = $class->limpiar_cadena($_POST["usu"]);
	$nom = $class->limpiar_cadena($_POST["nom"]);
	$corr = $class->limpiar_cadena($_POST["corr"]);
	$act = $class->limpiar_cadena($_POST["act"]);
	$adm = $class->limpiar_cadena($_POST["adm"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->agre_usu_adm($usu, $nom, $act, $adm, $corr);
	echo $result;
?>