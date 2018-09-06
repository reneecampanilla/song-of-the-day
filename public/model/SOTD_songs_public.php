<?php

class SOTD_songs_public {
	private $wpdb;
	private $table = SOTD_PREFIX . "_table";

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	public function random() {
		$sql = "SELECT * FROM " . $this->table . " ORDER BY RAND() LIMIT 1";
		$result = $this->wpdb->get_results($sql);

		if (count($result) > 0) {
			return $result[0]->title . " by " . $result[0]->singer;
		} else {
			return false;
		}
	}
}