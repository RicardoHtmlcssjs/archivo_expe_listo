<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");	
	$id_u = $class->limpiar_cadena($_POST["id_u"]);
	$usu = $class->limpiar_cadena($_POST["usu"]);
	$nom = $class->limpiar_cadena($_POST["nom"]);
	$act = $class->limpiar_cadena($_POST["act"]);
	$ci = $class->limpiar_cadena($_POST["ci"]);
	$adm = $class->limpiar_cadena($_POST["adm"]);
	$cor = $class->limpiar_cadena($_POST["cor"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->actualizar_usu_adm($id_u, $usu, $nom, $act, $ci, $adm, $cor);
	echo $result;
?>