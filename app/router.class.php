<?

class Router {

    public function __construct() {
        $routesPath = ROOT_DIR.'/routes.php';
        $this->routes = include($routesPath);
    }


    private function getURI(){
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){

    	$uri = $this->getURI();

    	foreach ($this->routes as $uriPattern => $path){

    		if(preg_match("~^$uriPattern$~", $uri)){
    			$internalPath = preg_replace("~^$uriPattern~", $path, $uri);
    			$segments = explode('/', $internalPath);
    			$controllerName = ucfirst(array_shift($segments).'Controller');
    			$actionName = 'action'.ucfirst(array_shift($segments));
    			$parameters = $segments;

    			$controllerObject = new $controllerName;
    			$this->html = call_user_func_array(array($controllerObject, $actionName), $parameters);

                return $this->html;
    		}
    	}
    }


}

?>