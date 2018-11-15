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

$tpl = new TPL();
$tpl->tpl_dir = TPL_DIR."/";
$tpl->load_template_from_file("main.html");
$tpl->add_param("text", "some text here");
$html = $tpl->generate();
echo $html;

?>