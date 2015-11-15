<?php

defined('_JEXEC') or die('Access Deny');


/*
function debug_to_console($data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('default.PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('default.PHP: ".$data."');</script>");
	}
}
*/


?>

<DIV id="lgParams" 
		data-lg-display-style = "<?php echo $lgDisplayStyle; ?>"
        data-lg-color-image-shadow="<?php echo $lgColorImageShadow; ?>"
		data-lg-masonry-max-width="<?php echo $lgMasonryMaxWidth; ?>"
		data-lg-masonry-image-width="<?php echo $lgMasonryImageWidth; ?>"
		data-lg-max-thumb-width="<?php echo $lgMaxThumbWidth; ?>"
		>
</DIV>
			
<!-- ************* Standard **************** -->
<?php
if ( $lgDisplayStyle == "standard" ) {
	debug_to_console("==> standard");
?>
<DIV id="lgSimpleGallery">
	<DIV id="<?php echo $lgHeaderClass ; ?>">
		<DIV id="<?php echo $image['serie-name']."-photo" ; ?>">
		<h1><?php echo $lgGalleryTitle ; ?></H1>

		<?php
		// lg_listOfImages

		if ( $lgDebug == '1') { var_dump($lgListOfImages); }

			$i=0;
			foreach ($lgListOfImages as $image) { 
		?>
				
				<DIV 	data-lightbox="<?php echo $image['serie-name'] ; ?>"  
						class="lgImageItem lg-caption-<?php echo $lgCaptionStyle; ?>" 
						style="width:<?php echo $image['max-thumb-width']."px"; ?> "
						>
					<div class="lg-caption">
						<h3>Caption Title</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						<p><a href="#" class="learn-more">Learn more</a></p>
					</div>
					<a 
						data-lightbox="<?php echo $image['serie-name'] ; ?>" 
						lgCaptionHover="caption"
						href="<?php echo $image['image-url'] ; ?>">
						<IMG src="<?php echo $image['thumb-url'] ; ?>" 
							class="<?php echo $lgImageShadow; ?>" 
							>
					</a>
					
					
					
				</DIV>
		<?php
				
				$i++;
				}


		?>
		</DIV>

	</DIV>
</DIV>
<?php
}
?>


<!-- *************------------------------------------------------------------ Carousel **************** -->
<?php
if ( $lgDisplayStyle == "carousel" ) {
?>
	<div id="carousel">
<?php
		// console.info("===> CAROUSEL");  /* ne fonctionne pas */
		debug_to_console("==> carousel");
		// lg_listOfImages

		if ( $lgDebug == '1') { var_dump($lgListOfImages); }

			$i=0;
			foreach ($lgListOfImages as $image) { 
?>
				<div class="item">
                    <!-- <img src="<?php echo $image['image-url'] ; ?>" /> -->
        
                    <a 
						data-lightbox="<?php echo $image['serie-name'] ; ?>" 
						lgCaptionHover="caption"
						href="<?php echo $image['image-url'] ; ?>">
						<IMG src="<?php echo $image['thumb-url'] ; ?>" 
							class="<?php echo $lgImageShadow; ?>" 
							>
					</a>
                </div>
<?php
				$i++;
				}
?>
	</div>

<?php
}
?>


    
    
    
<?php
/*--------------------------------------------------------------------- MASONRY -------------*/
if ( $lgDisplayStyle == "masonry" ) {
	if ( $lgDebug == '1') { var_dump($lgListOfImages); }

?>
<div id="masonry">
<?php
		// console.info("===> MASONRY");  /* ne fonctionne pas */
		// debug_to_console("==> MASONRY");
		// lg_listOfImages


			$i=0;
			foreach ($lgListOfImages as $image) { 
?>
				<div class="item lg-image-shadow">
                    <!-- <img src="http://photolg.felo.fr<?php echo $image['image-url'] ; ?>" /> -->
    
                    <a 
						data-lightbox="<?php echo $image['serie-name'] ; ?>" 
						lgCaptionHover="caption"
						href="<?php echo $image['image-url'] ; ?>">
						<IMG src="<?php echo $image['thumb-url'] ; ?>" 
							class="<?php echo $lgImageShadow; ?>" 
							>
					</a>
                </div>
<?php
				$i++;
				}
?>
</div>
<?php
}
?>

    

    
<?php
/*--------------------------------------------------------------------- PACKERY -------------*/
if ( $lgDisplayStyle == "packery" ) {
	if ( $lgDebug == '1') { var_dump($lgListOfImages); }

?>
<div id="packery">
<?php
    $i=0;
			foreach ($lgListOfImages as $image) { 
?>
				<div class="item lg-image-shadow">
                    <!-- <img src="http://photolg.felo.fr<?php echo $image['image-url'] ; ?>" /> -->
    
                    <a 
						data-lightbox="<?php echo $image['serie-name'] ; ?>" 
						lgCaptionHover="caption"
						href="<?php echo $image['image-url'] ; ?>">
						<IMG src="<?php echo $image['thumb-url'] ; ?>" 
							class="<?php echo $lgImageShadow; ?>" 
							>
					</a>
                </div>
<?php
				$i++;
				}
?>
</div>
<?php
}
?>



