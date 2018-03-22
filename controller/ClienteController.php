<?php 
require_once('model/ClienteModel.php');
require_once('model/CiudadModel.php');

class ClienteController{

	function list(){
		$this->nav();
		$cliente = new ClienteModel();

    $aux = '';
		$rows = $cliente->getList();
    $aux .= "</h1><h2>Clientes</h2><a class=\"btn btn-success\" href=\"?c=Cliente&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>rut</th><th>nombre</th><th>telefono</th><th>calle</th><th>numero</th><th>ciudad</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $cliente->$campo = $valor;
  
        switch ($campo) {
          case 'ciudad_id':
            $ciudad = new CiudadModel();
            $ciudad->get($cliente->ciudad_id);
            $aux .= "\t\t<td>". $ciudad->descripcion . "</td>\n";
          break;
          default:
            $aux .= "\t\t<td>". $cliente->$campo . "</td>\n";
          break;
        }

      }

      $aux .= "\t<td><a href=\"?c=Cliente&a=editform&rut=" . $cliente->rut . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=Cliente&a=delete&rut=" . $cliente->rut . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
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

    echo ' > Agregar</h1><h2>Agregar cliente:</h2>
      <form class="form-horizontal" action="?c=Cliente&a=add" method="post">
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
              name="nombre" placeholder="nombre del cliente"
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
    $cliente = new ClienteModel();
    $cliente->get($_GET['rut']);


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
          if($ciudad->$campo == $cliente->ciudad_id){
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

    $aux = ' > Editar</h1><h2>Editar Cliente:</h2>
      <form class="form-horizontal" action="?c=Cliente&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            rut:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="rut" placeholder="rut" value="' . $cliente->rut . '"  readonly="readonly"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            nombre:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="nombre" placeholder="nombre" value="' . $cliente->nombre . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            telefono:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="telefono" placeholder="telefono" value="' . $cliente->telefono . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            calle:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="calle" placeholder="calle" value="' . $cliente->calle . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            numero:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="numero" placeholder="numero" value="' . $cliente->numero . '" onkeypress="return valida(event)"
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
    if(isset($_POST['rut'])){
      $cliente = new ClienteModel();
      $cliente->edit($_POST);
      $this->list();
      echo $cliente->msj;
    }
  }

  function add(){
    if(isset($_POST['rut'])){
      $cliente = new ClienteModel();
      $cliente->set($_POST);
    }
    $this->list();
    echo $cliente->msj;
  }

  function delete(){
    if(!empty($_GET['rut'])){
      
      $cliente = new ClienteModel();
      $cliente->delete($_GET['rut']);
      $this->list();
      echo $cliente->msj;

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
              <a class="nav-link active " href="?c=Cliente&a=list">Clientes</a>
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