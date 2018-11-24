<?

require_once("config.php");
$ans = [];


$jsonData = $_REQUEST['json'];
$arrData = json_decode($jsonData, true);

$controllerName = 'Links';
$actionName = array_shift($arrData);

$controllerObject = new $controllerName;
$ans = call_user_func_array(array($controllerObject, $actionName), $arrData);

echo json_encode($ans);

?>