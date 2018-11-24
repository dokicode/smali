<?
function __autoload($classname) {
  include_once("./app/".strtolower($classname) . ".class.php");
}

define("ROOT_DIR", dirname (__FILE__));
define("TPL_DIR", ROOT_DIR.'/tpl');
define("PATH_TO_SQLITE_FILE", 'db/phpsqlite.db');
define("SITE_URL", "http://".$_SERVER['HTTP_HOST']);


//require_once("app/functions.php");
//require_once("app/class.pdo.php");
//require_once("app/class.tpl.php");

?>