<?

require_once("config.php");

$hash = $_GET['hash'];
//echo "go:" . $hash;

$pdo = new DB();
$pdo->connect();
$sql = "SELECT link_url FROM links WHERE link_hash='".$hash."'";
$r = $pdo->query($sql);
$row = $pdo->fetch($r);
//echo $row['link_url'];

header('Location:'.$row['link_url']);
?>