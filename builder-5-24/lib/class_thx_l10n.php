<?php

class Thx_L10n {

	private static $_data = array();

	private function __construct () {
		$this->_populate_strings();
	}

	public static function serve () {
		$me = new self;
		$me->_add_hooks();
	}

	private function _add_hooks () {
		add_filter('upfront_l10n', array($this, 'add_l10n_strings'));
	}

	public function add_l10n_strings ($strings) {
		if (!empty($strings['exporter'])) return $strings;
		$strings['exporter'] = self::get();
		return $strings;
	}

	/**
	 * Main data getter.
	 * Can return a prepared string, a key or an array of strings, depending on the parameter.
	 *
	 * @param bool $key Optional key parameter. If passed a true-ish value, a string is returned. Otherwise, an array
	 *
	 * @return mixed String if `$key` parameter is passed, array otherwise
	 */
	public static function get ($key=false) {
		return !empty($key)
			? (!empty(self::$_data[$key]) ? self::$_data[$key] : $key)
			: self::$_data
		;
	}

	/**
	 * Populates internal string storage.
	 */
	private function _populate_strings () {
		self::$_data = array(
			'plugin_name' => __('Builder', UpfrontThemeExporter::DOMAIN),
			// Inherited from Upfront core l10n server
			'long_loading_notice' => __('The Upfront builder may take a while to load (especially first time), please hang in there :)', UpfrontThemeExporter::DOMAIN),
			'page_layout_name' => __('Page name (leave empty for single-page.php)', UpfrontThemeExporter::DOMAIN),
			'start_fresh' => __('Start fresh', UpfrontThemeExporter::DOMAIN),
			'start_from_existing' => __('Start from existing layout', UpfrontThemeExporter::DOMAIN),
			'create_new_layout' => __('Create New Layout', UpfrontThemeExporter::DOMAIN),
			'edit_saved_layout' => __('Edit Saved Layout', UpfrontThemeExporter::DOMAIN),
			'export_str' => __('Save Theme', UpfrontThemeExporter::DOMAIN),
			'create_responsive_layouts' => __('Responsive', UpfrontThemeExporter::DOMAIN),
			'edit_grid' => __('Edit Grid', UpfrontThemeExporter::DOMAIN),

			// modal.js
			'manage_layouts' => __('Manage Layouts', UpfrontThemeExporter::DOMAIN),
			'create_layout' => __('Create Layout', UpfrontThemeExporter::DOMAIN),
			'edit_layout' => __('Edit Layout', UpfrontThemeExporter::DOMAIN),
			'edit_existing_layout' => __('Edit Existing Layout', UpfrontThemeExporter::DOMAIN),
			'loading' => __('Loading...', UpfrontThemeExporter::DOMAIN),
			'activate_theme' => __('Activate Theme', UpfrontThemeExporter::DOMAIN),
			'activate_message' => __('Do you want to activate', UpfrontThemeExporter::DOMAIN),
			'theme' => __('theme', UpfrontThemeExporter::DOMAIN),
			'yes' => __('Yes', UpfrontThemeExporter::DOMAIN),
			'no' => __('No', UpfrontThemeExporter::DOMAIN),

			// sidebar.js
			'current_layout' => __('Current Layout: <b>%s</b>', UpfrontThemeExporter::DOMAIN),
			'layouts' => __('Layouts', UpfrontThemeExporter::DOMAIN),
			'media' => __('Media', UpfrontThemeExporter::DOMAIN),
			'theme_images' => __('Media', UpfrontThemeExporter::DOMAIN),
			'theme_sprites' => __('UI / Sprites', UpfrontThemeExporter::DOMAIN),
			'my_themes' => __('My Themes', UpfrontThemeExporter::DOMAIN),
			'themes' => __('Themes', UpfrontThemeExporter::DOMAIN),

			// post_image.js
			'image_variant' => __('Image Variant', UpfrontThemeExporter::DOMAIN),
			'edit_content_style' => __('Edit Content Layout', UpfrontThemeExporter::DOMAIN),
			'edit_image_insert' => __('Edit Image Insert', UpfrontThemeExporter::DOMAIN),
			'variant_name' => __('Name This Insert:', UpfrontThemeExporter::DOMAIN),
			'variant_css' => __('Edit CSS', UpfrontThemeExporter::DOMAIN),
			'variant_wrap_label' => __('Wrapper', UpfrontThemeExporter::DOMAIN),
			'variant_wrap_info' => __('Wrapper', UpfrontThemeExporter::DOMAIN),
			'variant_image_label' => __('Image', UpfrontThemeExporter::DOMAIN),
			'variant_image_info' => __('Image', UpfrontThemeExporter::DOMAIN),
			'variant_caption_label' => __('Caption', UpfrontThemeExporter::DOMAIN),
			'variant_caption_info' => __('Caption', UpfrontThemeExporter::DOMAIN),

			// mode context dialog (application.js)
			'builder_mode_context' => __('<p>This is builder interface, this is where you create/edit a distributable theme.</p><p>This means that any changes you make using this interface will be saved to your theme folder.</p>', UpfrontThemeExporter::DOMAIN),
			'editor_mode_context' => __('<p>This is editor interface, this is where you make site-specific adjustments.</p><p>This means that any changes you make using this interface will be specific to your site, overriding any changes made with Builder.</p>', UpfrontThemeExporter::DOMAIN),
			'user_agrees' => __('Okay, I got it', UpfrontThemeExporter::DOMAIN),
			'dont_show_again' => __('Never show this again', UpfrontThemeExporter::DOMAIN),

		);
	}
}
Thx_L10n::serve();