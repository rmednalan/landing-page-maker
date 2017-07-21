<script type="text/javascript">
jQuery(document).on("upfront-load", function () {
	/* alert("<?php echo esc_url($root_url); ?>");
	alert("<?php echo esc_url($includes_url); ?>");
	alert("<?php echo esc_url($admin_url); ?>");
	alert("<?php echo esc_url($themes); ?>"); */
	
	var jwpb_date = new Date();
	var jwpb_time = jwpb_date.getTime();
	
	Upfront.themeExporter = {
		root: '<?php echo esc_url($root_url); ?>',
		includes: '<?php echo esc_url($includes_url); ?>',
		admin_url: '<?php echo esc_url($admin_url); ?>',
		themes: <?php echo json_encode($themes) ?>,
		templates: [
			{filename: 'archive-home', name: 'Home'},
			{filename: 'single', name: 'Single'}
		],
		currentTheme: '<?php echo wp_get_theme()->get_stylesheet() ?>',
		current_layout_label: <?php echo json_encode($layout); ?>
	};
	require(['<?php echo esc_url($root_url) ?>app/main.js?t'+jwpb_time], function () {
		Upfront.Util.log("Booting exporter");
	});
});
</script>