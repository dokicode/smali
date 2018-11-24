<?

//namespace App;

class DB {

	private $pdo;


	public function test($str){
		echo "Test:".$str;
	}

	public function connect(){
		if($this->pdo == null) {
			//$this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
			$this->pdo = new \PDO("sqlite:" . PATH_TO_SQLITE_FILE);
		}
		return $this->pdo;
	}


	public function createTables($commands){
		foreach($commands as $command){
			$this->pdo->exec($command);
		}
	}

	public function exec($command){
		return $this->pdo->exec($command);
	}


	public function query($sql) {
		return $this->pdo->query($sql);
	}

	public function fetch($r) {
		return $r->fetch(\PDO::FETCH_ASSOC);
	}


}


?>