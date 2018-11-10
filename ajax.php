<?

require_once("config.php");


$data = $_REQUEST['json'];
$data1 = json_decode($data, true);
extract($data1, EXTR_OVERWRITE);


if($action == 'generateLink'){
$arrServerResponse = get_headers($link, 1);

//$ans = print_r($arrServerResponse, true);
$serverAns[] = 'HTTP/1.1 200 OK';
$serverAns[] = 'HTTP/1.0 200 OK';

//if($arrServerResponse[0] == 'HTTP/1.1 200 OK'){
if(in_array($arrServerResponse[0], $serverAns)){
	$ans['server_response'] = "Link is valid: ". $arrServerResponse[0];
	//$ans['url_hash'] = BaseIntEncoder::encode($link);
	//$ans['url_hash'] = md5( time().$link );
	$ans['url_hash'] = hash( 'crc32', time().$link );
	


	$pdo = new DB();
	$pdo->connect();
	$sql = "INSERT INTO links(link_hash, link_url) VALUES('".$ans['url_hash']."', '".$link."')";
	$r = $pdo->query($sql);
	if($r) {
		$ans['status'] = true;
		$ans['short_link'] = SITE_URL."/".$ans['url_hash'];
	}else{
		$ans['status'] = false;
		$ans['error'] = "Error by inserting link in DB";
	}



	
}else{
	$ans['server_response'] = "Link is wrong: ". $arrServerResponse[0];
	$ans['status'] = false;
}

}//generateLink

elseif($action == 'getLinks'){
	$html = '';
	$pdo = new DB();
	$pdo->connect();
	$sql = "SELECT * FROM links";
	$r = $pdo->query($sql);
	if($r) {
		$html = "<table class='w3-table  w3-striped'>";
		while($row = $pdo->fetch($r)){
			//$html.="<div>".$row['id'].'   '.$row['link_hash'].'   '.$row['link_url']."</div>";
			$html.="
			<tr>
			<td>".$row['id']."</td>
			<td>".SITE_URL."/".$row['link_hash']."</td>
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


//echo ("Link from AJAX:".$link);
echo json_encode($ans);

?>