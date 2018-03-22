<?php 
require_once('model/CiudadModel.php');
require_once('model/RegionModel.php');


class CiudadController{

	function list(){
		$this->nav();
		$ciudad = new CiudadModel();

    $aux = '';
		$rows = $ciudad->getList();
    $aux .= "</h1><h2>Ciudad</h2><a class=\"btn btn-success\" href=\"?c=Ciudad&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>id</th><th>descripcion</th><th>Region</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $ciudad->$campo = $valor;

        if($campo == 'region_id'){
          $region = new RegionModel();
          $region->get($ciudad->region_id);
          $aux .= "\t\t<td>". $region->descripcion . "</td>\n";
        }
        else{
          $aux .= "\t\t<td>". $ciudad->$campo . "</td>\n";
        }
    }

      $aux .= "\t<td><a href=\"?c=Ciudad&a=editform&id=" . $ciudad->id . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=Ciudad&a=delete&id=" . $ciudad->id . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
    }
    $aux .= "</tbody></table>\n";
    echo $aux;
		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();

    $region = new RegionModel();

    $aux = '';
    $rows = $region->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Region:</label>
          <div class="col-sm-10">
            <select class="form-control" name="region_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $region->$campo = $valor;
        if($campo == 'id'){
          $aux .= '<option value="' . $region->$campo . '">';
        }
        if($campo == 'descripcion'){
          $aux .= $region->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

    echo ' > Agregar</h1><h2>Agregar Ciudad:</h2>
      <form class="form-horizontal" action="?c=Ciudad&a=add" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="identificacion" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Descripcion:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="descripcion" placeholder="Descripcion"
            >
          </div>
        </div>

        ' . $aux . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();
    $ciudad = new CiudadModel();
    $ciudad->get($_GET['id']);

    $region = new RegionModel();

    $auxr = '';
    $rows = $region->getList();
    $auxr .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Region:</label>
          <div class="col-sm-10">
            <select class="form-control" name="region_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $region->$campo = $valor;
        if($campo == 'id'){
          if($region->$campo == $ciudad->region_id){
             $auxr .= '<option value="' . $region->$campo . '" selected >';
          }
          else{
            $auxr .= '<option value="' . $region->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $auxr .= $region->$campo . '</option>';
        }

      }

    }

    $auxr .= '</select></div></div>';

    $aux = ' > Editar</h1><h2>Editar Ciudad:</h2>
      <form class="form-horizontal" action="?c=Ciudad&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" value="' . $ciudad->id . '"  readonly="readonly"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Descripcion:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="descripcion" placeholder="Descripcion" value="' . $ciudad->descripcion . '"
            >
          </div>
        </div>

        ' . $auxr . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';


      echo $aux;
  }

  function edit(){
    if(isset($_POST['id'])){
      $ciudad = new CiudadModel();
      $ciudad->edit($_POST);
      $this->list();
      echo $ciudad->msj;
    }
  }

  function add(){
    if(isset($_POST['id'])){
      $ciudad = new CiudadModel();
      $ciudad->set($_POST);
    }
    $this->list();
    echo $ciudad->msj;
  }

  function delete(){
    if(!empty($_GET['id'])){
      
      $ciudad = new CiudadModel();
      $ciudad->delete($_GET['id']);
      $this->list();
      echo $ciudad->msj;
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
              <a class="nav-link" href="?c=DetalleM&a=list">Detalle Mascotas</a>
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
              <a class="nav-link active" href="?c=Ciudad&a=list">Ciudades</a>
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