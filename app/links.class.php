<?

class Links {

	public function __constructor(){

	}

	public function getLinks(){
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
			$ans['success'] = true;
		}else{
			$ans['success'] = false;
			$ans['error'] = "Error by inserting link in DB";
		}

		return $ans;
	}


	public function generateLink( $link ){
		$func = new Func();
		$serverResponseCode = $func->getServerResponseCode( $link );
		$ans['server_response'] = $serverResponseCode;

			if ( $serverResponseCode >=200 && $serverResponseCode<400 ){
				$ans['success'] = true;
			}else{
				$ans['success'] = false;
				$ans['error'] = "Link is broken";
				if( $serverResponseCode == '404'){
	      			$ans['error'] = "Link is wrong (404)";
	   			}
			}

	// server answer sample HTTP/1.1 200 OK';

		if( $ans['success'] == true ){
			$ans['url_hash'] = hash( 'crc32', time().$link );

			$pdo = new DB();
			$pdo->connect();
			$sql = "INSERT INTO links(link_hash, link_url) VALUES('".$ans['url_hash']."', '".$link."')";
			$r = $pdo->query($sql);
			if($r) {
				$ans['success'] = true;
				$ans['short_link'] = SITE_URL."/".$ans['url_hash'];
$ans['html'] = <<<HTML
		<div class="w3-center w3-container w3-green">
		<span>{$ans['short_link']}</span>
		</div>
HTML;
			}else{
				$ans['success'] = false;
				$ans['error'] = "Error by inserting link in DB";
			}	
		}
		return $ans;
	}//generateLink


	public function deleteItem( $itemId ) {
		$pdo = new DB();
		$pdo->connect();
		$sql = "DELETE FROM links WHERE id='".$itemId."'";
		$r = $pdo->exec($sql);
		if($r){
			$ans['success'] = true;
			$ans['itemId'] = $itemId;
		}else{
			$ans['success'] = false;
			$ans['error'] = "Error by deleting item form DB";
		}
		return $ans;
	}


}

?>