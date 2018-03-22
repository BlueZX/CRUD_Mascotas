<?php
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class BMascotaModel extends DBAbstractModel {

	public $id;
	public $fecha_venta;
	public $monto_neto;
	public $iva;
	public $total;
	public $cliente_rut;
	public $empleado_rut;

	# Traer datos de una boleta_mascota
	public function get($iid=''){
		if($iid != '') {
			$this->query = "
			SELECT *
			FROM boleta_mascota
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
  							<strong>Realizado!</strong> Boleta Mascota encontrada.
						  </div>';

		}
		else{
			$this->msj = '<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>A ocurrido un error!</strong> no se encuentra la boleta_mascota.
</div>';
		}
	}
	# Traer Lista
	public function getList(){
		$this->query = "
		SELECT *
		FROM boleta_mascota
		ORDER BY id ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = '<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <strong>Realizado!</strong> Boleta Mascota(s) encontrada(s).
</div>';
			return $this->rows;
		}
		else{
			$this->msj = '<div class="alert alert-danger">
  <strong>A ocurrido un error!</strong> no existe ninguna columna de la tabla boleta_mascota.
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
				INSERT INTO boleta_mascota
				(id, fecha_venta, monto_neto, iva, total, cliente_rut, empleado_rut)
				VALUES
				('$id', '$fecha_venta', '$monto_neto', '$iva', '$total', '$cliente_rut', '$empleado_rut')
				";

				$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Boleta Mascota Agregada.
						  </div>';
				$this->executeSQuery();
			}
			else{
				$this->msj = '<div class="alert alert-warning">
  <strong>Peligro!</strong> La boleta_mascota que desea agregar ya existe.
</div>';
			}
		}
		else{
			$this->msj = '<div class="alert alert-danger">
  <strong>A ocurrido un error!</strong> lorem ipsum.
</div>';
		}
	}
	# Modificar una boleta_mascota
	public function edit($data=array()) {
		foreach ($data as $campo=>$valor) {
			$$campo = $valor;
		}


		$this->query = "
		UPDATE boleta_mascota
		SET fecha_venta='$fecha_venta',
		monto_neto='$monto_neto',
		iva='$iva', 
		total='$total',
		cliente_rut='$cliente_rut',
		empleado_rut='$empleado_rut'
		WHERE id = '$id'
		";
		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Boleta Mascota modificada.
						  </div>';
		$this->executeSQuery();
	}
	# Eliminar una boleta_mascota
	public function delete($iid='') {
		$this->query = "
		DELETE FROM boleta_mascota
		WHERE id = '$iid'
		";
		$this->msj = '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  							<strong>Realizado!</strong> Boleta Mascota eliminada.
						  </div>';
		$this->executeSQuery();
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}

}
?>
