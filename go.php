<?

require_once("config.php");

$hash = isset($_GET['hash']) ? $_GET['hash'] : '';

if( !empty($hash) ){

	$pdo = new DB();
	$pdo->connect();
	$sql = "SELECT link_url FROM links WHERE link_hash='".$hash."'";
	$r = $pdo->query($sql);

	$row = $pdo->fetch($r);
	
	if( $row !== false ){
		header('Location:'.$row['link_url']);
	}else{
		header("HTTP/1.0 404 Not Found");
		echo "Link was not found";
	}


}else{
	header("HTTP/1.0 404 Not Found");
	echo "Hash is empty";
}



?>