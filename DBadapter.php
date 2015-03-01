<?php
class DBadapter {
	private $host;
	private $username;
	private $database;
	private $password;

	public function DBadapter($h, $u, $d, $p) {
		$this->host = $h;
		$this->username = $u;
		$this->database = $d;
		$this->password = $p;
	}

	public function connect() {
		mysql_connect($this->host, $this->username, $this->password)or die("cannot connect");
		mysql_select_db($this->database)or die("cannot select DB");
	}

	public function getData($query) {
		return mysql_query($query);
	}

	public function insertData($query) {
		mysql_query($query)or die("cannot insert data ".$query);
	}

	public function getHost() {
		return $this->password;
	}
}

?>