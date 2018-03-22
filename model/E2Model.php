<?php 
# Importar modelo de abstracción de base de datos
require_once('config/DBAbstractModel.php');
class E2Model extends DBAbstractModel{
	public $descripcion;
	public $id;

	# Traer datos de una mascota
	public function q1(){
		$this->query = "
		SELECT c.rut,c.nombre,m.id,m.color_predominante
		FROM cliente c, mascota m, raza r, boleta_mascota bm, detalleM dm, tipo_mascota tm
		WHERE dm.mascota_id = m.id AND m.raza_id = r.id AND c.rut = bm.cliente_rut AND dm.boleta_m_id = bm.id AND tm.descripcion='domestico' AND r.descripcion='labrador' AND c.rut NOT IN (
      		SELECT cl.rut
      		FROM cliente cl, mascota ma, raza ra, boleta_mascota bom, detalleM dem
      		WHERE cl.rut = bom.cliente_rut AND ma.id = dem.mascota_id AND bom.id = dem.boleta_m_id AND ra.id = ma.raza_id AND ra.descripcion='chiguagua'
      	);";

		$this->getResultQuery();

		if(count($this->rows) >= 1){
			$this->msj = 'consulta realizada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
		}
		return array();
	}

	public function q2(){
		$this->query = "
		SELECT DISTINCT s.id, s.nombre, t.id, t.descripcion, count(*)
		FROM mascota m, sucursal s, tipo_mascota t, detalleM d
		WHERE t.id = m.tipo_mascota_id AND m.id = d.boleta_m_id AND s.id = m.sucursal_id
		GROUP BY s.id, s.nombre, t.id, t.descripcion
		";

		$this->getResultQueryRepeat();

		if(count($this->rows) >= 1){
			$this->msj = 'consulta realizada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
		}
		return array();
	}

	public function q3(){
		$this->query = "
		SELECT s.id, s.nombre, s.n_empleados
		FROM sucursal s, mascota m, tipo_mascota t, detalleM d, boleta_mascota b
		WHERE s.id = m.sucursal_id AND t.id = m.tipo_mascota_id AND m.id = d.mascota_id AND b.id = d.boleta_m_id AND s.n_empleados>9 AND t.descripcion='salvaje' AND b.fecha_venta>='01/01/2016' AND b.fecha_venta<='01/01/2017' 
		";

		$this->getResultQueryRepeat();

		if(count($this->rows) >= 1){
			$this->msj = 'consulta realizada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
		}
		return array();
	}

	public function q4(){
		$this->query = "
		SELECT a.id, a.descripcion, c.descripcion
		FROM accesorio a, categoria c, cantidad_a ca
		WHERE c.id = ca.id AND c.id = a.id AND ca.total = (SELECT max(total) FROM cantidad_a);


		";

		$this->getResultQueryRepeat();

		if(count($this->rows) >= 1){
			$this->msj = 'consulta realizada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
		}
		return array();
	}

	public function q5(){
		$this->query = "
		SELECT cr.region_id, r.descripcion
		FROM raza r, cantidad_r cr, max_r mr
		WHERE mr.id = cr.region_id AND cr.raza_id = r.id AND mr.total = cr.cantidad 
		";

		$this->getResultQueryRepeat();

		if(count($this->rows) >= 1){
			$this->msj = 'consulta realizada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
		}
		return array();
	}

	public function q6(){
		$this->query = "
		SELECT DISTINCT b.id, c.rut,c.nombre, e.rut, e.nombre, t.descripcion, r.descripcion, b.total, b.fecha_venta, ci.descripcion, s.nombre
		FROM mascota m, raza r, sucursal s, boleta_mascota b, cliente c, detalleM d, empleado e, tipo_mascota t, ciudad ci
		WHERE m.raza_id = r.id AND m.tipo_mascota_id = t.id AND m.sucursal_id = s.id AND s.ciudad_id = ci.id AND b.cliente_rut = c.rut AND b.empleado_rut = e.rut AND d.mascota_id = m.id AND d.boleta_m_id = b.id
		";

		$this->getResultQueryRepeat();

		if(count($this->rows) >= 1){
			$this->msj = 'consulta realizada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
		}
		return array();
	}

	# Traer Lista
	public function get(){
		$this->query = "
		SELECT *
		FROM raza
		ORDER BY id ASC";

		$this->getResultQuery();

		$aux = "";
		if(count($this->rows) >= 1){
			$this->msj = 'Mascota encontrada';
			return $this->rows;
		}
		else{
			$this->msj = 'Mascota no encontrada';
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
				INSERT INTO raza
				(id, descripcion)
				VALUES
				('$id', '$descripcion')
				";
				$this->executeSQuery();
				$this->msj = 'Mascota agregado exitosamente';
			}
			else{
				$this->msj = 'La Mascota ya existe';
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
		UPDATE raza
		SET descripcion='$descripcion'
		WHERE id = '$id'
		";
		$this->executeSQuery();
		$this->msj = 'Raza modificada';
	}
	# Eliminar una mascota
	public function delete($iid='') {
		$this->query = "
		DELETE FROM raza
		WHERE id = '$iid'
		";
		$this->executeSQuery();
		$this->msj = 'Raza eliminada';
	}
	# Método constructor
	function __construct() {
		$this->db_name = 'Mascotas';
	}
}
?>