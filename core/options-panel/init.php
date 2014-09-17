<?php /**
 * Hatch Options Panel
 *
 * This file outputs the WP Pointer help popups around the site
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Options_Panel {

	private static $instance;

	/**
	*  Initiator
	*/

	public static function init(){
		return self::$instance;
	}

	/**
	*  Constructor
	*/

	public function __construct() {

		// Setup some folder variables
		$this->options_panel_dir = HATCH_TEMPLATE_DIR . '/core/options-panel/';

		// Setup the partial var
		$page =  str_replace( HATCH_THEME_SLUG . '-' , '', $_REQUEST[ 'page' ] );

		// Load template
		$this->body( $page );

	}

	/**
	* Header
	*/
	public function header( $args = array() ){

		// Turn $args into an object because it's nicer to use as a template
		$vars = (object) $args; ?>
		<header>
			<h1><?php echo $vars->title; ?></h1>
			<p><?php echo $vars->intro; ?></p>
		</header>
	<?php }

	/**
	* Body
	*/
	public function body( $partial = NULL ){
		if( NULL == $partial ) return;

		// Include Partials, we're using require so that inside the partial we can use $this to access the header and footer
		require $this->options_panel_dir . 'partials/' . $partial . '.php';

	}

	/**
	* Footer
	*/
	public function footer( $args = array() ){ ?>
		<footer>
		</footer>
	<?php }
}

/**
 * Add admin menu
 */

function hatch_options_panel_menu(){

	// Welcome Page
	add_menu_page(
			HATCH_THEME_TITLE,
			HATCH_THEME_TITLE,
			'edit_theme_options',
			HATCH_THEME_SLUG . '-welcome',
			'hatch_options_panel_ui',
			'dashicons-smiley',
			3
	);
}

add_action( 'admin_menu' , 'hatch_options_panel_menu' , 50 );

/**
*  Kicking this off with the 'ad' hook
*/

function hatch_options_panel_ui(){
	$hatch_options_panel = new Hatch_Options_Panel();
	$hatch_options_panel->init();
}