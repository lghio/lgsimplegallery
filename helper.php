<?php

defined('_JEXEC') or die('Access Deny');
jimport('joomla.filesystem.folder');

class modLgSimpleGallery
{
	
	//*******************************************
	//   lg GET IMAGES
	//*******************************************
	public static function lgGetImages(&$params) { 
		$lgDebug = $params->get('lg_debug');;
		if ( $lgDebug == '1') { echo "<BR> begin lgGetImages()"; }
		$lgMaxThumbWidth = $params->get('lg_max_thumb_width');;
		$lgMaxThumbHeight = $params->get('lg_max_thumb_height');;
		$lgThumbFolder = $params->get('lg_thumb_folder');;
		$lgSerieName = $params->get('lg_serie_name');
		
		if ( $lgDebug == '1') { echo "<BR> lgMaxThumbWidth=". $lgMaxThumbWidth; }
		if ( $lgDebug == '1') { echo "<BR> lgMaxThumbHeight=". $lgMaxThumbHeight; }
		if ( $lgDebug == '1') { echo "<BR> lgThumbFolder=". $lgThumbFolder; }
		if ( $lgDebug == '1') { echo "<BR> lgSerieName=". $lgSerieName; }
		
		$lgImageFolder = $params->get('lg_image_folder');;
		
		$lgDirImageFolder = JPATH_BASE.$params->get('lg_image_folder');
		if ( $lgDebug == '1') { echo "<BR> Image DIR folder:". $lgDirImageFolder; }
		if ( $lgDebug == '1') { echo "<BR> Image folder:". $lgImageFolder; }
		
		if (is_dir($lgDirImageFolder)) {
			$lgImages = array(); 
			
			// $lgExcludeExtension = array('.db','.svn', 'CVS','.DS_Store','__MACOSX','index.html');
			// $lgExcludeFilter = array('^\..*','.*~', '*.db');
			
			$lgAllowedExtensions = array('jpg', 'jpeg');
			
			// Also allow filetypes in uppercase
			$lgAllowedExtensions = array_merge($lgAllowedExtensions, array_map('strtoupper', $lgAllowedExtensions));
			// Build the filter. Will return something like: "jpg|png|JPG|PNG|gif|GIF"
			$lgFilter = implode('|',$lgAllowedExtensions);
			$lgFilter = "^.*\.(" . implode('|',$lgAllowedExtensions) .")$";
			if ( $lgDebug == '1') { echo "<BR> lgFilter=". $lgFilter; }
	
			if ( $lgDebug == '1') { echo "<BR> begin filesFromFolder($lgDirImageFolder)"; }
			// $filesFromFolder = JFolder::files($lgDirImageFolder, '.', false, false, $lgExcludeExtension, $lgExcludeFilter );
			$filesFromFolder = JFolder::files($lgDirImageFolder, $lgFilter);
			
			if ( $lgDebug == '1') { echo "<BR> loop"; }
			$i=0;
			foreach ($filesFromFolder as $lgImageFilename) { 
				// $lgImageURL = JURI::root().DS.$lgImageFolder.DS.$params->get('imagefolder').'/'.$lgImageFilename;
				$lgImageURL = $lgImageFolder."/".$lgImageFilename;
				if ( $lgDebug == '1') { echo "<BR> lgImageURL=". $lgImageURL; }
				
				$lgFulPathToImage = $lgDirImageFolder.DS.$lgImageFilename;
				if ( $lgDebug == '1') { echo "<BR> lgFulPathToImage=". $lgFulPathToImage; }
				
				$lgImageInfo = getimagesize( $lgFulPathToImage );
				if( empty( $lgImageInfo ) ) {	echo "<BR>The file " . $lgFulPathToImage . " doesn't seem to be an image."; }
				$lgImageWidth = $lgImageInfo[ 0 ];
				$lgImageHeight = $lgImageInfo[ 1 ];
				if ( $lgDebug == '1') { echo "<BR> width=".$lgImageWidth."   height=".$lgImageHeight; }
				
				// -------- creation du thumbnail
				if (! extension_loaded('gd')) {	
					if ( $lgDebug == '1') { echo "<BR> GD library not installed !!!"; }
					}
				else {
					if ( $lgDebug == '1') { echo "<BR> GD library ready";  }
					$lgThumbFilename = self::lgResizeImage( $lgFulPathToImage, $lgMaxThumbWidth, $lgMaxThumbHeight, $lgThumbFolder, $params );
					if ( $lgDebug == '1') { echo "<BR> thumb file created=". $lgThumbFilename; }
					}
				
				$lgThumbURL = $lgImageFolder."/".$lgThumbFolder."/".$lgImageFilename;
				$lgThumbFullPath = $lgDirImageFolder.DS.$lgThumbFolder.DS.$lgImageFilename;;
				list($lgThumbWidth, $lgThumbHeight) = getimagesize($lgThumbFullPath);
				
				// $listitem = "<li><img alt='' src='".$lgImageURL."' /></li>";
				// array_push($lgImages, $listitem);
				// array_push($lgImages, $lgImageURL);
				$lgImages[$i]['serie-name']=$lgSerieName;
				$lgImages[$i]['image-url']=$lgImageURL;
				$lgImages[$i]['image-width']=$lgImageWidth;
				$lgImages[$i]['image-height']=$lgImageHeight;
				$lgImages[$i]['thumb-filename']=$lgThumbFilename;
				$lgImages[$i]['thumb-url']=$lgThumbURL;
				$lgImages[$i]['max-thumb-width']=$lgMaxThumbWidth;
				$lgImages[$i]['max-thumb-height']=$lgMaxThumbHeight;
				$lgImages[$i]['thumb-width']=$lgThumbWidth;
				$lgImages[$i]['thumb-height']=$lgThumbHeight;
				
				$i++;
				}
			
			if ( $lgDebug == '1') { echo "<BR> end lgGetImages(): ". var_dump($lgImages); }
			return $lgImages;
			}
		else {
			if ( $lgDebug == '1') { echo "<BR> no images found"; }
			}
	}
	
	
	//*******************************************
	//   lg LOAD OWN JQUERY
	//*******************************************
	public static function lgLoadOwnJquery(&$params){
		$lgDebug = $params->get('lg_debug');
		$lgLoadOwnJquery = $params->get('lg_load_own_jquery');
		
		$doc = JFactory::getDocument();

		if ( $lgDebug == '1') {	echo "<BR>============== JQUERY =========";	}
		if ( $lgDebug == '1') { echo "<BR> begin lgLoadOwnJquery"; }
		
		if ( $lgLoadOwnJquery == '1' ) {
			$jqueryfilepath = JURI::root(true).'/modules/mod_lgsimplegallery/js/jquery-1.11.1.min.js';
			if ( $lgDebug == '1') { echo "<BR> load own jquery(".$jqueryfilepath.")"; }
			$doc->addScript($jqueryfilepath);
			// $doc->addScript(JURI::root(true).'/modules/mod_lgsimplegallery/js/noconflict.js');
			if ( $lgDebug == '1') { echo "<BR> after load own jquery"; }
			}	
		else {
			if ( $lgDebug == '1') { echo "<BR> inherit jquery"; }
			}
		}
	//*******************************************
	//   lg LOAD JAVASCRIPT
	//*******************************************
	public static function lgLoadJavascript(&$params){
		$lgDebug = $params->get('lg_debug');
		$lgLoadOwnLightbox = $params->get('lg_load_own_lightbox');
        $lgDisplayStyle = $params->get('lg_display_style');

		$doc = JFactory::getDocument();
		if ( $lgDebug == '1') {	echo "<BR>============== JAVASCRIPT LIGHTBOX =========";	}
		if ( $lgDebug == '1') { echo "<BR> begin lgLoadJavascript"; }
		if ( $lgDebug == '1') { echo "<BR> lgLoadOwnLightbox=". $lgLoadOwnLightbox; }
		
		//------------- lgSimpleGallery javascript ------------------
		$jsfilepath = JURI::root(true).'/modules/mod_lgsimplegallery/js/lgsimplegallery.js';
		$doc->addScript($jsfilepath);
		
		
		//------------- lightbox ------------------
		if ( $lgLoadOwnLightbox == '1' ) {
			$jsfilepath = JURI::root(true).'/modules/mod_lgsimplegallery/js/lightbox.min.js';
			if ( $lgDebug == '1') { echo "<BR> load lightbox javascript(".$jsfilepath.")"; }
			$doc->addScript($jsfilepath);
			}
		else {
			if ( $lgDebug == '1') { echo "<BR> inherit lightbox"; }
			}
	
		//------------- masonry ------------------
		if ( $lgDisplayStyle == 'masonry' ) {
			$jsfilepath = JURI::root(true).'/modules/mod_lgsimplegallery/js/masonry.pkgd.min.js';
			if ( $lgDebug == '1') { echo "<BR> load masonry javascript(".$jsfilepath.")"; }
			$doc->addScript($jsfilepath);
			}
		else {
			if ( $lgDebug == '1') { echo "<BR> inherit masonry"; }
			}
		
		if ( $lgDebug == '1') { echo "<BR> end lgLoadJavascript"; }
		}

		
	//*******************************************
	//   lg RESIZE IMAGE
	//*******************************************
	static function lgResizeImage($filename, $maxwidth, $maxheight, $thumbfolder, &$params) {
		$lgDebug = $params->get('lg_debug');;
		$lgForceSquare = $params->get('lg_force_square');

		if ( $lgDebug == '1') { echo "<BR> begin lgResizeImage(".$filename.")"; }
		
		list($imgwidth, $imgheight) = getimagesize($filename);
		if ( $lgDebug == '1') { echo "<BR> input width=". $imgwidth; }
		if ( $lgDebug == '1') { echo "<BR> input height=". $imgheight; }
		if ( $lgDebug == '1') { echo "<BR> input image ratio =". $imgwidth/$imgheight; }
		if ( $lgDebug == '1') { echo "<BR> max width=". $maxwidth; }
		if ( $lgDebug == '1') { echo "<BR> max height=". $maxheight; }
		
		// if image is already smaller than thumbnail max size, then do nothing
		if ( $imgwidth < $maxwidth & $imgheight < $maxheight ) {
			$newwidth = $imgwidth;
			$newheight = $imgheight;
			}
		else {
			if ( $lgForceSquare == '1') {
				$newwidth = $maxwidth;
				$newheight = $maxwidth;
				}
			else {
				$ratiowidth = $maxwidth / $imgwidth; 
				$ratioheight = $maxheight / $imgheight;
				if ( $lgDebug == '1') { echo "<BR> ratiowidth=". $ratiowidth; }
				if ( $lgDebug == '1') { echo "<BR> ratioheight=". $ratioheight; }
				$zoom = min( $ratiowidth, $ratioheight);
				if ( $lgDebug == '1') { echo "<BR> zoom=". $zoom; }
			
				$newwidth = $imgwidth * $zoom;
				$newheight = $imgheight * $zoom;
				}
			}
		
		// manage the square format
		$lgOffsetX = 0;
		$lgOffsetY = 0;
		if ( $lgForceSquare == '1') {
			// horizontal rectangle
			if ($imgwidth > $imgheight) {
				$square = $imgheight;              // $square: square side length
				$lgOffsetX = ($imgwidth - $imgheight) / 2;  // x offset based on the rectangle
				$lgOffsetY = 0;              // y offset based on the rectangle
			}
			// vertical rectangle
			elseif ($imgheight > $imgwidth) {
				$square = $imgwidth;
				$lgOffsetX = 0;
				$lgOffsetY = ($imgheight - $imgwidth) / 2;
			}
			// it's already a square
			else {
				$square = $imgwidth;
				$lgOffsetX = $lgOffsetY = 0;
				}
			$imgwidth = $square;    // source image dimensions are cropped to square
			$imgheight = $square;   // source image dimensions are cropped to square
			$newheight = $newwidth; // dest image is also square
			}
		
		if ( $lgDebug == '1') { echo "<BR> image width source recalculated for square =". $imgwidth; }
		if ( $lgDebug == '1') { echo "<BR> image height source recalculated for square =". $imgheight; }
		if ( $lgDebug == '1') { echo "<BR> lgOffsetX=". $lgOffsetX; }
		if ( $lgDebug == '1') { echo "<BR> lgOffsetY=". $lgOffsetY; }
		if ( $lgDebug == '1') { echo "<BR> new image ratio =". $newwidth/$newheight; }
				
		// round up to integer
		$newwidth = ceil($newwidth);
		$newheight = ceil($newheight);
		if ( $lgDebug == '1') { echo "<BR> new width=". $newwidth; }
		if ( $lgDebug == '1') { echo "<BR> new height=". $newheight; }
		
		
		// If thumb folder already exists then skip
		$lgFileParts = pathinfo($filename);
		$lgThumbFolder = $lgFileParts['dirname'].DS.$thumbfolder;
		if ( ! is_dir($lgThumbFolder) ) {
			if ( $lgDebug == '1') { echo "<BR> need to create folder for thumbs =".$lgThumbFolder; }
			mkdir($lgThumbFolder);
			}
		
		// define thumb filename
		$lgThumbFilename = self::lgGetThumbFilename($params, $filename, $thumbfolder);
		if ( $lgDebug == '1') { echo "<BR> lgThumbFilename=".$lgThumbFilename; }
			
		// if thumbnail already exists and same size, no need to re-create the file
		if ( file_exists($lgThumbFilename) ) {
			list($lgThumbWidth, $lgThumbHeight) = getimagesize($lgThumbFilename);
			if ( ($lgThumbWidth == $newwidth) &&  ($lgThumbHeight == $newheight) ) {
				if ( $lgDebug == '1') { echo "<BR> Thumbnail file already exists with same size = ".$lgThumbFilename; }
				return $lgThumbFilename;
				}
			}
		
		$source = imagecreatefromjpeg($filename);
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		// imagecopyresized($thumb, $source, 0, 0, $lgOffserX, $lgOffserY, $newwidth, $newheight, $imgwidth, $imgheight);
		imagecopyresampled($thumb, $source, 0, 0, $lgOffserX, $lgOffserY, $newwidth, $newheight, $imgwidth, $imgheight);
		if ( $lgDebug == '1') { echo "<BR> write image"; }
		imagejpeg($thumb, $lgThumbFilename);
		if ( $lgDebug == '1') { echo "<BR> end lgResizeImage() "; }
		return $lgThumbFilename;
		}
	
	
	//------------------------------------------
	// lgGetThumbFilename()
	//       create thumbnail filename
	//------------------------------------------
	static function lgGetThumbFilename($params, $filename, $thumbfolder) {
		$lgDebug = $params->get('lg_debug');;
		// define thumb filename
		$lgFileParts = pathinfo($filename);
		// $lgThumbFilenameExt = end(explode('.', $filename));
		// $lgThumbFilename = $lgFileParts['dirname'].DS."thumb".DS.$lgFileParts['filename']."_".$thumbfolder.".".$lgFileParts['extension'];
		$lgThumbFilename = $lgFileParts['dirname'].DS."thumb".DS.$lgFileParts['filename'].".".$lgFileParts['extension'];
		if ( $lgDebug == '1') { 
			// echo "<BR> 1) lgThumbFilenameExt=". $lgThumbFilenameExt; 
			echo "<BR> 1) lgThumbFilename=". $lgThumbFilename; 
			echo "<BR> 1) dirname=". $lgFileParts['dirname'], "\n";
			echo "<BR> 1) basename=". $lgFileParts['basename'], "\n";
			echo "<BR> 1) extension=". $lgFileParts['extension'], "\n";
			echo "<BR> 1) filename=". $lgFileParts['filename'], "\n"; 
			}
		return $lgThumbFilename;
		}

	//------------------------------------------
	//   CREATE CSS dynamically
	//------------------------------------------
	static function lgCreateCss($params) {
		$lgColorImageShadow = $params->get('lg_color_image_shadow');
		
		$cssFileContent = "";
		
		/*
		$cssFileContent .= "
			.lg-image-shadow {
				box-shadow: 2px 2px 2px ".$lgColorImageShadow." ;
				}
			";
		*/
		
		return $cssFileContent;
		}
}



?>
