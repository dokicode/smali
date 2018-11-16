<?

require_once("config.php");

$data = $_REQUEST['json'];
$data1 = json_decode($data, true);
extract($data1, EXTR_OVERWRITE);
$ans = [];

if($action == 'generateLink'){
	$serverResponseCode = getServerResponseCode( $link );
	$ans['server_response'] = $serverResponseCode;

	if( $ans['status'] != false ) {

		if ( $serverResponseCode >=200 && $serverResponseCode<400 ){
			$ans['status'] = true;
		}else{
			$ans['status'] = false;
			$ans['error'] = "Link is broken";
			if( $serverResponseCode == '404'){
      			$ans['error'] = "Link is wrong (404)";
   			}
		}

	}  

// server answer sample HTTP/1.1 200 OK';

if( $ans['status'] == true ){
	$ans['url_hash'] = hash( 'crc32', time().$link );

	$pdo = new DB();
	$pdo->connect();
	$sql = "INSERT INTO links(link_hash, link_url) VALUES('".$ans['url_hash']."', '".$link."')";
	$r = $pdo->query($sql);
	if($r) {
		$ans['status'] = true;
		$ans['short_link'] = SITE_URL."/".$ans['url_hash'];
		$ans['html'] = <<<HTML
<div class="w3-center w3-container w3-green">
<span>{$ans['short_link']}</span>
</div>
HTML;
	}else{
		$ans['status'] = false;
		$ans['error'] = "Error by inserting link in DB";
	}	
}

}//generateLink

elseif($action == 'getLinks'){
	$html = '';
	$pdo = new DB();
	$pdo->connect();
	$sql = "SELECT * FROM links ORDER BY id DESC";
	$r = $pdo->query($sql);
	if($r) {
		$html = "<table id='link-table' class='w3-table  w3-striped'>";
		while($row = $pdo->fetch($r)){
			$html.="
			<tr id='tr-".$row['id']."'>
			<td class='del' data-item='".$row['id']."'><i class=\"fa fa-close w3-text-red\"></i></td>
			<td>".$row['id']."</td>
			<td><a target=\"_blank\" href=\"".SITE_URL."/".$row['link_hash']."\">".SITE_URL."/".$row['link_hash']."</a></td>
			<td>".$row['link_url']."</td>
			</tr>";
		}

		$html.="</table>";
		$ans['html'] = $html;
		$ans['status'] = true;
	}else{
		$ans['status'] = false;
		$ans['error'] = "Error by inserting link in DB";
	}

}//getLinks

elseif($action == 'deleteItem') {
	$pdo = new DB();
	$pdo->connect();
	$sql = "DELETE FROM links WHERE id='".$itemId."'";
	$r = $pdo->exec($sql);
	if($r){
		$ans['status'] = true;
		$ans['itemId'] = $itemId;
	}else{
		$ans['status'] = false;
		$ans['error'] = "Error by deleting item form DB";
	}

}

echo json_encode($ans);

?>