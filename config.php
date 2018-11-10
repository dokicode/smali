<?

define("ROOT_DIR", dirname (__FILE__));
define("TPL_DIR", ROOT_DIR.'/tpl');
define("PATH_TO_SQLITE_FILE", 'db/phpsqlite.db');
define("SITE_URL", 'http://site.com/bitly/');


require_once("app/class.pdo.php");
require_once("app/class.tpl.php");
?>