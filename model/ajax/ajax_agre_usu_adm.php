<?php
include("../class_usuario_model.php");
include("../class_limpiar_cadena.php");	
	$ci = $class->limpiar_cadena($_POST["ci"]);
	$nom = $class->limpiar_cadena($_POST["nom"]);
	$corr = $class->limpiar_cadena($_POST["corr"]);
	$act = $class->limpiar_cadena($_POST["act"]);
	$adm = $class->limpiar_cadena($_POST["adm"]);
	$piso = $class->limpiar_cadena($_POST["piso"]);
	$unidad = $class->limpiar_cadena($_POST["unidad"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->agre_usu_adm($ci, $nom, $act, $adm, $corr, $piso, $unidad);
	echo $result;
?>