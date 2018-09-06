<?php

class SOTD_public {

	public $file = SOTD_PLUGIN_FILE;
	public $prefix = SOTD_PREFIX;
	public $public_url = SOTD_PLUGIN_PUBLIC_URL;

	public function load() {
		$this->includes();
		$this->inits();
	}

	public function includes() {
		require_once $this->public_url . 'model/SOTD_songs_public.php';
	}

	public function inits() {
		add_shortcode('song-of-the-day', array($this, 'render'));
	}

	public function render() {
		$song = $this->random_song();
		ob_start();
		include($this->public_url . 'view/SOTD_result.php');

		return ob_get_clean();
	}

	public function random_song() {
		$songs = new SOTD_songs_public();
		return $songs->random();
	}
}