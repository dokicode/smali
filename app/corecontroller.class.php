<?

class CoreController {

	public function actionMain() {
		$tpl = new TPL();
		$tpl->tpl_dir = TPL_DIR."/";
		$tpl->load_template_from_file("main.html");
		return $tpl->generate();
	}

	public function actionGo( $hash ){
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
				return "Link was not found";
			}


		}else{
			header("HTTP/1.0 404 Not Found");
			return "Hash is empty";
		}
	}

}

?>