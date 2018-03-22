<?php  
class FrontController{
	public static function main(){
		
		require_once('config/DBAbstractModel.php');
		include('view/theme/head.php');
		if(!empty($_GET['c'])){
			$controllerName = $_GET['c'] . 'Controller';
		}
		else{
			$controllerName = 'IndexController';
		}
		
		$controllerPath = 'controller/' . $controllerName . '.php';
		
		if(is_file($controllerPath)){
			require_once($controllerPath);
		}
		else{
			die('<p>404 page not fount</p>');
		}
		
		if(!empty($_GET['a'])){
			$actionName = $_GET['a'];
		}
		else{
			$actionName = 'index';
		}
		
		$controller = new $controllerName();
		
		$controller->$actionName();
		
		include('view/theme/footer.php');
		
	}
}?>