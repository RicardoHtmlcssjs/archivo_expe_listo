<?php
require_once('adodb5/adodb.inc.php');
include("config.php");

class Conexion{
	public $host = HOST;
	public $port = PORT;
	public $dbname = DBNAME;
	public $dbname2 = DBNAME2;
	public $user = USER;
	public $pass = PASS;
	public $driver = DRIVER;
	public $conn = "";
	public $conn2 = "";
	public $query = "";
	// public function __construct(){
	// 	$this->conecta();
	// }
	public function conecta(){
		// Crear una instancia de la clase ADOConnection
		$this->conn = NewADOConnection($this->driver);

		// Establecer los parámetros de la conexión
		$this->conn->Connect("host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->pass");

		// Verificar si la conexión fue exitosa
		if (!$this->conn) {
		    die('Error de conexión: ' . $conn->ErrorMsg());
		    // echo "No se conecto";    
		}else{
			// echo "Se conecto";
			return $this->conn;
		}
		// Cerrar la conexión a la base de datos
		$this->conn->Close();
	}
	public function conecta2(){
		// Crear una instancia de la clase ADOConnection
		$this->conn2 = NewADOConnection($this->driver);

		// Establecer los parámetros de la conexión
		$this->conn2->Connect("host=$this->host port=$this->port dbname=$this->dbname2 user=$this->user password=$this->pass");

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
		$this->conecta();
		if($tq == "s"){
		$this->query = $this->conn->execute($query);
		}
		return $this->query;
	}
	public function consulta2($tq, $query){
		$this->conecta2();
		if($tq == "s"){
		$this->query = $this->conn2->execute($query);
		}
		return $this->query;
	}
}

// $conexion = new Conexion();
?>