<?php
/**
 * Plugin Name: myCred Near Protocol
 * Description: This plugin provides functionalities to purchase mycred points using near tokens.
 * Version: 1.0
 * Tags: near, mycred, nearprotocol, blockchain, crypto
 * Author Email: support@mycred.me
 * Author: myCred 
 * Author URI: http://mycred.me
 * Text Domain: mycred-near-protocol
 * Domain Path: /languages
 * License: Copyrighted
 */

if ( ! class_exists( 'mycred_near_protocol' ) ) :
	final class mycred_near_protocol {

		// Plugin Version
		public $version             = '1.0';

		// Instnace
		protected static $_instance = NULL;

		/**
		 * Setup Instance
		 * @since 1.0
		 * @version 1.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Not allowed
		 * @since 1.0
		 * @version 1.0
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->version ); }

		/**
		 * Not allowed
		 * @since 1.1.2
		 * @version 1.0
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->version ); }

		/**
		 * Define
		 * @since 1.1.2
		 * @version 1.0
		 */
		private function define( $name, $value, $definable = true ) {
			if ( ! defined( $name ) )
				define( $name, $value );
			elseif ( ! $definable && defined( $name ) )
				_doing_it_wrong( 'define->define()', 'Could not define: ' . $name . ' as it is already defined somewhere else!', $this->version );
		}

		/**
		 * Require File
		 * @since 1.1.2
		 * @version 1.0
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
			else
				_doing_it_wrong( 'mycred_near_protocol->file()', 'Requested file ' . $required_file . ' not found.', $this->version );
		}

		/**
		 * Construct
		 * @since 1.0
		 * @version 1.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->load_module();

			add_action( 'wp_enqueue_scripts', array( $this, 'mycrednp_scripts' ) ); // wp_enqueue_script
			add_action( 'init', array( $this, 'mycrednp_add_translation' ) ); // wp_enqueue_script
			
		}

		public function mycrednp_add_translation() {
			load_plugin_textdomain('mycred-near-protocol', FALSE,  basename( dirname( __FILE__ ) ) . '/languages/');
		}
		
		/**
		 * Enqueue related scripts
		**/
		public function mycrednp_scripts() {
			$mycred_np=get_option( 'mnp_settings' );
			
		//	$private_key=(isset($mycred_np['mnp']['private_key']) ? $mycred_np['mnp']['private_key'] : '');
			$network=(isset($mycred_np['mnp']['network']) ? $mycred_np['mnp']['network'] : '');
			$admin_account=(isset($mycred_np['mnp']['admin_account']) ? $mycred_np['mnp']['admin_account'] : '');
			$exchange_rate=(isset($mycred_np['mnp']['exchange_rate']) ? $mycred_np['mnp']['exchange_rate'] : '');
			
			wp_register_script( 'near-api-js', 'https://cdn.jsdelivr.net/gh/nearprotocol/near-api-js/dist/near-api-js.js', array(), $this->version );
			wp_register_script( 'mycred-np-js', plugins_url('assets/js/mycred-np.js',__FILE__ ), array('jquery'), $this->version );
			wp_localize_script('mycred-np-js', 'mnp_assets', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'mycred_np_nonce' => wp_create_nonce( 'myCred-NP-nonce'),
				//'mycred_np_private_key' => $private_key,
				'mycred_np_network' => $network,
				'mycred_np_admin_account' => $admin_account,
				'mycred_np_exchange_rate' => $exchange_rate,
			
			));
			
		}

		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0
		 */
		private function define_constants() {

			$this->define( 'MYCRED_NP_VERSION',        $this->version );
			$this->define( 'MYCRED_NP_SLUG',          'mycred-near-protocol' );

			$this->define( 'MYCRED_NP',               __FILE__ );
			$this->define( 'MYCRED_NP_ROOT',          plugin_dir_path( MYCRED_NP  ) );
			$this->define( 'MYCRED_NP_INCLUDE', plugin_dir_path( MYCRED_NP ) . 'inc/' );
			$this->define( 'MYCRED_NP_ASSETS', plugin_dir_path( MYCRED_NP)  . 'assets/' );
			
			
		}
		
		/**
		 * Load Module
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_module() {

			$this->file( MYCRED_NP_INCLUDE . 'shortcode.php' );
			$this->file( MYCRED_NP_INCLUDE . 'class-mnp-settings.php' );
			$this->file( MYCRED_NP_INCLUDE . 'mnp-functions.php' );

		}

	}
endif;

function mycred_near_protocol_plugin() {
	return mycred_near_protocol::instance();
}
add_action( 'mycred_init', 'mycred_near_protocol_plugin' );


function mycred_near_protocol_notice__error() {

	if(!class_exists('myCRED_Core')){
		$class = 'notice notice-error';
    	$message = __( 'myCred Near Protocol Requires myCred to be installed and activated.', 'mycred-near-protocol' );
 
    	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
	
    
}
add_action( 'admin_notices', 'mycred_near_protocol_notice__error' );


