<?php 
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class CategoriaModel extends DBAbstractModel{
	public $descripcion;
	public $id;

	# Traer datos de una mascota
	public function get($iid=''){
		if($iid != '') {
			$this->query = "
			SELECT *
			FROM categoria
			WHERE id = '$iid'
			";
			$this->getResultQuery();
		}
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $campo=>$valor) {
				$this->$campo = $valor;
			}

			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> categoria encontrada.
						  </div>';

		}
		else{
			$this->msj = '<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>A ocurrido un error!</strong> no se encuentra la categoria.
</div>';
		}
	}
	# Traer Lista
	public function getList(){
		$this->query = "
		SELECT *
		FROM categoria
		ORDER BY id ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> categoria encontrada.
						  </div>';
			return $this->rows;
		}
		else{
			$this->msj = '<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>A ocurrido un error!</strong> no se encuentra la categoria.
</div>';
		}
		return array();
	}

	public function set($data=array()){
		if($data['id']!=null){
			$this->get($data['id']);
			if($data['id'] != $this->id) {
				foreach ($data as $campo=>$valor) {
					$$campo = $valor;
				}

				$this->query = "
				INSERT INTO categoria
				(id, descripcion)
				VALUES
				('$id', '$descripcion')
				";
				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> categoria agregada.
						  </div>';
				$this->executeSQuery();
			}
			else{
				$this->msj = '<div class="alert alert-warning">
  <strong>Peligro!</strong> la categoria que desea agregar ya existe.
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
		UPDATE categoria
		SET descripcion='$descripcion'
		WHERE id = '$id'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> categoria modificada.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una mascota
	public function delete($iid='') {
		$this->query = "
		DELETE FROM categoria
		WHERE id = '$iid'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> categoria eliminada.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}
}
?>