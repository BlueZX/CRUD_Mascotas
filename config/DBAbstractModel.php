<?php 
abstract class DBAbstractModel{

	private static $db_host = 'localhost';
	private static $db_port = '5432';
	private static $db_user = 'postgres';
	private static $db_pass = 'postgres';
	protected $db_name = 'Mascotas';
	protected $query;
	protected $rows = array();
	private $conn;
	public $msj = 'Realizado';

	abstract protected function get();
	abstract protected function set();
	abstract protected function edit();
	abstract protected function delete();

	//Conectarse a la bd
	private function openConnection(){
		$this->conn = pg_connect("host=" . self::$db_host . " port=" . self::$db_port . " dbname=" . $this->db_name . " user=" . self::$db_user . " password=" . self::$db_pass)
    or die('No se ha podido conectar: ' . pg_last_error());
	}

	//Desconectar la base de datos
	private function closeConnection(){
		pg_close($this->conn);
	}

	//ejecutar query simple C U D
	protected function executeSQuery(){
		if($_POST || $_GET){
			$this->openConnection();
			pg_query($this->conn, $this->query) or $this->msj ='<div class="alert alert-danger">
  <strong>La consulta fallo! </strong>' . pg_last_error() . '</div>';
			$this->closeConnection();
		}
		else{
			$this->msj = 'Metodo no permitido';
		}
	}

	//traer resultados de una query
	protected function getResultQuery(){
		$this->openConnection();
		$result = pg_query($this->conn, $this->query) or $this->msj ='<div class="alert alert-danger">
  <strong>La consulta fallo! </strong> ' . pg_last_error() . '</div>';
		while($this->rows[] = pg_fetch_array($result, null, PGSQL_ASSOC));
		pg_free_result($result);
		$this->closeConnection();
		array_pop($this->rows);
	}

	//traer resultados de una query con valores repetidos
	protected function getResultQueryRepeat(){
		$this->openConnection();
		$result = pg_query($this->conn, $this->query) or $this->msj ='<div class="alert alert-danger">
  <strong>La consulta fallo! </strong> ' . pg_last_error() . '</div>';
		while($this->rows[] = pg_fetch_array($result, null, PGSQL_NUM));
		pg_free_result($result);
		$this->closeConnection();
		array_pop($this->rows);
	}
}
?>