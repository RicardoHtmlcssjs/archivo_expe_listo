<?php
	include("../class_usuario_model.php");
	include("../class_limpiar_cadena.php");
	$cor = $class->limpiar_cadena($_POST["cor"]);
	$id_u = $class->limpiar_cadena($_POST["id_u"]);
	$act = $class->limpiar_cadena($_POST["act"]);
	$adm = $class->limpiar_cadena($_POST["adm"]);
	$cl_usuario = new Usuario("","");
	$result = $cl_usuario->actualizar_usu_adm($id_u, $act, $adm, $cor);
	echo $result;
?>