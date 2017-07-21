<?php

require_once dirname(__FILE__) . '/lib/util.php';
require_once dirname(__FILE__) . '/lib/class_thx_l10n.php';

define('THX_BASENAME', basename(dirname(__FILE__)));
/* 
echo "<pre>";
print_r(wp_get_theme()->stylesheet);
echo "</pre>";
 */
class UpfrontThemeExporter{
	
	const DOMAIN = 'upfront_thx';
	
	private function __construct() {}
	
	public static function dispatch(){
		//$me = new self;
		return self::_serve_exporter();
	}
	
	/**
	 * Serves exporter, ready to work
	 *
	 * @return object
	 */
	private static function _serve_exporter () {
		$me = new self;
		$me->_add_hooks();
		return $me;
	}
	
	private function _add_hooks () {
		$this->_add_exposed_hooks();
		if (upfront_exporter_is_running()) {
			$this->_add_exporter_hooks();
		}
		
		$this->_add_global_hooks();
	}
	
	/**
	 * These hooks will *always* trigger even when doing AJAX either via admin or builder
	 */
	private function _add_exposed_hooks () {
		if ( is_admin() || upfront_exporter_is_running() ) {
			require_once(dirname(__FILE__) . '/lib/class_thx_exposed.php');
			Thx_Exposed::serve();
		}
	}
	
	/**
	 * Get the root slug in endpoint-agnostic manner
	 *
	 * @return string Root slug
	 */
	public static function get_root_slug () {
		return class_exists('Upfront_Thx_Builder_VirtualPage')
			? Upfront_Thx_Builder_VirtualPage::SLUG
			: 'create_new'
		;
	}
	
	/**
	 * Now, this is exporter-specific.
	 * Wait until Upfront is ready and set us up.
	 */
	private function _add_exporter_hooks () {
		require_once(dirname(__FILE__) . '/lib/class_thx_exporter.php');
		add_action('upfront-core-initialized', array('Thx_Exporter', 'serve'));
	}
	
	/**
	 * These hooks will *always* trigger.
	 * No need to wait for the rest of Upfront, set our stuff up right now.
	 */
	private function _add_global_hooks () {
		add_action('upfront-admin_bar-process', array($this, 'add_toolbar_item'), 10, 2);
		add_filter('extra_theme_headers', array($this, 'process_extra_child_theme_headers'));
		
		if (is_admin() && !(defined('DOING_AJAX') && DOING_AJAX)) {
			require_once(dirname(__FILE__) . '/lib/class_thx_admin.php');
			Thx_Admin::serve();
		}
		$this->_load_textdomain();
		
		// Add shared Upfront/Exporter JS resources
		add_action('upfront-core-inject_dependencies', array($this, 'add_shared_scripts'));
		add_filter('upfront_data', array($this, 'add_shared_data'));
		
		// Shared - context mode popup
		add_action('wp_ajax_upfront_thx-mode_context-skip', array($this, 'json_context_mode_skip'));
	}
	
	/**
	 * Adds the builder toolbar item
	 *
	 * @param object $toolbar Toolbar object
	 * @param array $item Upfront item
	 */
	public function add_toolbar_item ($toolbar, $item) {
		if (!Upfront_Permissions::current(Upfront_Permissions::BOOT)) return false;
		if (empty($item['meta'])) return false; // Only actual boot item has meta set

		$child = upfront_thx_is_current_theme_upfront_child();

		// Swap out root items
		$root_item_id = $item['id'];
		$new_item_root = 'upfront-editor_builder-hub';
		$new_item = array_merge($item, array(
			'id' => $root_item_id,
			'parent' => $new_item_root,
		));
		$item['id'] = $new_item_root;
		unset($item['meta']);
		unset($item['href']);

		$toolbar->add_node($item);
		$toolbar->add_node($new_item);

		// Now, let's make builder menu item expandable
		$toolbar->add_node(array(
			'id' => 'upfront-builder-hub',
			'parent' => $new_item_root,
			'title' => __('Builder', self::DOMAIN),
		));

		if ((bool)$child) {
			// Edit current
			$toolbar->add_menu(array(
				'parent' => 'upfront-builder-hub',
				'id' => 'upfront-builder-current_theme',
				'title' => __('Modify current theme', self::DOMAIN),
				'href' => home_url('/' . UpfrontThemeExporter::get_root_slug() . '/' . $child),
			));
		}
		// Create new
		$toolbar->add_menu(array(
			'parent' => 'upfront-builder-hub',
			'id' => 'upfront-builder-create_theme',
			'title' => __('Create new theme', self::DOMAIN),
			'href' => admin_url('admin.php?page=jwpb-builder'),
		));
	}
	
	/**
	 * Introduces additional theme headers, supported by exporter
	 *
	 * Filters the `extra_theme_headers` hook
	 *
	 * @param array $headers Existing headers
	 *
	 * @return array Augmented headers
	 */
	public function process_extra_child_theme_headers ($headers=array()) {
		if (!is_array($headers)) return $headers;

		if (!in_array('WDP ID', $headers)) $headers[] = 'WDP ID';
		if (!in_array('License', $headers)) $headers[] = 'License';
		if (!in_array('License URI', $headers)) $headers[] = 'License URI';

		return $headers;
	}
	
	/**
	 * Loads translations text domain for the plugin
	 */
	private function _load_textdomain () {
		load_plugin_textdomain(self::DOMAIN, false, dirname(__FILE__) . '/languages');
	}
	
	/**
	 * This is where we inject shared scripts
	 */
	public function add_shared_scripts () {
		if (!Upfront_Permissions::current(Upfront_Permissions::BOOT)) return false;

		$deps = Upfront_CoreDependencies_Registry::get_instance();
		$deps->add_script(plugins_url('app/shared.js', __FILE__));
		$deps->add_style(plugins_url('styles/shared.css', __FILE__));
	}
	
	/**
	 * Handle data augmentation for shared resource
	 *
	 * @param array $data Data gathered this far
	 *
	 * @return array Augmented data
	 */
	public function add_shared_data ($data) {
		$user_id = get_current_user_id();

		$data['exporter_shared'] = array(
			'context_mode' => (int)get_user_option('upfront-context_mode_skip', $user_id),
		);

		return $data;
	}
	
	/**
	 * Stores user preference regarding context mode popup
	 *
	 * AJAX request handler
	 */
	public function json_context_mode_skip () {
		$result = array('error' => 1);
		if (!Upfront_Permissions::current(Upfront_Permissions::BOOT)) return wp_send_json($result);

		$user_id = get_current_user_id();
		if (empty($user_id) || !is_numeric($user_id)) return wp_send_json($result);

		$skip = (int)get_user_option('upfront-context_mode_skip', $user_id);
		if ($skip) return wp_send_json($result);

		update_user_option($user_id, 'upfront-context_mode_skip', 1, true);
		wp_send_json(array(
			'error' => 0,
		));
	}
}

UpfrontThemeExporter::dispatch();