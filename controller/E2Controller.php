<?php 
require_once('model/E2Model.php');


class E2Controller{

	function list(){
		$this->nav();
		$raza = new E2Model();

    $aux = '';
		$rows = $raza->q1();
    $aux .= "</h1><h2>Consulta 1</h2>
    <p>Muestre el rut y nombre del cliente, codigo y color de la mascota para aquellos clientes que han comprado mascotas de tipo domesticas y de raza labrador, pero no de raza chihuahua (nunca lo han hecho).</p>"
     . $raza->msj . 
     "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th>rut cliente</th>
              <th>Nombre cliente</th>
              <th>id mascota</th>
              <th>color predominante de la mascota</th>
            </tr>
          </thead>
        <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $campo=>$valor) {
        $raza->$campo = $valor;
        $aux .= "\t\t<td>". $raza->$campo . "</td>\n";
      }
    }
    $aux .= "</tbody></table>\n";

    $raza = new E2Model();

    $rows = $raza->q2();
    $aux .= "<h2>Consulta 2</h2>
    <p>Muestre el codigo y nombre de cada sucursal, ademeas del codigo y descripcion del tipo de mascota y el total de mascotas vendidas por tipo.</p>"
     . $raza->msj . 
     "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>id</th>
              <th>descripcion</th>
              <th>count</th>
            </tr>
          </thead>
        <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $valor) {
        $aux .= "\t\t<td>". $valor . "</td>\n";
      }
      $aux .= "\t</tr>\n";
    }
    $aux .= "</tbody></table>\n";


    $raza = new E2Model();

    $rows = $raza->q3();
    $aux .= "<h2>Consulta 3</h2>
    <p>Muestre el codigo y nombre de la sucursal, la cantidad de empleados de cada una de las sucursales, considerando solo las sucursales que tienen 10 o mas empleados, que han vendido mascotas de tipo salvaje entre los años 2016 y 2017.</p>"
     . $raza->msj . 
     "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>numero de empleados</th>
            </tr>
          </thead>
        <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $valor) {
        $aux .= "\t\t<td>". $valor . "</td>\n";
      }
      $aux .= "\t</tr>\n";
    }
    $aux .= "</tbody></table>\n";

    $raza = new E2Model();

    $rows = $raza->q4();
    $aux .= "<h2>Consulta 4</h2>
    <p>Muestre el codigo, descripcion de los accesorios y la descripcion de la categoria de los accesorios, para los accesorios que son mas vendidos.</p>"
     . $raza->msj . 
     "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th>id</th>
              <th>Descripcion accesorio</th>
              <th>Descripcion categoria</th>
            </tr>
          </thead>
        <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $valor) {
        $aux .= "\t\t<td>". $valor . "</td>\n";
      }
      $aux .= "\t</tr>\n";
    }
    $aux .= "</tbody></table>\n";

    $raza = new E2Model();

    $rows = $raza->q5();
    $aux .= "<h2>Consulta 5</h2>
    <p>Muestre el codigo de las regiones y la descripcion de la raza de la mascota mas vendida por region.</p>"
     . $raza->msj . 
     "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th>codigo region</th>
              <th>Descripcion</th>
            </tr>
          </thead>
        <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $valor) {
        $aux .= "\t\t<td>". $valor . "</td>\n";
      }
      $aux .= "\t</tr>\n";
    }
    $aux .= "</tbody></table>\n";

    $raza = new E2Model();

    $rows = $raza->q6();
    $aux .= "<h2>Consulta 6</h2>
    <p>Muestre el detalle por cada una de las boletas de mascotas.</p>"
     . $raza->msj . 
     "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th>id</th>
              <th>rut cliente</th>
              <th>nombre cliente</th>
              <th>rut empleado</th>
              <th>nombre Empleado</th>
              <th>tipo mascota</th>
              <th>raza</th>
              <th>total</th>
              <th>fecha venta</th>
              <th>ciudad</th>
              <th>sucursal</th>
            </tr>
          </thead>
        <tbody>";
    for($i=0;$i<count($rows);$i++){
      $aux .= "\t<tr>\n";
      foreach($rows[$i] as $valor) {
        $aux .= "\t\t<td>". $valor . "</td>\n";
      }
      $aux .= "\t</tr>\n";
    }
    $aux .= "</tbody></table> <br /> <br /> <br />\n";


    echo $aux;





		//require_once('view/list.php');
		
	}

  function addform(){
    $this->nav();

    echo ' > Agregar</h1><h2>Agregar Raza:</h2>
      <form class="form-horizontal" action="?c=Raza&a=add" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="identificacion"
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

        <div class="form-group">
          <div class="col-sm-10 col-sm-offset-2">
            <input type="submit" class="btn btn-success" value="Guardar" >
          </div>
        </div>
      </form>';
  }

  function editform(){
    $this->nav();
    $raza = new RazaModel();
    $raza->get($_GET['id']);

    $aux = ' > Editar</h1><h2>Editar Raza:</h2>
      <form class="form-horizontal" action="?c=Raza&a=edit" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2">
            id:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="id" placeholder="id" value="' . $raza->id . '"  readonly="readonly"
            >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2">
            Descripcion:
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
              name="descripcion" placeholder="Descripcion" value="' . $raza->descripcion . '"
            >
          </div>
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
    if(isset($_POST['id'])){
      $raza = new RazaModel();
      $raza->edit($_POST);
      $this->list();
    }
  }

  function add(){
    if(isset($_POST['id'])){
      $raza = new RazaModel();
      $raza->set($_POST);
    }
    $this->list();
  }

  function delete(){
    if(!empty($_GET['id'])){
      
      $raza = new RazaModel();
      $raza->delete($_GET['id']);
      $this->list();
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
              <a class="nav-link" href="?c=Ciudad&a=list">Ciudades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?c=Region&a=list">Regiones</a>
            </li>
          </ul>

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="?c=E2&a=list">Consultas Entrega II</a>
            </li>
          </ul>

        </nav>
       

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <h1>Inicio > Mascotas
          ';

	}
} ?>