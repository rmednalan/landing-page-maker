<?php

/*
Plugin Name: JW Page Builder
Plugin URI: 
Description: It is a landing page builder plugin that helps developers and users create and develop website layout easily.
Version: 2.7
Author: RME
Author URI:
Text Domain: upfront
*/
/**
 * Main entry point for Upfront core
 *
 * This is where we set up Upfront main class
 * which handles core bootstrap and execution context.
 */
/*  $files = glob("C:/xampp/htdocs/jwpb-template/wp-content/themes/roses/global-regions/*.php");
echo "<pre>";
print_r($files);
print_r(get_stylesheet_directory());
echo "</pre>";  */
require_once(dirname(__FILE__) . '/builder/jwpb_builder.php');
 
function setup_jwpb_theme(){	
	//prepare post
	if ( ! function_exists( 'post_exists' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/post.php' );
	}
	
	//create static home page
	$post_id = post_exists("JWPB");
	$blog_id = post_exists("JWPB Post Template");
	if(post_exists("JWPB") == 0){
		// Create post object
		$home = array(
		  'post_title'    => "JWPB",
		  'post_content'  => "<h1>Welcome to JWPB.</h1>",
		  'post_status'   => 'publish',
		  'post_type'	  => 'page'
		);
		
		$blog = array(
		  'post_title'    => "JWPB Post Template",
		  'post_content'  => "<h1>Welcome to JWPB Post Template.</h1>",
		  'post_status'   => 'publish',
		  'post_type'	  => 'post'
		);
		 
		// Insert the post into the database
		$post_id = wp_insert_post( $home );
		$blog_id = wp_insert_post( $blog );
	}
	
	if(!get_option("jwpb_default_page")){
		add_option("jwpb_default_page",$post_id);
	}else{
		update_option("jwpb_default_page",$post_id);
	}
	
	update_post_meta($post_id,"upfront-uf_wp_page_template","upfront-default");
	update_post_meta($blog_id,"upfront-uf_wp_page_template","upfront-default");
}

function switch_jwpb_theme_notice(){
	global $pagenow;
	
	if($pagenow == "options-reading.php"){
		echo '<div class="error notice">
			<p>';
				_e("JW Page Builder Plugin requires a <strong>static page</strong> for <strong>front page displays </strong>field.");
		echo '</p>
		</div>';

	}
}

add_action("init","setup_jwpb_theme");

function jwpb_admin_styles() {
	//if(can_use_template() and ((is_home())?get_option("show_on_front") == "page":true)){
		wp_register_style('jwpb_experimental_style', plugins_url('styles/css/experimental.css?t='.time(),__FILE__ ));
		wp_register_style('jwpb_restrictions_style', plugins_url('styles/css/user-restrictions.css?t='.time(),__FILE__ ));
		wp_register_style('jwpb_main_style', plugins_url('styles/css/main.css?t='.time(),__FILE__ ));
		wp_register_style('jwpb_general_style', plugins_url('styles/css/general.css?t='.time(),__FILE__ ));
		
		wp_register_script('jwpb_admin_script', plugins_url('scripts/admin.js?t='.time(),__FILE__ ));
		

		wp_enqueue_style('jwpb_experimental_style');
		wp_enqueue_style('jwpb_restrictions_style');
		wp_enqueue_style('jwpb_main_style');
		wp_enqueue_style('jwpb_general_style');
		wp_enqueue_script('jwpb_admin_script');

	//}

}

add_action( 'admin_init','jwpb_admin_styles');
add_action('wp_head', 'jwpb_admin_styles');

require_once(dirname(__FILE__) . '/library/upfront_functions.php');
require_once(dirname(__FILE__) . '/library/upfront_functions_theme.php');
require_once(dirname(__FILE__) . '/library/class_upfront_permissions.php');
require_once(dirname(__FILE__) . '/library/class_upfront_registry.php');
require_once(dirname(__FILE__) . '/library/class_upfront_debug.php');
require_once(dirname(__FILE__) . '/library/class_upfront_behavior.php');
require_once(dirname(__FILE__) . '/library/class_upfront_http_response.php');
require_once(dirname(__FILE__) . '/library/class_upfront_server.php');
require_once(dirname(__FILE__) . '/library/class_upfront_model.php');
require_once(dirname(__FILE__) . '/library/class_upfront_module_loader.php');
require_once(dirname(__FILE__) . '/library/class_upfront_theme.php');
require_once(dirname(__FILE__) . '/library/class_upfront_grid.php');
require_once(dirname(__FILE__) . '/library/class_upfront_style_preprocessor.php');
require_once(dirname(__FILE__) . '/library/class_upfront_output.php');
require_once(dirname(__FILE__) . '/library/class_upfront_endpoint.php');
require_once(dirname(__FILE__) . '/library/class_upfront_media.php');
require_once(dirname(__FILE__) . '/library/class_ufront_ufc.php');
require_once(dirname(__FILE__) . '/library/class_upfront_codec.php');
require_once(dirname(__FILE__) . '/library/class_upfront_compat.php');
require_once(dirname(__FILE__) . '/library/class_upfront_postpart.php');
require_once(dirname(__FILE__) . '/library/class_upfront_admin.php');
require_once(dirname(__FILE__) . '/library/class_upfront_compression.php');

Upfront_Behavior::debug()->set_baseline();
//rme - debug level is none = UPFRONT_DEBUG_LEVELS

/**
 * Main class
 */
class Upfront {

	/**
	 * Theme text domain
	 *
	 * @var string
	 */
	const TextDomain = "upfront";

	/**
	 * List of files to exclude in scanning
	 *
	 * @TODO refactor var name and location
	 *
	 * @var array
	 */
	public static $Excluded_Files = array(".", "..", ".DS_Store");

	/**
	 * Servers to load automatically
	 *
	 * @var array
	 */
	private $_servers = array(
		'ajax',
		'javascript_main',
		'stylesheet_main',
		'stylesheet_editor',
		'element_styles',
	);

	/**
	 * Debugger instance
	 *
	 * @var object
	 */
	private $_debugger;

	/**
	 * Instantiate class - never to the outsiders
	 */
	private function __construct () {
		$this->_debugger = Upfront_Debug::get_debugger();
		$servers = apply_filters('upfront-servers', $this->_servers);
		foreach ($servers as $component) $this->_run_server($component);
		Upfront_ModuleLoader::serve();
		do_action('upfront-core-initialized');
	}

	/**
	 * Public spawning interface
	 */
	public static function serve () {
		$me = new self;
		$me->_add_hooks();
		$me->_add_supports();
	}

	/**
	 * Add basic set of hooks
	 */
	private function _add_hooks () {
		add_filter('body_class', array($this, 'inject_grid_scope_class'));
		add_action('wp_head', array($this, "inject_global_dependencies"), 0);
		add_action('wp_footer', array($this, "inject_upfront_dependencies"), 99);
		add_action('upfront-core-wp_dependencies', array($this, "inject_core_wp_dependencies"), 99);

		add_action('admin_bar_menu', array($this, 'add_edit_menu'), 85);

		if (is_admin()) {
			require_once(dirname(__FILE__) . '/library/servers/class_upfront_admin.php');
			if (class_exists('Upfront_Server_Admin')) Upfront_Server_Admin::serve();
		}

		if ( is_rtl() ) {
			add_action('wp_head', array($this, "inject_rtl_dependencies"), 99);
		}

	}

	/**
	 * Set up parent and child theme text domains
	 */
	public static function load_textdomain () {
		$path = untrailingslashit(self::get_root_dir()) . '/languages';

		load_theme_textdomain('upfront', $path);

		// Now let's try the child theme...
		$current = wp_get_theme();
		$parent = $current->parent();
		if (empty($parent)) return false; // Current theme is not a child theme, carry on...
		$parent_name = wp_get_theme();
		if ($parent_name->stylesheet !== $parent->get_template()) return false; // Not an Upfront child, carry on...
		$child_domain = $current->get('TextDomain');
		if (!empty($child_domain) && $parent_name->stylesheet !== $child_domain) {
			load_child_theme_textdomain($child_domain, get_stylesheet_directory() . '/languages');
		}

	}

	/**
	 * Add theme extra features
	 */
	private function _add_supports () {
		add_theme_support('post-thumbnails');
		add_theme_support('title-tag'); // Let WP deal with our theme titles
		register_nav_menu('default', __('Default', 'upfront'));
		// Do widget text
		$do_widget_text = apply_filters(
			'upfront-shortcode-enable_in_widgets',
			(defined('UPFRONT_DISABLE_WIDGET_TEXT_SHORTCODES') && UPFRONT_DISABLE_WIDGET_TEXT_SHORTCODES ? false : true)
		);
		if ($do_widget_text) {
			add_filter('widget_text', 'do_shortcode');
		}
	}

	/**
	 * Instantiate auto-bootable server
	 *
	 * @param string $comp Server to boot
	 */
	private function _run_server ($comp) {
		$class = Upfront_Server::name_to_class($comp);
		if (!$class) return false;
		call_user_func(array($class, 'serve'));
	}

	/**
	 * Gets parent theme root URL
	 *
	 * @return string
	 */
	public static function get_root_url () {
		//return get_template_directory_uri();
		
		/* echo get_template_directory_uri();
		echo "--".plugins_url()."/jwpb <br />"; */
		return plugins_url()."/jwpb";
	}

	/**
	 * Gets parent theme root path
	 *
	 * @return string
	 */
	public static function get_root_dir () {
	//	return get_template_directory();
	/* 	echo get_template_directory();
		echo "--".plugin_dir_path( __FILE__ )."<br />"; */
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Inject admin toolbar menu entry
	 *
	 * @param object $wp_admin_bar Toolbar
	 */
	public function add_edit_menu ($wp_admin_bar) {
		if (!Upfront_Permissions::current(Upfront_Permissions::BOOT)) return false;
		$jwpb_post_id = get_option("jwpb_default_page");
		$link = get_permalink($jwpb_post_id);
		$is_built = get_post_meta(get_the_ID(),"upfront-uf_wp_page_template");
		
		if($is_built){
			$link_page = "#";
		}else{
			$link_page = get_permalink(get_the_ID())."/?editmode=true";
		}
		
		if(!is_admin()){
			if(get_post_type(get_the_ID()) == "post" ){
				$link_page = $link."/?editmode=true";
			}
		}
		$item = array(
			'id' => 'upfront-edit_layout',
			'title' => '<span class="ab-icon"></span><span class="ab-label">' . __('JWPB', 'upfront') . '</span>',
			//'href' => (is_admin() ? home_url('/?editmode=true', is_ssl() ? "https" : null) : '#'),
			'href' => (is_admin() ? $link."/?editmode=true": $link_page),
			'meta' => array(
				'class' => 'upfront-edit_layout upfront-editable_trigger',
			),
		);
		$permalinks_on = get_option('permalink_structure');

		if (!$permalinks_on) {
			// We're checking WP priv directly because we need an admin for this
			if (current_user_can('manage_options')) {
				$item['href'] = admin_url('/options-permalink.php');
				unset($item['meta']);
			} else {
				$item = array(); // No such thing for non-admins
			}
		}

		if (!empty($item)) {
			//if(get_option("page_on_front") !== get_the_ID()){
				$wp_admin_bar->add_menu($item);
			//}
		}

		// Change the existing nodes
		$nodes = $wp_admin_bar->get_nodes();
		if (!empty($nodes) && is_array($nodes)) {
			foreach ($nodes as $node) {
				if (!empty($node->href) && preg_match('/customize\.php/', $node->href)) {
					$node->href = !empty($node->id) && 'customize-themes' === $node->id // WordPress doubles down on customizer endpoint for themes list too...
						? admin_url('themes.php') // ... not gonna happen
						: home_url('?editmode=true')
					;
				}
				$wp_admin_bar->add_node($node);
			}
		}

		// Action hook here, so other stuff can add its bar items
		// (most notably, the exporter)
		do_action('upfront-admin_bar-process', $wp_admin_bar, $item);
	}

	/**
	 * Appends grid scope class to the classes array
	 *
	 * @param array $cls Classes up to here
	 *
	 * @return array
	 */
	function inject_grid_scope_class ($cls) {
		$grid = Upfront_Grid::get_grid();
		$cls[] = $grid->get_grid_scope();
		return $cls;
	}

	/**
	 * Handles core WP front-end dependencies injection
	 */
	public function inject_core_wp_dependencies () {
		$deps = Upfront_CoreDependencies_Registry::get_instance();

		if (Upfront_Behavior::compression()->has_experiments()) {
			if (defined('DOING_AJAX') && DOING_AJAX) {
				$deps->add_wp_script('jquery-ui-core');
				$deps->add_wp_script('jquery-ui-widget');
				$deps->add_wp_script('jquery-ui-mouse');
				$deps->add_wp_script('jquery-effects-core');
				$deps->add_wp_script('jquery-effects-slide');
				$deps->add_wp_script('jquery-ui-draggable');
				$deps->add_wp_script('jquery-ui-droppable');
				$deps->add_wp_script('jquery-ui-resizable');
				$deps->add_wp_script('jquery-ui-selectable');
				$deps->add_wp_script('jquery-ui-sortable');
				$deps->add_wp_script('jquery-ui-slider');
				$deps->add_wp_script('jquery-ui-datepicker');
			} else {
				$deps->add_script(admin_url('admin-ajax.php?action=wp_scripts'));
			}
		} else {
			// Non-experiments load
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-effects-core');
			wp_enqueue_script('jquery-effects-slide');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-resizable');
			wp_enqueue_script('jquery-ui-selectable');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-datepicker');
		}

		/**
		 * Todo Sam: make it cleaner
		 */
		wp_enqueue_script("wp_shortcode", "/wp-includes/js/shortcode.js", array("underscore"));
	}

	/**
	 * Handles global FE dependencies injection
	 */
	function inject_global_dependencies () {
		$deps = Upfront_CoreDependencies_Registry::get_instance();
		wp_enqueue_script('jquery');

		// Basic styles for upfront to work are always loaded.
		$global_style = Upfront_Behavior::compression()->has_experiments()
			? '/styles/global.min.css'
			: '/styles/global.css'
		;
		wp_enqueue_style('upfront-global', self::get_root_url() . $global_style, array(), Upfront_ChildTheme::get_version());

		if (!Upfront_Permissions::current(Upfront_Permissions::BOOT)) {
			// Don't queue the front grid if has permission to boot Upfront, queue editor grid instead
			wp_enqueue_style('upfront-front-grid', admin_url('admin-ajax.php?action=upfront_load_grid'), array(), Upfront_ChildTheme::get_version());
		}

		if (Upfront_Permissions::current(Upfront_Permissions::BOOT)) {
			do_action('upfront-core-wp_dependencies');

			wp_enqueue_style('upfront-editor-interface', self::get_root_url() . ( $this->_debugger->is_dev()  ?  '/styles/editor-interface.css' : '/styles/editor-interface.min.css' ) , array(), Upfront_ChildTheme::get_version());

			$link_urls = array(
				admin_url('admin-ajax.php?action=upfront_load_editor_grid'),
				self::get_root_url() . '/scripts/chosen/chosen.min.css',
				self::get_root_url() . '/styles/font-icons.css',
			);
			foreach ($link_urls as $url) {
				$deps->add_style($url);
			}
			$deps->add_font('Open Sans', array(
				'300',
				'400',
				'600',
				'700',
				'400italic',
				'600italic',
			));

			add_action('wp_footer', array($this, 'add_responsive_css'));
		}
	}

	/**
	 * Handles Upfront editor-specific FE dependencies injection
	 */
	function inject_upfront_dependencies () {

		if (!Upfront_Permissions::current(Upfront_Permissions::BOOT)) {
			do_action('upfront-core-inject_dependencies'); // Also trigger the dependencies injection hook
			return false; // Do not inject for users that can't use this
		}

		$url = self::get_root_url();

		// Boot Edit Mode if the querystring contains the editmode param
		if (isset($_GET['editmode'])) echo upfront_boot_editor_trigger();

		$storage_key = apply_filters('upfront-data-storage-key', Upfront_Layout::STORAGE_KEY);
		$save_storage_key = $storage_key;
		$is_ssl = is_ssl() ? '&ssl=1' : '';

		if (Upfront_Behavior::debug()->is_dev() && current_user_can('switch_themes') && apply_filters('upfront-enable-dev-saving', true)) {
			$save_storage_key .= '_dev';
		}

		//$main_source = $this->_debugger->is_dev() ? "scripts/main.js" : "build/main.js";
		$main_source = "scripts/main.js";
		$script_urls = array(
			"{$url}/scripts/require.js",
			"{$url}/scripts/debug.js?t=".time(),
			admin_url('admin-ajax.php?action=upfront_load_main' . $is_ssl),
			"{$url}/{$main_source}?t=".time(),
		);
		$deps = Upfront_CoreDependencies_Registry::get_instance();
		foreach ($script_urls as $url) {
			$deps->add_script($url);
		}

		$layout_post_data = json_encode(array(
			'layout' => Upfront_EntityResolver::get_entity_ids(),
			'post_id' => (is_singular() ? apply_filters('upfront-data-post_id', get_the_ID()) : false),
		));
		
		//if child
		$jwpb_url = $_SERVER['REQUEST_URI'];
		$jwpb_url = explode("/",$jwpb_url);
		if($jwpb_url[2] == "create_new"){
			$post_id = get_option("page_on_front");
			if ( 'posts' == get_option('show_on_front') ) {
				$post_id = get_option('jwpb_default_page');
			}
			$layout_post_data = json_encode(array(
				'layout' => array(
					"specificity" => "archive-home",
					"item" => "archive-home",
					"type" => "archive",
				),
				//'post_id' => (is_singular() ? apply_filters('upfront-data-post_id', get_the_ID()) : false),
				'post_id' => $post_id,
			));
		}
		
		
		/* echo "<pre>";
		print_r($layout_post_data);
		print_r($jwpb_url);
		print_r($_SERVER['REQUEST_URI']);
		echo "</pre>"; */
		echo '<script type="text/javascript">
			var _upfront_post_data=' . $layout_post_data . ';
			var _upfront_storage_key = "' . esc_js($storage_key) . '";
			var _upfront_save_storage_key = "' . esc_js($save_storage_key) . '";
			var _upfront_stylesheet = "' . esc_js(get_stylesheet()) . '";
			var _upfront_debug_mode = ' . (int)Upfront_Behavior::debug()->is_debug() . ';
			var _upfront_please_hold_on = ' . json_encode(__('Please, hold on for just a little bit more', 'upfront')) . ';
		</script>';
		echo <<<EOAdditivemarkup
	<div id="sidebar-ui" class="upfront-ui"></div>
	<div id="settings" style="display:none"></div>
	<div id="contextmenu" style="display:none"></div>
EOAdditivemarkup;

		do_action('upfront-core-inject_dependencies');
	}

	/**
	 * Injects responsive CSS
	 */
	function add_responsive_css () {
		include(self::get_root_dir() . '/styles/editor-interface-responsive.html');
	}

	/**
	 * Injects dependencies for rtl languages
	 */
	function inject_rtl_dependencies () {

		wp_enqueue_style('upfront-global-rtl', self::get_root_url() . ( $this->_debugger->is_dev() ? "/styles/global-rtl.css" : "/styles/global-rtl.min.css" ), array(), Upfront_ChildTheme::get_version());
	}
}

add_action('init', array('Upfront', 'serve'), 0);
add_action('after_setup_theme', array('Upfront', "load_textdomain"));

/**
 * Filters wp caption atts to hide the caption in case show_caption is equal  to "0"
 */
add_filter("shortcode_atts_caption", 'uf_shortcode_atts_caption', 10, 3);

/**
 * Filters wp captions atts to remove the caption in case show_caption is equal to "0"
 *
 * @param array $out The output array of shortcode attributes.
 * @param array $pairs The supported attributes and their defaults.
 * @param array $atts The user defined shortcode attributes.
 * @return mixed
 */
function uf_shortcode_atts_caption ($out, $pairs, $atts) {

	if (isset( $atts['show_caption'] ) && "0" == $atts['show_caption']) {
		$out['caption'] = "&nbsp;";
	}

	return $out;
}


/**
 * Filters image caption shortcode to generate uf caption specific markup
 */
add_filter("img_caption_shortcode", "uf_image_caption_shortcode", 10, 3);
/**
 * Uses img_caption_shortcode to add support for UF image variants
 *
 * @param string $out Out
 * @param array $attr Attributes attributed to the shortcode.
 * @param string $content Shortcode content.
 *
 * @return string|void
 */
function uf_image_caption_shortcode ($out, $attr, $content) {

	$is_wp_cation = strpos($attr["id"], "uinsert-" ) === false;

	if ($is_wp_cation) return; // returning null let's wp do it's own logic and rendering for caption shortcode

	$image_reg = preg_match('/src="([^"]+)"/', $content, $image_arr);
	$href_reg = preg_match('/href="([^"]+)"/', $content, $anchor_arr);

	$data = (object) shortcode_atts( array(
		'id'	  => '',
		'caption' => '',
		'class'   => '',
		'uf_variant' => '',
		'uf_isLocal' => true,
		'uf_show_caption' => true,
		'image' => $image_reg ? $image_arr[1] : "",
		'linkUrl' => $href_reg ? $anchor_arr[1] : "",

	), $attr, 'caption' );

	 return Upfront_Post_Data_PartView::get_post_image_markup($data);

}

/**
 * Loads iconfont in admin to display toolbar icon.
 */
function uf_admin_bar_styles() {
	wp_enqueue_style( 'uf-font-icons', Upfront::get_root_url() . '/styles/font-icons.css?t='.time());
}
add_action( 'admin_enqueue_scripts', 'uf_admin_bar_styles' );

/**
 * Gets rid of the admin notice and declares support for Woo
 */
function uf_add_woocommerce_support() {
	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'uf_add_woocommerce_support');

function jwpb_head() {
   do_action( 'jwpb_head' );
 }
 
add_action( 'jwpb_head', 'jwpb_head_content' );
function jwpb_head_content() {
  require_once(Upfront::get_root_dir()."/header.php");
}


function jwpb_footer() {
   do_action( 'jwpb_footer' );
 }
 
add_action( 'jwpb_footer', 'jwpb_footer_content' );
function jwpb_footer_content() {
  require_once(Upfront::get_root_dir()."/footer.php");
}

add_filter( 'page_template', 'jwpb_template' );
function jwpb_template( $template ) {
	if(can_use_template()){
		$template = WP_PLUGIN_DIR . '/jwpb/templates/jwpb-page-template.php';
	}

    return $template;
}

function can_use_template(){
	$is_built = get_post_meta(get_the_ID(),"upfront-uf_wp_page_template");
	$curr_link = $_SERVER['REQUEST_URI'];
	$request = array_map('trim', explode('/', $curr_link));
	
	$use_template = false;
	
	if(in_array("create_new",$request)) $use_template = true;
	if(in_array("maintenance",$request)) $use_template = true;
	if($is_built and !is_child_theme() and !is_archive()) $use_template = true;
	if(isset($_GET["editmode"])) $use_template = true;
	if(isset($_GET["page"])){
		if($_GET["page"] == "jwpb-builder") $use_template = true;
	} 
	
	if(is_child_theme()){
		if(is_front_page()){
			$use_template = true;
		}
	}  
	
	return $use_template;
}


function jwpb_metabox_disable_layout()
{
	 wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	 
    echo "<p>This page's layout is done by the JW Page Builder plugin. This will use the styles created with the page builder. Disable landing page builder layout if you wish to use your active theme layout for this page.</p>";
	
	echo '<input name="jwpb_disable_layout_checkbox" type="checkbox" value="true"> Disable JWPB Layout.';
}

function add_jwpb_meta_box()
{
    add_meta_box("disable-jwpb-layout", "Disable JW Page Builder Layout", "jwpb_metabox_disable_layout", "page", "side", "high", null);
}

function jwpb_show_page_metabox(){
	if(isset($_GET["post"])){
		$is_built = get_post_meta($_GET["post"],"upfront-uf_wp_page_template");
		if($is_built /* and (get_option("page_on_front") != get_the_ID()) */){
			add_action("add_meta_boxes", "add_jwpb_meta_box");
		}
	}
}

add_action("admin_init","jwpb_show_page_metabox");

function save_jwp_meta_box($post_id, $post, $update)
{
	if(isset($_POST["jwpb_disable_layout_checkbox"])){
       delete_post_meta($post_id,"upfront-uf_wp_page_template");
    }
}

add_action("save_post", "save_jwp_meta_box", 10, 3);
 
function remove_theme_styles(){
	global $wp_styles;
	$theme_uri =  get_template_directory_uri()."/style.css";
	foreach($wp_styles->registered as $handle){
		if(strpos($handle->src,$theme_uri) !== false){			
			if(can_use_template() and ((is_home())?get_option("show_on_front") == "page":true)){
				wp_dequeue_style($handle->handle);
				wp_deregister_style( $handle->handle );
			}
		}
	}
}
add_action('wp_enqueue_scripts','remove_theme_styles',100);

