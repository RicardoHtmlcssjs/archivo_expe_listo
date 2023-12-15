<?php
class Lim_cad{		
	public function limpiar_cadena($var){
		$var = trim($var);
		$var = stripslashes($var);
		$var = str_ireplace("<script>","", $var);
		$var = str_ireplace("</script>","", $var); 
		$var = str_ireplace("SELECT * FROM","", $var);
		$var = str_ireplace("DELETE FROM","", $var);
		$var = str_ireplace("INSERT INTO","", $var);
		$var = str_ireplace("TRUNCATE TABLE","", $var);
		$var = str_ireplace("DROP TABLE","", $var);
		$var = str_ireplace("DROP DATABASE","", $var);
		$var = str_ireplace("SHOW TABLE","", $var);
		$var = str_ireplace("SHOW DATATABLES","", $var);
		$var = str_ireplace("SELECT","", $var);
		$var = str_ireplace("DELETE","", $var);
		$var = str_ireplace("INSERT","", $var);
		$var = str_ireplace("<?php","", $var);
		$var = str_ireplace("?>","", $var);
		$var = str_ireplace("--","", $var);
		$var = str_ireplace("^","", $var);
		$var = str_ireplace("<","", $var);
		$var = str_ireplace(">","", $var);
		$var = str_ireplace("[","", $var);
		$var = str_ireplace("]","", $var);
		$var = str_ireplace("==","", $var);
		$var = str_ireplace("=","", $var);
		$var = str_ireplace(";","", $var);
		$var = str_ireplace("::","", $var);
		$var = str_ireplace("-","", $var);
		$var = str_ireplace("*","", $var);
		$var = str_ireplace("/","", $var);
		$var = str_ireplace("|","", $var);
		$var = str_ireplace("°","", $var);
		$var = str_ireplace("¬","", $var);
		$var = str_ireplace("","", $var);
		$var = str_ireplace("DROP TABLE","", $var);
		$var = str_ireplace("<script src","", $var);
		$var = str_ireplace("<script type=","", $var);
		$var = trim($var);
		$var = stripslashes($var);

		return $var;
	}
}
$class = new Lim_cad();
		
?>