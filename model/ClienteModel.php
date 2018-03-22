<?php
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class ClienteModel extends DBAbstractModel {

	public $rut;
	public $nombre;
	public $telefono;
	public $calle;
	public $numero;
	public $ciudad_id;

	# Traer datos de una mascota
	public function get($iid=''){
		if($iid != '') {
			$this->query = "
			SELECT *
			FROM cliente
			WHERE rut = '$iid'
			";
			$this->getResultQuery();
		}
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $campo=>$valor) {
				$this->$campo = $valor;
			}

			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> cliente encontrado.
						  </div>';

		}
		else{
			$this->msj = '<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>A ocurrido un error!</strong> no se encuentra el cliente.
</div>';
		}
	}
	# Traer Lista
	public function getList(){
		$this->query = "
		SELECT *
		FROM cliente
		ORDER BY rut ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = '<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <strong>Realizado!</strong> cliente(s) encontrado(s).
</div>';
			return $this->rows;
		}
		else{
			$this->msj = '<div class="alert alert-danger">
  <strong>A ocurrido un error!</strong> no existe ninguna columna de la tabla cliente.
</div>';
		}
		return array();
	}

	public function set($data=array()){
		if($data['rut']!=null){
			$this->get($data['rut']);
			if($data['rut'] != $this->rut) {
				foreach ($data as $campo=>$valor) {
					$$campo = $valor;
				}

				$this->query = "
				INSERT INTO cliente
				(rut, nombre, telefono, calle, numero, ciudad_id)
				VALUES
				('$rut', '$nombre', '$telefono', '$calle', '$numero', '$ciudad_id')
				";

				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Cliente agregado exitosamente.
						  </div>';
				$this->executeSQuery();
			}
			else{
				$this->msj = '<div class="alert alert-warning">
  <strong>Peligro!</strong> el cliente que desea agregar ya existe.
</div>';
			}
		}
		else{
			$this->msj = '<div class="alert alert-danger">
  <strong>No se a podido agregar!</strong> has dejado un valor en blanco.
</div>';
		}
	}
	# Modificar una mascota
	public function edit($data=array()) {
		foreach ($data as $campo=>$valor) {
			$$campo = $valor;
		}


		$this->query = "
		UPDATE cliente
		SET nombre='$nombre',
		telefono='$telefono',
		calle='$calle', 
		numero='$numero',
		ciudad_id='$ciudad_id'
		WHERE rut = '$rut'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Cliente modificado exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una mascota
	public function delete($iid='') {
		$this->query = "
		DELETE FROM cliente
		WHERE rut = '$iid'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Cliente eliminado exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}

}
?>
