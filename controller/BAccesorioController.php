<?php 
require_once('model/BAccesorioModel.php');
require_once('model/ClienteModel.php');
require_once('model/EmpleadoModel.php');

class BAccesorioController{

	function list(){
		$this->nav();
		$ba = new BAccesorioModel();

    $aux = '';
		$rows = $ba->getList();
    $aux .= "</h1><h2>Boleta Accesorio</h2><a class=\"btn btn-success\" href=\"?c=BAccesorio&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>id</th><th>fecha venta</th><th>monto neto</th><th>iva</th><th>total</th><th>cliente</th><th>empleado</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $ba->$campo = $valor;
  
        switch ($campo) {
          case 'cliente_rut':
            $cliente = new ClienteModel();
            $cliente->get($ba->cliente_rut);
            $aux .= "\t\t<td>". $cliente->nombre . "</td>\n";
          break;
          case 'empleado_rut':
            $empleado = new EmpleadoModel();
            $empleado->get($ba->empleado_rut);
            $aux .= "\t\t<td>". $empleado->nombre . "</td>\n";
          break;
          default:
            $aux .= "\t\t<td>". $ba->$campo . "</td>\n";
          break;
        }

      }

      $aux .= "\t<td><a href=\"?c=BAccesorio&a=editform&id=" . $ba->id . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=BAccesorio&a=delete&id=" . $ba->id . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
    }
    $aux .= "</tbody></table>\n";
    echo $aux;
		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();
    $cliente = new ClienteModel();

    $aux = '';
    $rows = $cliente->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">cliente:</label>
          <div class="col-sm-10">
            <select class="form-control" name="cliente_rut">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $cliente->$campo = $valor;
        if($campo == 'rut'){
          $aux .= '<option value="' . $cliente->$campo . '">';
        }
        if($campo == 'nombre'){
          $aux .= $cliente->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

    $empleado = new EmpleadoModel();

    $auxtm = '';
    $rows = $empleado->getList();
    $auxtm .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">empleado:</label>
          <div class="col-sm-10">
            <select class="form-control" name="empleado_rut">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $empleado->$campo = $valor;
        if($campo == 'rut'){
          $auxtm .= '<option value="' . $empleado->$campo . '">';
        }
        if($campo == 'nombre'){
          $auxtm .= $empleado->$campo . '</option>';
        }

      }

    }

    $auxtm .= '</select></div></div>';

    echo ' > Agregar</h1><h2>Agregar Boleta Accesorio:</h2>
      <form class="form-horizontal" action="?c=BAccesorio&a=add" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            fecha venta:
          </label>
          <div class="col-sm-10">
            <input type="date" value="' . date('Y-m-d') . '" class="form-control"
              name="fecha_venta" placeholder="fecha venta"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            monto neto:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="monto_neto" placeholder="monto neto" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Impuesto al valor agregado (IVA):
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="iva" placeholder="Impuesto al valor agregado" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            total:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="total" placeholder="total" onkeypress="return valida(event)"
            >
          </div>
        </div>

        ' . $aux . $auxtm . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();

    $ba = new BAccesorioModel();
    $ba->get($_GET['id']);

    $cliente = new ClienteModel();

    $auxtm = '';
    $rows = $cliente->getList();
    $auxtm .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">cliente:</label>
          <div class="col-sm-10">
            <select class="form-control" name="cliente_rut">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $cliente->$campo = $valor;
        if($campo == 'rut'){
          
          if($cliente->$campo == $ba->cliente_rut){
             $auxtm .= '<option value="' . $cliente->$campo . '" selected >';
          }
          else{
            $auxtm .= '<option value="' . $cliente->$campo . '">';
          }
        }
        if($campo == 'nombre'){
          $auxtm .= $cliente->$campo . '</option>';
        }

      }

    }

    $auxtm .= '</select></div></div>';

    $empleado = new EmpleadoModel();

    $auxe = '';
    $rows = $empleado->getList();
    $auxe .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">empleado:</label>
          <div class="col-sm-10">
            <select class="form-control" name="empleado_rut">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $empleado->$campo = $valor;
        if($campo == 'rut'){
          if($empleado->$campo == $ba->empleado_rut){
             $auxe .= '<option value="' . $empleado->$campo . '" selected >';
          }
          else{
            $auxe .= '<option value="' . $empleado->$campo . '">';
          }
        }
        if($campo == 'nombre'){
          $auxe .= $empleado->$campo . '</option>';
        }

      }

    }

    $auxe .= '</select></div></div>';


    $aux = ' > Editar</h1><h2>Editar Mascota:</h2>
      <form class="form-horizontal" action="?c=BAccesorio&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" value="' . $ba->id . '"  readonly="readonly"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Fecha venta:
          </label>
          <div class="col-sm-10">
            <input type="date" class="form-control"
              name="fecha_venta" placeholder="Fecha" value="' . $ba->fecha_venta . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            monto neto:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="monto_neto" placeholder="monto neto" value="' . $ba->monto_neto . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Impuesto al valor agregado (IVA):
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="iva" placeholder="IVA" value="' . $ba->iva . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Total:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="total" placeholder="Total" value="' . $ba->total . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        ' . $auxtm . $auxe . '

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
      $ba = new BAccesorioModel();
      $ba->edit($_POST);
      $this->list();
      echo $ba->msj;
    }
  }

  function add(){
    if(isset($_POST['id'])){
      $ba = new BAccesorioModel();
      $ba->set($_POST);
      $this->list();
      echo $ba->msj;
    }
  }

  function delete(){
    if(!empty($_GET['id'])){
      
      $ba = new BAccesorioModel();
      $ba->delete($_GET['id']);
      $this->list();
      echo $ba->msj;
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
              <a class="nav-link active" href="?c=BAccesorio&a=list">Boletas Accesorios</a>
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