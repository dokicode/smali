<?
define("ROOT_DIR", dirname (__FILE__));
define("TPL_DIR", ROOT_DIR.'/tpl');
define("PATH_TO_SQLITE_FILE", 'db/phpsqlite.db');
define("SITE_URL", "http://".$_SERVER['HTTP_HOST']);

function __autoload($classname) {
  include_once(ROOT_DIR."/app/".strtolower($classname) . ".class.php");
}
?>