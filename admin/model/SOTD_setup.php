<?php

class SOTD_setup
{
	public $prefix = SOTD_PREFIX;

	public function activate() {
		$sql = 'CREATE TABLE IF NOT EXISTS '. $this->prefix .'_table (
			    id int(11) NOT NULL auto_increment,
			    title varchar(255) NOT NULL,
			    singer varchar(255) NOT NULL,
			    PRIMARY KEY  (id)
			  )';

		dbDelta($sql);
	}

	public function deactivate() {
	    global $wpdb;
	    $wpdb->query( "DROP TABLE IF EXISTS " . $this->prefix . "_table" );
	    delete_option("my_plugin_db_version");
	}
}