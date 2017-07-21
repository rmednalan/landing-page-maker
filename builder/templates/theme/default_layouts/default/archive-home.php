<?php
return
'<?php
$layout_version = "1.0.0";

$main = upfront_create_region(
			array (
  "name" => "main",
  "title" => "Main Area",
  "type" => "wide",
  "scope" => "local",
  "container" => "main",
  "position" => 10,
  "allow_sidebar" => true,
),
			array (
  "row" => 200,
  "background_type" => "color",
  "background_color" => "rgba(247,247,247,1)",
  "version" => "1.0.0",
  "breakpoint" =>
  (array)(array(
     "tablet" =>
    (array)(array(
       "edited" => false,
       "col" => 24,
    )),
     "mobile" =>
    (array)(array(
       "edited" => false,
       "col" => 24,
    )),
  )),
  "use_padding" => 0,
  "sub_regions" =>
  array (
    0 => false,
  ),
  "bg_padding_type" => "varied",
  "top_bg_padding_slider" => 0,
  "top_bg_padding_num" => 0,
  "bottom_bg_padding_slider" => 0,
  "bottom_bg_padding_num" => 0,
  "bg_padding_slider" => 0,
  "bg_padding_num" => 0,
)
			);

$main->add_element("PlainTxt", array (
  "columns" => "24",
  "margin_left" => "0",
  "margin_right" => "0",
  "margin_top" => "0",
  "margin_bottom" => "0",
  "class" => "module-1468409923827-1672",
  "id" => "module-1468409923827-1672",
  "options" =>
  array (
    "view_class" => "PlainTxtView",
    "id_slug" => "plain_text",
    "content" => "<h2 style=\"text-align: center;\">Welcome to the Homepage of ". wp_get_theme()->get("Name") ."</h2>",
    "type" => "PlainTxtModel",
    "element_id" => "text-object-1468409923826-1943",
    "class" => "c24 upfront-plain_txt",
    "has_settings" => 1,
    "preset" => "default",
    "padding_slider" => 15,
    "top_padding_num" => 15,
    "bottom_padding_num" => 15,
    "use_padding" => "yes",
    "usingNewAppearance" => true,
    "lock_padding" => "",
    "padding_number" => 15,
    "left_padding_num" => 15,
    "right_padding_num" => 15,
    "anchor" => "",
    "current_preset" => "default",
    "breakpoint_presets" =>
    (array)(array(
       "desktop" =>
      (array)(array(
         "preset" => "default",
      )),
    )),
    "is_edited" => true,
    "theme_style" => "",
  ),
  "row" => 6,
  "sticky" => false,
  "default_hide" => 0,
  "hide" => 0,
  "toggle_hide" => 1,
  "wrapper_id" => "wrapper-1468409954037-1564",
  "edited" => true,
  "new_line" => true,
  "wrapper_breakpoint" =>
  array (
    "tablet" =>
    array (
      "clear" => true,
      "col" => 12,
      "order" => 2,
    ),
    "mobile" =>
    array (
      "clear" => true,
      "col" => 7,
      "order" => 2,
    ),
    "current_property" =>
    array (
      0 => "order",
    ),
  ),
  "breakpoint" =>
  array (
    "tablet" =>
    array (
      "col" => 12,
    ),
    "current_property" =>
    array (
      0 => "col",
    ),
    "mobile" =>
    array (
      "col" => 7,
    ),
  ),
));

$main->add_element("PlainTxt", array (
  "columns" => "24",
  "margin_left" => "0",
  "margin_top" => "0",
  "class" => "",
  "id" => "module-1468468185982-1850",
  "options" =>
  array (
    "content" => "<p style=\"text-align: center;\">Get started building right away.</p>",
    "type" => "PlainTxtModel",
    "view_class" => "PlainTxtView",
    "element_id" => "text-object-1468468185981-1427",
    "class" => "c24 upfront-plain_txt",
    "has_settings" => 1,
    "id_slug" => "plain_text",
    "preset" => "default",
    "padding_slider" => 15,
    "top_padding_num" => 15,
    "bottom_padding_num" => "0",
    "use_padding" => "yes",
    "usingNewAppearance" => true,
    "is_edited" => true,
    "lock_padding" => "",
    "padding_number" => 15,
    "left_padding_num" => 15,
    "right_padding_num" => 15,
    "anchor" => "",
    "current_preset" => "default",
    "bottom_padding_use" => "yes",
    "bottom_padding_slider" => "0",
    "row" => 12,
  ),
  "row" => 12,
  "wrapper_id" => "wrapper-1468471260996-1730",
  "edited" => true,
  "new_line" => true,
  "wrapper_breakpoint" =>
  array (
    "tablet" =>
    array (
      "clear" => true,
      "col" => 12,
      "order" => 3,
    ),
    "current_property" =>
    array (
      0 => "order",
    ),
    "mobile" =>
    array (
      "clear" => true,
      "col" => 7,
      "order" => 3,
    ),
  ),
  "breakpoint" =>
  array (
    "tablet" =>
    array (
      "col" => 12,
    ),
    "current_property" =>
    array (
      0 => "col",
    ),
    "mobile" =>
    array (
      "col" => 7,
    ),
  ),
));

$main->add_element("Uspacer", array (
  "columns" => "10",
  "class" => "upfront-module-spacer",
  "id" => "module-1468471512621-1498",
  "options" =>
  array (
    "type" => "UspacerModel",
    "view_class" => "UspacerView",
    "element_id" => "spacer-object-1468471512621-1659",
    "class" => "c24 upfront-object-spacer",
    "has_settings" => 0,
    "id_slug" => "uspacer",
  ),
  "wrapper_id" => "wrapper-1468471512619-1439",
  "default_hide" => 1,
  "toggle_hide" => 0,
  "hide" => 0,
  "edited" => true,
  "new_line" => true,
));

$main->add_element("Uspacer", array (
  "columns" => "10",
  "class" => "upfront-module-spacer",
  "id" => "module-1468471515177-1567",
  "options" =>
  array (
    "type" => "UspacerModel",
    "view_class" => "UspacerView",
    "element_id" => "spacer-object-1468471515176-1792",
    "class" => "c24 upfront-object-spacer",
    "has_settings" => 0,
    "id_slug" => "uspacer",
  ),
  "wrapper_id" => "wrapper-1468471515175-1153",
  "default_hide" => 1,
  "toggle_hide" => 0,
  "hide" => 0,
  "edited" => true,
));

$regions->add($main);';