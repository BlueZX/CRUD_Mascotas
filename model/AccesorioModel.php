<?php
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class AccesorioModel extends DBAbstractModel {

	public $descripcion;
	public $precio_venta;
	public $categoria_id;
	public $sucursal_id;
	public $id;

	# Traer datos de una mascota
	public function get($iid=''){
		if($iid != '') {
			$this->query = "
			SELECT *
			FROM accesorio
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
  							<strong>Realizado!</strong> Accesorio encontrado.
						  </div>';

		}
		else{
			$this->msj = '<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>A ocurrido un error!</strong> no se encuentra el accesorio.
</div>';
		}
	}
	# Traer Lista
	public function getList(){
		$this->query = "
		SELECT *
		FROM accesorio
		ORDER BY id ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = '<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <strong>Realizado!</strong> Mascota(s) encontrada(s).
</div>';
			return $this->rows;
		}
		else{
			$this->msj = '<div class="alert alert-danger">
  <strong>A ocurrido un error!</strong> no existe ninguna columna de la tabla mascota.
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
				INSERT INTO accesorio
				(id, descripcion, precio_venta, categoria_id, sucursal_id)
				VALUES
				('$id', '$descripcion', '$precio_venta', '$categoria_id', '$sucursal_id')
				";
				
				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Accesorio agregado.
						  </div>';
				$this->executeSQuery();
			}
			else{
				$this->msj = '<div class="alert alert-warning">
  <strong>Peligro!</strong> El accesorio que desea agregar ya existe.
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
		UPDATE accesorio
		SET descripcion='$descripcion',
		precio_venta='$precio_venta',
		categoria_id='$categoria_id',
		sucursal_id='$sucursal_id'
		WHERE id = '$id'
		";
		
		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Accesorio modificado.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una mascota
	public function delete($iid='') {
		$this->query = "
		DELETE FROM accesorio
		WHERE id = '$iid'
		";
		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Accesorio Eliminado.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}

}
?>
