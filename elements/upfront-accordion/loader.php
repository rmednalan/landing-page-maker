<?php
/*
Plugin Name: Uaccordion module
Plugin URI: http://premium.wpmudev.org/project/upfront
Description: Complex Upfront module for adding and editing panelbed items.
Version: 0.1
Text Domain: uaccordion
Author: Incsub
Author URI: http://premium.wpmudev.org

Copyright 2009-2013 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * Registers the element in Upfront
 */
function uaccordion_initialize () {
	// Include the backend support stuff
	require_once (dirname(__FILE__) . '/lib/uaccordion.php');
	require_once (dirname(__FILE__) . '/lib/class_upfront_accordion_presets_server.php');

	// Expose our JavaScript definitions to the Upfront API
	upfront_add_layout_editor_entity('uaccordion', upfront_relative_element_url('js/uaccordion', __FILE__));

	add_filter('upfront_l10n', array('Upfront_UaccordionView', 'add_l10n_strings'));

	// Add element defaults to data object
	$uaccordion = new Upfront_UaccordionView(array());
	add_action('upfront_data', array($uaccordion, 'add_js_defaults'));

	// Add the public stylesheet
	add_action('wp_enqueue_scripts', array('Upfront_UaccordionView', 'add_styles_scripts'));
}

//Hook it when Upfront is ready
add_action('upfront-core-initialized', 'uaccordion_initialize');