<?php
	$foto = $_FILES["parametros"];
	foreach ($foto as $key => $value) {
		echo $key. ' ' .$value. '->';
	}
?>
