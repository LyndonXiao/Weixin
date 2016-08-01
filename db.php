<?php
class SaeMysql {
	private $host;
	private $user;
	private $pwd;
	private $dbName;
	private $conn = null;
	public function __construct() {
		$this->host = '127.0.0.1';
		$this->user = 'root';
		$this->pwd = '384399002';
		$this->dbName = 'weixin';
		$this->connect($this->host,$this->user,$this->pwd);
	}
	//负责链接
	private function connect($h,$u,$p) {
		$conn = mysql_connect($h,$u,$p);
		$this->conn = $conn;
		$this->switchDb($this->dbName);
		$this->query("set names utf8");
	}
	//负责切换数据库
	public function switchDb($db) {
		$sql = 'use ' . $db;
		$this->query($sql);
	}
	//负责设置字符集
	public function setChar($char) {
		$sql = 'set names' . $char;
		$this->query($sql);
	}
	//负责发送sql查询
	public function query($sql) {
		return mysql_query($sql,$this->conn);
	}
	//负责获取多行多列的select结果
	public function getAll($sql) {
		$list = array();
		$rs = $this->query($sql);
		if (!$rs) {
			return false;
		}
		while ($row = mysql_fetch_assoc($rs)) {
			$list[] = $row;
		}
		return $list;
	}

	public function getRow($sql) {
		$rs = $this->query($sql);
		if(!$rs) {
			return false;
		}
		return mysql_fetch_assoc($rs);
	}

	public function getOne($sql) {
		$rs = $this->query($sql);
		if (!$rs) {
			return false;
		}
		return mysql_fetch_assoc($rs);
		return $row[0];
	}

	public function close() {
		mysql_close($this->conn);
	}
}
