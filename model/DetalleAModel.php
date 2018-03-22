<?php 
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class DetalleAModel extends DBAbstractModel{
	public $accesorio_id;
	public $boleta_a_id;

	# Traer datos de una mascota
	public function get($ai='',$bi=''){
		if($ai != '' && $bi != '') {
			$this->query = "
			SELECT *
			FROM DetalleA
			WHERE accesorio_id = '$ai' AND boleta_a_id= '$bi'
			";
			$this->getResultQuery();
		}
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $campo=>$valor) {
				$this->$campo = $valor;
			}

			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Accesorio encontrado.
						  </div>';

		}
		else{
			$this->msj = 'DetalleA no encontrada';
		}
	}
	# Traer Lista
	public function getList(){
		$this->query = "
		SELECT *
		FROM DetalleA
		ORDER BY accesorio_id ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Accesorio encontrado.
						  </div>';
			return $this->rows;
		}
		else{
			$this->msj = 'DetalleA no encontrada';
		}
		return array();
	}

	public function set($data=array()){
		if($data['accesorio_id']!=null && $data['boleta_a_id']!=null){
			$this->get($data['accesorio_id']);
			$this->get($data['boleta_a_id']);
			if(($data['accesorio_id'] != $this->accesorio_id) && ($data['boleta_a_id'] != $this->boleta_a_id)) {
				foreach ($data as $campo=>$valor) {
					$$campo = $valor;
				}

				$this->query = "
				INSERT INTO DetalleA
				(accesorio_id, boleta_a_id)
				VALUES
				('$accesorio_id', '$boleta_a_id')
				";
				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Accesorio Agreagadp exitosamente.
						  </div>';
				$this->executeSQuery();
			}
			else{
				$this->msj = 'La DetalleA ya existe';
			}
		}
		else{
			$this->msj = 'No se ha agregado a la mascota';
		}
	}
	# Modificar una mascota
	public function edit($data=array()) {
		foreach ($data as $campo=>$valor) {
			$$campo = $valor;
		}


		$this->query = "
		UPDATE DetalleA
		SET accesorio_id='$accesorio_id'
		WHERE boleta_a_id = '$boleta_a_id'
		";
		$this->executeSQuery();

		$this->query = "
		UPDATE DetalleA
		SET boleta_a_id='$boleta_a_id'
		WHERE accesorio_id = '$accesorio_id'
		";
		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Accesorio Modificado exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una mascota
	public function delete($ida='',$idba='') {
		$this->query = "
		DELETE FROM DetalleA
		WHERE accesorio_id = '$ida' AND boleta_a_id = '$idba'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Accesorio Eliminado exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}
}
?>