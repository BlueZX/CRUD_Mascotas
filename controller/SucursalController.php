<?php 
require_once('model/SucursalModel.php');
require_once('model/CiudadModel.php');


class SucursalController{

	function list(){
		$this->nav();
		$sucursal = new SucursalModel();

    $aux = '';
		$rows = $sucursal->getList();
    $aux .= "</h1><h2>Sucursales</h2><a class=\"btn btn-success\" href=\"?c=Sucursal&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>id</th><th>Nombre</th><th>Telefono</th><th>Numero de empleados</th><th>Calle</th><th>Numero de Casa</th><th>Ciudad</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $sucursal->$campo = $valor;

        if($campo == 'ciudad_id'){
          $ciudad = new CiudadModel();
          $ciudad->get($sucursal->ciudad_id);
          $aux .= "\t\t<td>". $ciudad->descripcion . "</td>\n";
        }
        else{
          $aux .= "\t\t<td>". $sucursal->$campo . "</td>\n";
        }
    }

      $aux .= "\t<td><a href=\"?c=Sucursal&a=editform&id=" . $sucursal->id . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=Sucursal&a=delete&id=" . $sucursal->id . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
    }
    $aux .= "</tbody></table>\n";
    echo $aux;
		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();

    $ciudad = new CiudadModel();

    $aux = '';
    $rows = $ciudad->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Ciudad:</label>
          <div class="col-sm-10">
            <select class="form-control" name="ciudad_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $ciudad->$campo = $valor;
        if($campo == 'id'){
          $aux .= '<option value="' . $ciudad->$campo . '">';
        }
        if($campo == 'descripcion'){
          $aux .= $ciudad->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

    echo ' > Agregar</h1><h2>Agregar Sucursal:</h2>
      <form class="form-horizontal" action="?c=Sucursal&a=add" method="post">
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
            Nombre:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="nombre" placeholder="Nombre"
            >
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">
            Numero de telefono:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="telefono" placeholder="Numero de telefono" onkeypress="return valida(event)"
            >
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">
            Numero de empleados:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="n_empleados" placeholder="Numero de empleados" onkeypress="return valida(event)"
            >
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">
            Calle:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="calle" placeholder="Calle"
            >
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">
            Numero de casa:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="numero" placeholder="Numero de casa" onkeypress="return valida(event)"
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
    $sucursal = new SucursalModel();
    $sucursal->get($_GET['id']);

    $ciudad = new CiudadModel();

    $auxr = '';
    $rows = $ciudad->getList();
    $auxr .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Ciudad:</label>
          <div class="col-sm-10">
            <select class="form-control" name="ciudad_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $ciudad->$campo = $valor;
        if($campo == 'id'){
          if($ciudad->$campo == $sucursal->ciudad_id){
             $auxr .= '<option value="' . $ciudad->$campo . '" selected >';
          }
          else{
            $auxr .= '<option value="' . $ciudad->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $auxr .= $ciudad->$campo . '</option>';
        }

      }

    }

    $auxr .= '</select></div></div>';

    $aux = ' > Editar</h1><h2>Editar Sucursal:</h2>
      <form class="form-horizontal" action="?c=Sucursal&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" value="' . $sucursal->id . '"  readonly="readonly" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Nombre:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="nombre" placeholder="Nombre" value="' . $sucursal->nombre . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Telefono:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="telefono" placeholder="Numero de telefono" value="' . $sucursal->telefono . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Numero de empleados:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="n_empleados" placeholder="Numero de empleados" value="' . $sucursal->n_empleados . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Calle:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="calle" placeholder="Calle" value="' . $sucursal->calle . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Numero de casa:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="numero" placeholder="Numero de casa" value="' . $sucursal->numero . '" onkeypress="return valida(event)"
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
      $sucursal = new SucursalModel();
      $sucursal->edit($_POST);
      $this->list();
      echo $sucursal->msj;
    }
  }

  function add(){
    if(isset($_POST['id'])){
      $sucursal = new SucursalModel();
      $sucursal->set($_POST);
    }
    $this->list();
    echo $sucursal->msj;
  }

  function delete(){
    if(!empty($_GET['id'])){
      
      $sucursal = new SucursalModel();
      $sucursal->delete($_GET['id']);
      $this->list();
      echo $sucursal->msj;
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
              <a class="nav-link active" href="?c=Sucursal&a=list">Sucursal</a>
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