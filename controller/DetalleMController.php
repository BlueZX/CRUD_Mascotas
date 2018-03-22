<?php 
require_once('model/DetalleMModel.php');
require_once('model/MascotaModel.php');
require_once('model/BMascotaModel.php');

class DetalleMController{

	function list(){
		$this->nav();
		$detalleA = new DetalleMModel();

    $aux = '';
		$rows = $detalleA->getList();
    $aux .= "</h1><h2>Detalle Mascota</h2><a class=\"btn btn-success\" href=\"?c=DetalleM&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>Mascota</th><th>Boleta accesorio</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $detalleA->$campo = $valor;
        $aux .= "\t\t<td>". $detalleA->$campo . "</td>\n";
        }
    $aux .= "\t<td><a href=\"?c=DetalleM&a=delete&id_a=" . $detalleA->mascota_id ."&id_ba=" . $detalleA->boleta_m_id . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
    }
    $aux .= "</tbody></table>\n";
    echo $aux;
		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();

    $accesorio = new MascotaModel();

    $aux = '';
    $rows = $accesorio->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Mascota:</label>
          <div class="col-sm-10">
            <select class="form-control" name="mascota_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $accesorio->$campo = $valor;
        if($campo == 'id'){
          $aux .= '<option value="' . $accesorio->$campo . '">' . $accesorio->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

    $ba = new BMascotaModel();

    $auxb = '';
    $rows = $ba->getList();
    $auxb .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Boleta accesorio codigo:</label>
          <div class="col-sm-10">
            <select class="form-control" name="boleta_m_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $ba->$campo = $valor;
        if($campo == 'id'){
          $auxb .= '<option value="' . $ba->$campo . '">' . $ba->$campo . '</option>';
        }

      }

    }

    $auxb .= '</select></div></div>';

    echo ' > Agregar</h1><h2>Agregar Detalle Mascota:</h2>
      <form class="form-horizontal" action="?c=DetalleM&a=add" method="post">
        <div class="form-group">
        ' . $aux .'
        </div>
        <div class="form-group">
        ' . $auxb . '
        </div>
        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();
    $detalleA = new DetalleMModel();
    $detalleA->get($_GET['id_a'],$_GET['id_ba']);

    $accesorio = new MascotaModel();

    $aux = '';
    $rows = $accesorio->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Mascota:</label>
          <div class="col-sm-10">
            <select class="form-control" name="mascota_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $accesorio->$campo = $valor;
        if($campo == 'id'){
          if($accesorio->$campo == $detalleA->accesorio_id){
             $aux .= '<option value="' . $accesorio->$campo . '" selected >';
          }
          else{
            $aux .= '<option value="' . $accesorio->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $aux .= $accesorio->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

    $ba = new BMascotaModel();

    $auxb = '';
    $rows = $ba->getList();
    $auxb .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Boleta accesorio codigo:</label>
          <div class="col-sm-10">
            <select class="form-control" name="boleta_m_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $ba->$campo = $valor;
        if($campo == 'id'){
          
          if($ba->$campo == $detalleA->boleta_a_id){
            $auxb .= '<option value="' . $ba->$campo . '" selected >' . $ba->$campo . '</option>';
          }
          else{
            $auxb .= '<option value="' . $ba->$campo . '">' . $ba->$campo . '</option>';
          }
        }

      }

    }

    $auxb .= '</select></div></div>';

    $aux = ' > Editar</h1><h2>Editar DetalleM:</h2>
      <form class="form-horizontal" action="?c=DetalleM&a=edit" method="post">
        <div class="form-group">
        ' . $aux .'
        </div>
        <div class="form-group">
        ' . $auxb . '
        </div>
        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';


      echo $aux;
  }

  function edit(){
    if(isset($_POST['mascota_id'])){
      $detalleA = new DetalleMModel();
      $detalleA->edit($_POST);
      $this->list();
      echo $detalleA->msj;
    }
  }

  function add(){
    if(isset($_POST['mascota_id'])){
      $detalleA = new DetalleMModel();
      $detalleA->set($_POST);
      $this->list();
    echo $detalleA->msj;
    }
  }

  function delete(){
    if(!empty($_GET['id_a']) && !empty($_GET['id_ba'])){
      
      $detalleA = new DetalleMModel();
      $detalleA->delete($_GET['id_a'],$_GET['id_ba']);
      $this->list();
      echo $detalleA->msj;
    }

  }

	function nav(){
		echo '<nav class="col-sm-3 col-md-2 d-none d-sm-block sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link"  href="?c=Index&a=index">Inicio</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=Mascota&a=list">Mascotas<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=Raza&a=list">Razas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=TipoMascota&a=list">Tipo mascota</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=Accesorio&a=list">Accesorios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=Categoria&a=list">Categorias</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=BAccesorio&a=list">Boletas Accesorios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=BMascota&a=list">Boletas Mascotas</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=DetalleA&a=list">Detalle Accesorios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active " href="?c=DetalleM&a=list">Detalle Mascotas</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=Cliente&a=list">Clientes</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=Empleado&a=list">Empleados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=Puesto&a=list">Puestos</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=Sucursal&a=list">Sucursal</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=Ciudad&a=list">Ciudades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=Region&a=list">Regiones</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?c=E2&a=list">Consultas Entrega II</a>
            </li>
          </ul>

        </nav>
       

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <h1>Inicio > Mascotas
          ';

	}
} ?>