<?php
class Post{
	private $db;
	
	public function __construct(){
		$this->db = new Database;
	}
	public function findAllPosts() {
		$this->db->query('SELECT * FROM posts ORDER BY created_at ASC');
		
		$results = $this->db->resultSet();
		//returt resurts
		return $results;
	}
}