<?

//define("ROOT_DIR", dirname (__FILE__));
//define("TPL_DIR", ROOT_DIR.'/tpl');

//require_once("app/class.config.php");
require_once("config.php");


//$uri = $_SERVER['REQUEST_URI'];
//echo $uri;

//use App\DB;

//echo "hello bitly";
//phpinfo();

//$pdo = (new DB())->connect();
/*
$pdo = new DB();
$pdo->connect();

$commands = ['CREATE TABLE IF NOT EXISTS links (
	id INTEGER PRIMARY KEY,
	link_hash VARCHAR (255),
	link_url VARCHAR (255)
)'];

$pdo->createTables($commands);

$sql = "SELECT name FROM sqlite_master";

$r = $pdo->query($sql);

$tables = [];
while ($row = $pdo->fetch($r)){
	$tables[] = $row['name'];
}
*/

/*
$sql = "INSERT INTO links(link_hash, link_url) VALUES('aaa_hash', 'http://url.link.com')";
$r = $pdo->query($sql);

if($r){
	echo "SQL was successfully inserted<br>";
}
*/

/*
$sql = "SELECT * FROM links";
$r = $pdo->query($sql);
while($row = $pdo->fetch($r)){
	print_r($row);
}
*/
//print_r($tables);

//$pdo->test("hhhgdhagsdg");
$tpl = new TPL();
$tpl->tpl_dir = TPL_DIR."/";
$tpl->load_template_from_file("main.html");
$tpl->add_param("text", "some text here");
$html = $tpl->generate();
echo $html;
//echo $tpl->tpl_dir;

?>