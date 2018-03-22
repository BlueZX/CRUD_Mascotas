<?php
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class MascotaModel extends DBAbstractModel {

	public $tamano;
	public $precio_venta;
	public $color_predominante;
	public $raza_id;
	public $tipo_mascota_id;
	public $sucursal_id;
	public $id;

	# Traer datos de una mascota
	public function get($iid=''){
		if($iid != '') {
			$this->query = "
			SELECT *
			FROM mascota
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
  							<strong>Realizado!</strong> Mascota encontrada.
						  </div>';

		}
		else{
			$this->msj = '<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>A ocurrido un error!</strong> no se encuentra la mascota.
</div>';
		}
	}
	# Traer Lista
	public function getList(){
		$this->query = "
		SELECT *
		FROM mascota
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
				INSERT INTO mascota
				(id, tamano, precio_venta, color_predominante, raza_id, tipo_mascota_id, sucursal_id)
				VALUES
				('$id', '$tamano', '$precio_venta', '$color_predominante', '$raza_id', '$tipo_mascota_id', '$sucursal_id')
				";
				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Mascota agregada exitosamente.
						  </div>';
				$this->executeSQuery();
			}
			else{
				$this->msj = '<div class="alert alert-warning">
  <strong>Peligro!</strong> La mascota que desea agregar ya existe.
</div>';
			}
		}
		else{
			$this->msj = '<div class="alert alert-danger">
  <strong>A ocurrido un error!</strong> no existe ninguna columna de la tabla cliente.
</div>';
		}
	}
	# Modificar una mascota
	public function edit($data=array()) {
		foreach ($data as $campo=>$valor) {
			$$campo = $valor;
		}


		$this->query = "
		UPDATE mascota
		SET tamano='$tamano',
		precio_venta='$precio_venta',
		color_predominante='$color_predominante', 
		raza_id='$raza_id',
		tipo_mascota_id='$tipo_mascota_id',
		sucursal_id='$sucursal_id'
		WHERE id = '$id'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Mascota modificada exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una mascota
	public function delete($iid='') {
		$this->query = "
		DELETE FROM mascota
		WHERE id = '$iid'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Mascota eliminada exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}

}
?>
