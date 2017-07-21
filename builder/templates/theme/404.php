<?php 

$layout = Upfront_Output::get_layout(Upfront_EntityResolver::get_entity_ids());

jwpb_head();
echo $layout->apply_layout();
jwpb_footer(); 