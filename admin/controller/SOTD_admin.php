<?php

class SOTD_admin {

	public $file = SOTD_PLUGIN_FILE;
	public $prefix = SOTD_PREFIX;
	public $admin_url = SOTD_PLUGIN_ADMIN_URL;

	public function load() {
		$this->includes();
		$this->inits();
	}

	public function includes() {
		require_once $this->admin_url . 'model/SOTD_setup.php';
		require_once $this->admin_url . 'model/SOTD_songs_admin.php';
	}

	public function inits() {
		register_activation_hook($this->file, array($this, 'activate'));
		register_deactivation_hook($this->file, array($this, 'deactivate'));
		
		add_action( 'admin_menu', array($this, 'register_menu') );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_css_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_js_admin_scripts' ) );

		add_action( 'rest_api_init', function () {
			register_rest_route( 'sotd/v1', '/add/(?P<title>[A-Za-z_\-\s\%20\.]+)/(?P<singer>[A-Za-z_\-\s\%20\.]+)', array(
				'methods' => 'GET',
				'callback' => array($this,'add_song'),
			) );
		} );

		add_action( 'rest_api_init', function () {
			register_rest_route( 'sotd/v1', '/delete/(?P<id>[\d]+)', array(
				'methods' => 'GET',
				'callback' => array($this,'delete_song'),
			) );
		} );
	}

	public function register_menu() {
		add_menu_page( 'Song of the Day', 'Song of the Day', 'manage_options', 'song-of-the-day', array($this, 'render'), 'dashicons-format-audio' );
	}

	public function render() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		$all_songs = $this->all_songs();

		include($this->admin_url . '/view/settings.php');
	}

	public function activate() {
		$setup = new SOTD_setup();
		$setup->activate();
	}

	public function deactivate() {
		$setup = new SOTD_setup();
		$setup->deactivate();
	}

	public function register_css_admin_scripts( $hook ) {
        wp_enqueue_style( $this->prefix.'-css-sotd-admin', plugins_url( '/resources/css/bootstrap.css', $this->file ), array(), '4.1.3', 'screen' );
        wp_enqueue_style( 'wpb-google-fonts-roboto', 'https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans', false ); 
        wp_enqueue_style( 'wpb-google-fonts-material', 'https://fonts.googleapis.com/icon?family=Material+Icons', false ); 
        wp_enqueue_style( 'wpb-google-fonts-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false ); 
        wp_enqueue_style( $this->prefix.'-css-sotd-style', plugins_url( '/resources/css/style.css', $this->file ), array(), '1.0' );
    }

    public function register_js_admin_scripts( $hook ) {
        wp_enqueue_script($this->prefix.'-jquery', plugins_url('/resources/js/jquery.min.js', $this->file), array('jquery'), '1.12.4', true);
        wp_enqueue_script($this->prefix.'-popper', plugins_url('/resources/js/popper.min.js', $this->file), array(), '1.12.2', true);
        wp_enqueue_script($this->prefix.'-bootstrap-js', plugins_url('/resources/js/bootstrap.js', $this->file), array(), '4.1.3', true);
        wp_enqueue_script($this->prefix.'-sotd-js', plugins_url('/resources/js/script.js', $this->file), array(), '1.0', true);
    }

    public function add_song($data) {
    	$songs = new SOTD_songs_admin();
    	$songs->title = urldecode($data['title']);
    	$songs->singer = urldecode($data['singer']);
    	$songs->add();
    }

    public function delete_song($data) {
    	$songs = new SOTD_songs_admin();
    	$songs->delete($data['id']);
    }

    public function all_songs() {
    	$songs = new SOTD_songs_admin();
		return $songs->all();
    }
}