<?php 
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class DetalleMModel extends DBAbstractModel{
	public $accesorio_id;
	public $boleta_a_id;

	# Traer datos de una mascota
	public function get($ai='',$bi=''){
		if($ai != '' && $bi != '') {
			$this->query = "
			SELECT *
			FROM DetalleM
			WHERE mascota_id = '$ai' AND boleta_m_id= '$bi'
			";
			$this->getResultQuery();
		}
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $campo=>$valor) {
				$this->$campo = $valor;
			}

			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Mascota encontrado.
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
		FROM DetalleM
		ORDER BY mascota_id ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Mascota encontrado.
						  </div>';
			return $this->rows;
		}
		else{
			$this->msj = 'DetalleA no encontrada';
		}
		return array();
	}

	public function set($data=array()){
		if($data['mascota_id']!=null && $data['boleta_m_id']!=null){
			$this->get($data['mascota_id']);
			$this->get($data['boleta_m_id']);
			if(($data['mascota_id'] != $this->mascota_id) && ($data['boleta_m_id'] != $this->boleta_m_id)) {
				foreach ($data as $campo=>$valor) {
					$$campo = $valor;
				}

				$this->query = "
				INSERT INTO DetalleM
				(mascota_id, boleta_m_id)
				VALUES
				('$mascota_id', '$boleta_m_id')
				";
				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Mascota Agreagadp exitosamente.
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
		UPDATE DetalleM
		SET mascota_id='$mascota_id'
		WHERE boleta_m_id = '$boleta_m_id'
		";
		$this->executeSQuery();

		$this->query = "
		UPDATE DetalleM
		SET boleta_m_id='$boleta_m_id'
		WHERE mascota_id = '$mascota_id'
		";
		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Mascota Modificado exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una mascota
	public function delete($ida='',$idba='') {
		$this->query = "
		DELETE FROM DetalleM
		WHERE mascota_id = '$ida' AND boleta_m_id = '$idba'
		";

		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Detalle Mascota Eliminado exitosamente.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}
}
?>