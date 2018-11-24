<?
require_once("config.php");


if(!file_exists(ROOT_DIR."/".PATH_TO_SQLITE_FILE)){
	//echo "db file doesn't exist";
	$pdo = new DB();
	$pdo->connect();

	$commands = ['CREATE TABLE IF NOT EXISTS links (
		id INTEGER PRIMARY KEY,
		link_hash VARCHAR (255),
		link_url VARCHAR (255)
	)'];

	$pdo->createTables($commands);

}



$router = new Router();
$router->run();

echo $router->html;






?>