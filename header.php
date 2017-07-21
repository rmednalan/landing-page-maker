<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/respond/respond.js"></script>
	<![endif]-->
	<style>
	#sidebar-ui,.upfront-loading.upfront-boot,
	#region-settings-sidebar .upfront-region-modal-bg{background:#1b2e4e;}
	#sidebar-ui .sidebar-commands-header{
		background: #87919d; /* For browsers that do not support gradients */
		background: -webkit-linear-gradient(#a2b2c2, #87919d); /* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(#a2b2c2, #87919d); /* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(#a2b2c2, #87919d); /* For Firefox 3.6 to 15 */
		background: linear-gradient(#a2b2c2, #87919d); /* Standard syntax */
	}
	#sidebar-ui .command-logo .upfront-logo{background-image:none;}
	#sidebar-ui .command-logo .upfront-logo:before{content:"JWPB";color:#fff;font-weight: 900;
    font-size: 25px;}
	#sidebar-ui .sidebar-commands-primary .command-new-page, #sidebar-ui .sidebar-commands-primary .command-new-post,.sidebar-panel-tabspane li.active{background:#000;color:#fff;}
	#sidebar-ui .sidebar-panel-title{background:#a2b2c2;color:#000;}
	#sidebar-ui ul.sidebar-panel-tabspane{background:#a2b2c2;}
	.sidebar-panel-tabspane li{color:#ffff00;}
	#sidebar-ui .sidebar-panel-title:before{background:#fff;}
	
	#sidebar-ui a.ueditor-btn-edit,
	#sidebar-ui .command-link,
	#sidebar-ui .command-edit-css span, #sidebar-ui .command-open-font-manager span{color:#0000ff;}
	#sidebar-ui .command-edit-css span, #sidebar-ui .command-open-font-manager span{border-bottom:1px solid #0000ff;}
	
	#upfront-inline-tooltip{padding:0 2px;}
	</style>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site clearfix jwpb-editmode">