<?php

class SOTD_songs_admin {
	private $wpdb;
	private $table = SOTD_PREFIX . "_table";
	public $title;
	public $singer;

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	public function add() {
		$data = array('title' => $this->title, 'singer' => $this->singer);
		$this->wpdb->insert($this->table,$data);
	}

	public function delete($id) {
		$this->wpdb->delete( $this->table, array( 'id' => $id ) );
	}

	public function all() {
		$sql = "SELECT * FROM " . $this->table . " ORDER BY title ASC";
		$result = $this->wpdb->get_results($sql);

		return $result;
	}

	public function random() {
		$sql = "SELECT * FROM " . $this->table . " ORDER BY RAND() LIMIT 1";
		$result = $this->wpdb->get_results($sql);

		return $result;
	}
}