<?php 
require_once('model/MascotaModel.php');
require_once('model/RazaModel.php');
require_once('model/SucursalModel.php');
require_once('model/TipoMascotaModel.php');

class MascotaController{

	function list(){
		$this->nav();
		$mascota = new MascotaModel();

    $aux = '';
		$rows = $mascota->getList();
    $aux .= "</h1><h2>Mascotas</h2><a class=\"btn btn-success\" href=\"?c=Mascota&a=addform\">Agregar</a><div class=\"table-responsive\"><table class=\"table table-striped\"><thead><tr><th>id</th><th>tamaño</th><th>precio venta</th><th>color predominante</th><th>raza</th><th>tipo mascota</th><th>sucursal</th><th>Accion</th></tr></thead><tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $mascota->$campo = $valor;
  
        switch ($campo) {
          case 'raza_id':
            $raza = new RazaModel();
            $raza->get($mascota->raza_id);
            $aux .= "\t\t<td>". $raza->descripcion . "</td>\n";
          break;
          case 'tipo_mascota_id':
            $tm = new TipoMascotaModel();
            $tm->get($mascota->tipo_mascota_id);
            $aux .= "\t\t<td>". $tm->descripcion . "</td>\n";
          break;
          case 'sucursal_id':
            $sucursal = new SucursalModel();
            $sucursal->get($mascota->sucursal_id);
            $aux .= "\t\t<td>". $sucursal->nombre . "</td>\n";
          break;
          default:
            $aux .= "\t\t<td>". $mascota->$campo . "</td>\n";
          break;
        }

      }

      $aux .= "\t<td><a href=\"?c=Mascota&a=editform&id=" . $mascota->id . " \"class=\"btn btn-success\">Editar</a><a href=\"?c=Mascota&a=delete&id=" . $mascota->id . " \"class=\"btn btn-danger\">Eliminar</a></td></tr>\n";
    }
    $aux .= "</tbody></table>\n";
    echo $aux;
		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();
    $raza = new RazaModel();

    $aux = '';
    $rows = $raza->getList();
    $aux .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Raza:</label>
          <div class="col-sm-10">
            <select class="form-control" name="raza_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $raza->$campo = $valor;
        if($campo == 'id'){
          $aux .= '<option value="' . $raza->$campo . '">';
        }
        if($campo == 'descripcion'){
          $aux .= $raza->$campo . '</option>';
        }

      }

    }

    $aux .= '</select></div></div>';

    $tm = new TipoMascotaModel();

    $auxtm = '';
    $rows = $tm->getList();
    $auxtm .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Tipo Mascota:</label>
          <div class="col-sm-10">
            <select class="form-control" name="tipo_mascota_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $tm->$campo = $valor;
        if($campo == 'id'){
          $auxtm .= '<option value="' . $tm->$campo . '">';
        }
        if($campo == 'descripcion'){
          $auxtm .= $tm->$campo . '</option>';
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


    echo ' > Agregar</h1><h2>Agregar Mascota:</h2>
      <form class="form-horizontal" action="?c=Mascota&a=add" method="post">
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
            tamaño:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="tamano" placeholder="tamaño de la mascota" onkeypress="return valida(event)"
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

        <div class="form-group">
          <label class="control-label col-sm-2">
            color predominante:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="color_predominante" placeholder="color predominante"
            >
          </div>
        </div>

        ' . $aux . $auxtm . $auxsu . '

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();
    $mascota = new MascotaModel();
    $mascota->get($_GET['id']);


    $raza = new RazaModel();

    $auxr = '';
    $rows = $raza->getList();
    $auxr .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Raza:</label>
          <div class="col-sm-10">
            <select class="form-control" name="raza_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $raza->$campo = $valor;
        if($campo == 'id'){
          if($raza->$campo == $mascota->raza_id){
             $auxr .= '<option value="' . $raza->$campo . '" selected >';
          }
          else{
            $auxr .= '<option value="' . $raza->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $auxr .= $raza->$campo . '</option>';
        }

      }

    }

    $auxr .= '</select></div></div>';


    $tm = new TipoMascotaModel();

    $auxtm = '';
    $rows = $tm->getList();
    $auxtm .= '<div class="form-group">
          <label class="control-label col-sm-2" for="sel1">Tipo Mascota:</label>
          <div class="col-sm-10">
            <select class="form-control" name="tipo_mascota_id">';
            
    for($i=0;$i<count($rows);$i++){
      foreach($rows[$i] as $campo=>$valor) {
        $tm->$campo = $valor;
        if($campo == 'id'){
          if($tm->$campo == $mascota->tipo_mascota_id){
             $auxtm .= '<option value="' . $tm->$campo . '" selected >';
          }
          else{
            $auxtm .= '<option value="' . $tm->$campo . '">';
          }
        }
        if($campo == 'descripcion'){
          $auxtm .= $tm->$campo . '</option>';
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
          if($sucursal->$campo == $mascota->sucursal_id){
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

    $aux = ' > Editar</h1><h2>Editar Mascota:</h2>
      <form class="form-horizontal" action="?c=Mascota&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" value="' . $mascota->id . '"  readonly="readonly" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            tamaño:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="tamano" placeholder="tamaño de la mascota" value="' . $mascota->tamano . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            precio venta:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="precio_venta" placeholder="precio venta" value="' . $mascota->precio_venta . '" onkeypress="return valida(event)"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            color predominante:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="color_predominante" placeholder="color predominante" value="' . $mascota->color_predominante . '"
            >
          </div>
        </div>

        ' . $auxr . $auxtm . $auxsu . '

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
      $mascota = new MascotaModel();
      $mascota->edit($_POST);
      $this->list();
      echo $mascota->msj;
    }
  }

  function add(){
    if(isset($_POST['id'])){
      $mascota = new MascotaModel();
      $mascota->set($_POST);
    }
    $this->list();
    echo $mascota->msj;
  }

  function delete(){
    if(!empty($_GET['id'])){
      
      $mascota = new MascotaModel();
      $mascota->delete($_GET['id']);
      $this->list();
      echo $mascota->msj;

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
              <a class="nav-link active" href="?c=Mascota&a=list">Mascotas<span class="sr-only">(current)</span></a>
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