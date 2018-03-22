<?php 
require_once('model/AccesorioModel.php');
require_once('model/SucursalModel.php');
require_once('model/CategoriaModel.php');

class AccesorioController{

	function list(){
		$this->nav();
		$accesorio = new AccesorioModel();

    $aux = '';
		$rows = $accesorio->getList();
    $aux .= "</h1><h2>Accesorios</h2>
    <a class=\"btn btn-success\" href=\"?c=Accesorio&a=addform\">Agregar</a>
    <div class=\"table-responsive\">
    <table class=\"table table-striped\">
      <thead>
        <tr>
          <th>id</th>
          <th>descripcion</th>
          <th>precio venta</th>
          <th>categoria</th>
          <th>sucursal</th>
          <th>Accion</th>
        </tr>
      </thead>
    <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $accesorio->$campo = $valor;
  
        switch ($campo) {
          case 'categoria_id':
            $categoria = new CategoriaModel();
            $categoria->get($accesorio->categoria_id);
            $aux .= "\t\t<td>". $categoria->descripcion . "</td>\n";
          break;
          case 'sucursal_id':
            $sucursal = new SucursalModel();
            $sucursal->get($accesorio->sucursal_id);
            $aux .= "\t\t<td>". $sucursal->nombre . "</td>\n";
          break;
          default:
            $aux .= "\t\t<td>". $accesorio->$campo . "</td>\n";
          break;
        }

      }

      $aux .= "\t<td><a href=\"?c=Accesorio&a=editform&id=" . $accesorio->id . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=Accesorio&a=delete&id=" . $accesorio->id . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
    }
    $aux .= "</tbody></table>\n";
    echo $aux;
		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();
    $categoria = new CategoriaModel();

    $aux = '';
    $rows = $categoria->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Categoria:</label>
          <div class="col-sm-10">
            <select class="form-control" name="categoria_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $categoria->$campo = $valor;
        if($campo == 'id'){
          $aux .= '<option value="' . $categoria->$campo . '">';
        }
        if($campo == 'descripcion'){
          $aux .= $categoria->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

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


    echo ' > Agregar</h1><h2>Agregar Accesorio:</h2>
      <form class="form-horizontal" action="?c=Accesorio&a=add" method="post">
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
            descripcion:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="descripcion" placeholder="descripcion"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            precio venta:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="precio_venta" placeholder="precio venta" onkeypress="return valida(event)"
            >
          </div>
        </div>

        ' . $aux . $auxsu . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();
    $accesorio = new AccesorioModel();
    $accesorio->get($_GET['id']);


    $categoria = new CategoriaModel();

    $auxr = '';
    $rows = $categoria->getList();
    $auxr .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">categoria:</label>
          <div class="col-sm-10">
            <select class="form-control" name="categoria_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $categoria->$campo = $valor;
        if($campo == 'id'){
          if($categoria->$campo == $accesorio->categoria_id){
             $auxr .= '<option value="' . $categoria->$campo . '" selected >';
          }
          else{
            $auxr .= '<option value="' . $categoria->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $auxr .= $categoria->$campo . '</option>';
        }

      }

    }

    $auxr .= '</select></div></div>';


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
          if($sucursal->$campo == $accesorio->sucursal_id){
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

    $aux = ' > Editar</h1><h2>Editar Accesorio:</h2>
      <form class="form-horizontal" action="?c=Accesorio&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" value="' . $accesorio->id . '"  readonly="readonly"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            tamaño:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="descripcion" placeholder="descripcion" value="' . $accesorio->descripcion . '"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            precio venta:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="precio_venta" placeholder="precio venta" value="' . $accesorio->precio_venta . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        ' . $auxr . $auxsu . '

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
      $accesorio = new AccesorioModel();
      $accesorio->edit($_POST);
      $this->list();
      echo $accesorio->msj;
    }
  }

  function add(){
    if(isset($_POST['id'])){
      $accesorio = new AccesorioModel();
      $accesorio->set($_POST);
      $this->list();
      echo $accesorio->msj;
    }
  }

  function delete(){
    if(!empty($_GET['id'])){
      
      $accesorio = new AccesorioModel();
      $accesorio->delete($_GET['id']);
      $this->list();
      echo $accesorio->msj;

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
              <a class="nav-link active" href="?c=Accesorio&a=list">Accesorios</a>
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