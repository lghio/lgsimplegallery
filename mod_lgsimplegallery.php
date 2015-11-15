<?php

defined('_JEXEC') or die('Access Deny');


function debug_to_console($data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('default.PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('default.PHP: ".$data."');</script>");
	}
}


$lgModuleId	= $module->id;
$lgDebug = $params->get('lg_debug');;
// $lgClassName = $params->get('lg_class_name');;
$lgGalleryTitle = $params->get('lg_gallery_title');;
// $lgCustom_css = $params->get('lg_custom_css');;
$lgImageFolder = $params->get('lg_image_folder');;
$lgMaxThumbHeight = $params->get('lg_max_thumb_height');;
$lgMaxThumbWidth = $params->get('lg_max_thumb_width');;
$lgLoadOwnJquery = $params->get('lg_own_jquery');;
$lgLoadOwnLightbox = $params->get('lg_load_own_lightbox');;
$lgHeaderClass = $params->get('header_class');
$lgThumbFolder = $params->get('lg_thumb_folder');
$lgForceSquare = $params->get('lg_force_square');
$lgSerieName = $params->get('lg_serie_name');
$lgCaptionStyle = $params->get('lg_caption_style');
if ( $params->get('lg_image_shadow') == '1' ) {$lgImageShadow="lg-image-shadow";} else {$lgImageShadow="";}
$lgColorImageShadow = $params->get('lg_color_image_shadow');
$lgDisplayStyle = $params->get('lg_display_style');
$lgMasonryImageWidth = $params->get('lg_masonry_image_width');
$lgMasonryMaxWidth = $params->get('lg_masonry_max_width');
$lgCarouselMaxWidth = $params->get('lg_carousel_max_width');

// ------- DISPLAY DEBUG INFO
if ( $lgDebug == '1') {
	echo "<BR>LG simple Gallery welcome<BR>";
	echo "<BR> path to helper.php:". dirname(__FILE__).DS.'helper.php';
	echo "<BR> Debug information:";
	echo "<BR>lg_debug = ". $lgDebug;
	echo "<BR>lg_module_id = ". $lgModuleId;
	echo "<BR>lg_foldername = ". $lgFoldername;
	// echo "<BR>lg_class_name = ". $lgClassName;
	echo "<BR>lg_gallery_title = ". $lgGalleryTitle;
	// echo "<BR>lg_custom_css = ". $lgCustom_css;
	echo "<BR>lg_image_folder = ". $lgImageFolder;
	echo "<BR>lg_max_thumb_height = ". $lgMaxThumbHeight;
	echo "<BR>lg_max_thumb_width = ". $lgMaxThumbWidth;
	echo "<BR>lg_load_own_jquery = ". $lgLoadOwnJquery;
	echo "<BR>lg_load_own_lightbox = ". $lgLoadOwnLightbox;
	echo "<BR>lg_header_class = ". $lgHeaderClass;
	echo "<BR>lg_thumb_folder = ". $lgThumbFolder;
	echo "<BR>lg_force_square = ". $lgForceSquare;
	echo "<BR>lg_serie_name = ". $lgSerieName;
	echo "<BR>lg_caption_style = ". $lgCaptionStyle;
	echo "<BR>lg_image_shadow = ". $lgImageShadow;
	echo "<BR>lg_color_image_shadow = ". $lgColorImageShadow;
	echo "<BR>lg_display_style = ". $lgDisplayStyle;
	echo "<BR>lg_masonry_image_width = ". $lgMasonryImageWidth;
	echo "<BR>lg_masonry_max_width = ". $lgMasonryMaxWidth;
	echo "<BR>lg_carousel_max_width = ". $lgCarouselMaxWidth;
	debug_to_console('\n lg_display_style = '. $lgDisplayStyle);
}

// ---------- add CSS
$doc = JFactory::getDocument();
if ( $lgDebug == '1') { echo "<BR> load CSS"; }
$doc->addStyleSheet(JURI::base(true) . '/modules/mod_lgsimplegallery/css/lgsimplegallery.css', 'text/css' );
// $document->addStyleDeclaration( $lgCustom_css );
// lightbox CSS
$doc->addStyleSheet(JURI::base(true) . '/modules/mod_lgsimplegallery/css/lightbox.css', 'text/css' );
// $doc->addStyleSheet(JURI::base(true) . '/modules/mod_lgsimplegallery/css/screen.css', 'text/css' );

if ( $lgDebug == '1') { echo "<BR> load helper"; }
require_once (dirname(__FILE__).DS.'helper.php');

// ------------ add JQUERY
if ( $lgDebug == '1') { echo "<BR> load jquery"; }
modLgSimpleGallery::lgLoadOwnJquery($params);
// --------- add Javascript: lightbox, etc.
modLgSimpleGallery::lgLoadJavascript($params);
// --------- add Javascript (example)
// $doc->addScript(JURI::base(true) . '/modules/mod_lgsimplegallery/js/jquery.flexslider-min.js');
$doc->addScript(JURI::base(true) . '/modules/mod_lgsimplegallery/js/masonry.pkgd.min.js');
$doc->addScript(JURI::base(true) . '/modules/mod_lgsimplegallery/js/packery.pkgd.min.js');

// ----------- GET IMAGES FROM FOLDER
// call helper.php - function
if ( $lgDebug == '1') { echo "<BR>before lgGetImages"; }
$lgListOfImages = modLgSimpleGallery::lgGetImages($params);
if ( $lgDebug == '1') { echo "<BR> list of images:". $lgListOfImages; }

// ------------- add dynamic CSS --------------
$lgCssFileContent = modLgSimpleGallery::lgCreateCss($params);
if ( $lgDebug == '1') { echo "<BR> lgCssFileContent=". $lgCssFileContent; }
$doc->addStyleDeclaration($lgCssFileContent);

// -------- RENDER OUTPUT HTML PAGE
// call default.php in tmpl folder
require(JModuleHelper::getLayoutPath('mod_lgsimplegallery'));

?>

