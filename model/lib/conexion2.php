<?php
require_once('adodb5/adodb.inc.php');
// include("config.php");

class Conexion2{
	public $host = HOST;
	public $user = USER;
	public $pass = PASS;
	public $driver = DRIVER;
	public $port2 = PORT2;
	public $dbname2 = DBNAME2;
	public $conn2 = "";
	public $query = "";
	public function __construct(){
		$this->conecta2();
	}
	// CONEXION A VSAIME
	public function conecta2(){
		// Crear una instancia de la clase ADOConnection
		$this->conn2 = NewADOConnection($this->driver);

		// Establecer los parámetros de la conexión
		$this->conn2->Connect("host=$this->host port=$this->port2 dbname=$this->dbname2 user=$this->user password=$this->pass");

		// Verificar si la conexión fue exitosa
		if (!$this->conn2) {
		    die('Error de conexión: ' . $conn2->ErrorMsg());
		    // echo "No se conecto";    
		}else{
			// echo "Se conecto";
			return $this->conn2;
		}
		// Cerrar la conexión a la base de datos
		$this->conn2->Close();
	}
	public function consulta($tq, $query){
		$this->conecta2();
		if($tq == "s"){
		$this->query = $this->conn2->execute($query);
		}
		return $this->query;
	}
}

// $conexion2 = new Conexion2();
?>