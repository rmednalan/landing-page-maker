<?php
return '<?php
$main = upfront_create_region(array(
	"name" => "main",
	"title" => __("Main Area"),
	"scope" => "local",
	"type" => "wide",
	"default" => true,
	"allow_sidebar" => true
), array(
	"row" => 140,
	"background_type" => "color",
	"background_color" => "#c5d0db"
));

$main->add_element("PostData", array (
  "columns" => "24",
  "margin_left" => "0",
  "margin_top" => "0",
  "class" => "upfront-post_data_module",
  "id" => "module-1467787537272-1394",
  "options" =>
  array (
    "data_type" => "post_data",
    "row" => 40,
    "type" => "PostDataModel",
    "view_class" => "PostDataView",
    "has_settings" => 1,
    "class" => "c24 upost-data-object upost-data-object-post_data",
    "id_slug" => "post-data",
    "type_parts" =>
    array (
      0 => "date_posted",
      1 => "title",
      2 => "content",
    ),
    "date_posted_format" => "F j, Y g:i a",
    "content" => "content",
    "post-part-date_posted" => "<div class=\"upostdata-part date_posted\">
	Posted on <span class=\"date\">{{date}}</span></div>",
    "post-part-title" => "<div class=\"upostdata-part title\">
	<h1>{{title}}</h1>
</div>
",
    "post-part-content" => "<div class=\"upostdata-part content\">
	{{content}}
</div>",
    "preset" => "default",
    "element_id" => "post-data-object-1467787537271-1215",
    "top_padding_num" => 15,
    "bottom_padding_num" => 15,
    "use_padding" => "yes",
    "usingNewAppearance" => true,
  ),
  "row" => 40,
  "wrapper_id" => "wrapper-1467787553104-1347",
  "new_line" => true,
  "wrapper_breakpoint" =>
  array (
    "tablet" =>
    array (
      "clear" => true,
      "col" => 12,
      "order" => 1,
    ),
    "current_property" =>
    array (
      0 => "order",
    ),
    "mobile" =>
    array (
      "clear" => true,
      "col" => 7,
      "order" => 1,
    ),
  ),
  "objects" =>
  array (
    0 =>
    array (
      "columns" => "24",
      "class" => "upfront-post-data-part part-title",
      "view_class" => "PostDataPartView",
      "part_type" => "title",
      "wrapper_id" => "wrapper-1467787537270-1335",
      "type" => "PostDataPartModel",
      "id_slug" => "post-data-part",
      "element_id" => "post-data-part-object-1467787537270-1762",
      "padding_slider" => 15,
      "use_padding" => "yes",
      "wrapper_breakpoint" =>
      array (
        "tablet" =>
        array (
          "clear" => true,
          "col" => 0,
          "order" => 2,
        ),
        "current_property" =>
        array (
          0 => "order",
        ),
        "mobile" =>
        array (
          "clear" => true,
          "col" => 0,
          "order" => 2,
        ),
      ),
    ),
    1 =>
    array (
      "columns" => "24",
      "class" => "upfront-post-data-part part-content",
      "view_class" => "PostDataPartView",
      "part_type" => "content",
      "wrapper_id" => "wrapper-1467787537270-1603",
      "type" => "PostDataPartModel",
      "id_slug" => "post-data-part",
      "element_id" => "post-data-part-object-1467787537271-1078",
      "padding_slider" => 15,
      "use_padding" => "yes",
      "wrapper_breakpoint" =>
      array (
        "tablet" =>
        array (
          "clear" => true,
          "col" => 0,
          "order" => 3,
        ),
        "current_property" =>
        array (
          0 => "order",
        ),
        "mobile" =>
        array (
          "clear" => true,
          "col" => 0,
          "order" => 3,
        ),
      ),
    ),
  ),
));

$regions->add($main);';