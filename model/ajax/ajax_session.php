<?php
	session_start();
	if(isset($_SESSION["id_usu_log"]) && isset($_SESSION["admin_usu_p"])){
		if($_SESSION["admin_usu_p"] == 1){
			$result = 1;
		}else{
			$result = 1.1;
		}
	}else{
		$result = 0;
	}
	echo $result;
?>