<?php 
/* Template Name: JWPB - Page Template */ 
//echo "been here";
/*  echo "<pre>";
print_r(Upfront_EntityResolver::get_entity_ids());
echo "</pre>"; 

$home = array
	(
		"specificity" => "archive-home",
		"item"=> "archive-home",
		"type"=> "archive"
	);
  */
$layout = Upfront_Output::get_layout(Upfront_EntityResolver::get_entity_ids());
//$layout = Upfront_Output::get_layout($home);

jwpb_head();
echo $layout->apply_layout();
jwpb_footer(); 

