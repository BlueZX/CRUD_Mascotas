<?php 
require_once('model/EmpleadoModel.php');
require_once('model/PuestoModel.php');
require_once('model/SucursalModel.php');
require_once('model/CiudadModel.php');

class EmpleadoController{

	function list(){
		$this->nav();
		$empleado = new EmpleadoModel();

    $aux = '';
		$rows = $empleado->getList();
    $aux .= "</h1><h2>Empleados</h2><a class=\"btn btn-success\" href=\"?c=Empleado&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>rut</th><th>nombre</th><th>telefono</th><th>calle</th><th>numero</th><th>ciudad</th><th>sucursal</th><th>puesto</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $empleado->$campo = $valor;
  
        switch ($campo) {
          case 'ciudad_id':
            $ciudad = new CiudadModel();
            $ciudad->get($empleado->ciudad_id);
            $aux .= "\t\t<td>". $ciudad->descripcion . "</td>\n";
          break;
          case 'puesto_id':
            $puesto = new PuestoModel();
            $puesto->get($empleado->puesto_id);
            $aux .= "\t\t<td>". $puesto->descripcion . "</td>\n";
          break;
          case 'sucursal_id':
            $sucursal = new SucursalModel();
            $sucursal->get($empleado->sucursal_id);
            $aux .= "\t\t<td>". $sucursal->nombre . "</td>\n";
          break;
          default:
            $aux .= "\t\t<td>". $empleado->$campo . "</td>\n";
          break;
        }

      }

      $aux .= "\t<td><a href=\"?c=Empleado&a=editform&rut=" . $empleado->rut . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=Empleado&a=delete&rut=" . $empleado->rut . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
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
          <label class="control-label col-sm-2" for="sel1">ciudad:</label>
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

    $puesto = new PuestoModel();

    $auxtm = '';
    $rows = $puesto->getList();
    $auxtm .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">puesto:</label>
          <div class="col-sm-10">
            <select class="form-control" name="puesto_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $puesto->$campo = $valor;
        if($campo == 'id'){
          $auxtm .= '<option value="' . $puesto->$campo . '">';
        }
        if($campo == 'descripcion'){
          $auxtm .= $puesto->$campo . '</option>';
        }

      }

    }

    $auxtm .= '</select></div></div>';


    $sucursal = new SucursalModel();

    $auxsu = '';
    $rows = $sucursal->getList();
    $auxsu .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Sucursal:</label>
          <div class="col-sm-10">
            <select class="form-control" name="sucursal_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $sucursal->$campo = $valor;
        if($campo == 'id'){
          $auxsu .= '<option value="' . $sucursal->$campo . '">';
        }
        if($campo == 'nombre'){
          $auxsu .= $sucursal->$campo . '</option>';
        }

      }

    }

    $auxsu .= '</select></div></div>';


    echo ' > Agregar</h1><h2>Agregar empleado:</h2>
      <form class="form-horizontal" action="?c=Empleado&a=add" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            rut:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="rut" required oninput="checkRut(this)" placeholder="Ingrese RUT"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            nombre:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="nombre" placeholder="nombre del empleado"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            telefono:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="telefono" placeholder="telefono" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            calle:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="calle" placeholder="calle"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            numero de casa:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="numero" placeholder="numero" onkeypress="return valida(event)"
            >
          </div>
        </div>

        ' . $aux . $auxsu . $auxtm . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();
    $empleado = new EmpleadoModel();
    $empleado->get($_GET['rut']);


    $ciudad = new CiudadModel();

    $auxr = '';
    $rows = $ciudad->getList();
    $auxr .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">ciudad:</label>
          <div class="col-sm-10">
            <select class="form-control" name="ciudad_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $ciudad->$campo = $valor;
        if($campo == 'id'){
          if($ciudad->$campo == $empleado->ciudad_id){
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


    $puesto = new PuestoModel();

    $auxtm = '';
    $rows = $puesto->getList();
    $auxtm .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">puesto del empleado:</label>
          <div class="col-sm-10">
            <select class="form-control" name="puesto_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $puesto->$campo = $valor;
        if($campo == 'id'){
          if($puesto->$campo == $empleado->puesto_id){
             $auxtm .= '<option value="' . $puesto->$campo . '" selected >';
          }
          else{
            $auxtm .= '<option value="' . $puesto->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $auxtm .= $puesto->$campo . '</option>';
        }

      }

    }

    $auxtm .= '</select></div></div>';


    $sucursal = new SucursalModel();

    $auxsu = '';
    $rows = $sucursal->getList();
    $auxsu .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Sucursal:</label>
          <div class="col-sm-10">
            <select class="form-control" name="sucursal_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $sucursal->$campo = $valor;
        if($campo == 'id'){
          if($sucursal->$campo == $empleado->sucursal_id){
             $auxsu .= '<option value="' . $sucursal->$campo . '" selected >';
          }
          else{
            $auxsu .= '<option value="' . $sucursal->$campo . '">';
          }
        }
        if($campo == 'nombre'){
          $auxsu .= $sucursal->$campo . '</option>';
        }

      }

    }

    $auxsu .= '</select></div></div>';

    $aux = ' > Editar</h1><h2>Editar Empleado:</h2>
      <form class="form-horizontal" action="?c=Empleado&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            rut:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="rut" placeholder="rut" value="' . $empleado->rut . '"  readonly="readonly"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            nombre:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="nombre" placeholder="nombre" value="' . $empleado->nombre . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            telefono:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="telefono" placeholder="telefono" value="' . $empleado->telefono . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            calle:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="calle" placeholder="calle" value="' . $empleado->calle . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            numero:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="numero" placeholder="numero" value="' . $empleado->numero . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        ' . $auxr . $auxsu . $auxtm . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';


      echo $aux;
  }

  function edit(){
    if(isset($_POST['rut'])){
      $empleado = new EmpleadoModel();
      $empleado->edit($_POST);
      $this->list();
      echo $empleado->msj;
    }
  }

  function add(){
    if(isset($_POST['rut'])){
      $empleado = new EmpleadoModel();
      $empleado->set($_POST);
    }
    $this->list();
    echo $empleado->msj;
  }

  function delete(){
    if(!empty($_GET['rut'])){
      
      $empleado = new EmpleadoModel();
      $empleado->delete($_GET['rut']);
      $this->list();
      echo $empleado->msj;

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
              <a class="nav-link active " href="?c=Empleado&a=list">Empleados</a>
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