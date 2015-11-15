/*
	Library name: LG Simple Gallery
	Author: Laurent GHIO
	Version: 1.0.0
	Date: December 13th 2014

*/


// avoid conflict with multiple JQUERY: 
(function($) {
    $(window).load(function(event) {
        console.log("Jquery est pret!");
		
		// var color=$lgColorImageShadow;
		//var color	= '#eeeeee';
		
		// immediately apply the new shadow color
		//console.log(" load lg-image-shadow ");
		//$('.lg-image-shadow').css({ boxShadow: "1px 3px 6px "+color+"" });
		
		// Retrieve data attributes from HTML TAG
        var lgParams = $('#lgParams');
        
        var lgDisplayStyle=lgParams.attr('data-lg-display-style');
        console.log(" lgDisplayStyle=" + lgDisplayStyle );
		var lgColorImageShadow=lgParams.attr('data-lg-color-image-shadow');
		console.log(" lgColorImageShadow=" + lgColorImageShadow );
		var lgMasonryMaxWidth=lgParams.attr('data-lg-masonry-max-width');
		console.log(" lgMasonryMaxWidth=" + lgMasonryMaxWidth );
		var lgMasonryImageWidth=lgParams.attr('data-lg-masonry-image-width');
		console.log(" lgMasonryImageWidth=" + lgMasonryImageWidth );
		var lgMaxThumbWidth=lgParams.attr('data-lg-max-thumb-width');
		console.log(" lgMaxThumbWidth=" + lgMaxThumbWidth );
        

		// $('.lg-image-shadow').css({ boxShadow: '1px 3px 6px ' + lgColorImageShadow + '' });
		
		$('.lg-image-shadow').hover(
			function() {
				$(this).css({ boxShadow: '1px 2px 2px ' + lgColorImageShadow + '' });
				}
			);
		$('.lg-image-shadow').mouseout(
			function() {
				$(this).css({ boxShadow: '0px 0px 0px black' });
				}
			);
				
		/*
		$('img').click(
			function() {
				console.log(" click image");
				}
			);
		*/
		
		$('.lg-caption-standard').hover(
			// hover
			function() {
				console.log(" hover lg-caption-standard");
				$(this).find('.lg-caption').show();
				},
			// not hover
			function() {
				$(this).find('.lg-caption').hide();
				}
			);

			$('.lg-caption-fade').hover(
			// hover
			function() {
				console.log(" hover lg-caption-fade");
				$(this).find('.lg-caption').fadeIn(250);
				},
			// not hover
			function() {
				$(this).find('.lg-caption').fadeOut(250);
				}
			);
		
		$('.lg-caption-slide').hover(
			// hover
			function() {
				console.log(" hover lg-caption-slide");
				$(this).find('.lg-caption').slideDown(250);
				},
			// not hover
			function() {
				$(this).find('.lg-caption').slideUp(250);
				}
			);
	
		// change shadow color of images
		/*
		$('.lg-image-shadow').hover(
			function() {
				console.log(" load lg-image-shadow ");
				$(this).find('.lg-image-shadow').css({ boxShadow: '1px 3px 6px blue' });
				}
			);
		*/
	
	
		//--------------------- Carousel -----------------------
		/*
		function maBoucle(){
			setTimeout(function(){
				alert('Bonjour !'); // affichera "Bonjour !" toutes les secondes
				maBoucle(); // relance la fonction
				}, 1000);
			}
		
		maBoucle(); // on oublie pas de lancer la fonction une première fois
		*/

		/*
			<div id="carousel">
				<ul>
					<li><img src="http://lorempixel.com/700/200/" /></li>
					<li><img src="http://lorempixel.com/g/700/200/" /></li>
					<li><img src="http://lorempixel.com/700/200/abstract/" /></li>
				</ul>
			</div>
			
			#carousel{
				position:relative;
				height:200px;
				width:700px;
				margin:auto;
				}
			#carousel ul li{
				position:absolute;
				top:0;
				left:0;
				}
		*/
        
        function slideImg(){
                setTimeout(function(){ // on utilise une fonction anonyme

                        if(i < indexImg){ // si le compteur est inférieur au dernier index
                        i++; // on l'incrémente
                    }
                    else{ // sinon, on le remet à 0 (première image)
                        i = 0;
                    }

                    $img.css('display', 'none');

                    $currentImg = $img.eq(i);
                    $currentImg.css('display', 'block');

                    slideImg(); // on oublie pas de relancer la fonction à la fin

                    }, 7000); // on définit l'intervalle à 7000 millisecondes (7s)
                }
        
        
	   if ( lgDisplayStyle == "carousel" ) {
    
            var $carousel = $('#carousel'), // on cible le bloc du carousel
                $img = $('#carousel .item'), // on cible les images contenues dans le carousel
                indexImg = $img.length - 1, // on définit l'index du dernier élément
                i = 0, // on initialise un compteur
                $currentImg = $img.eq(i); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)

            $img.css('display', 'none'); // on cache les images
            $currentImg.css('display', 'block'); // on affiche seulement l'image courante

            $carousel.append('<div class="controls"> <span class="prev">Precedent</span> <span class="next">Suivant</span> </div>');


            $('.next').click(function(){ // image suivante
                    i++; // on incrémente le compteur
                    if( i <= indexImg ){
                        $img.css('display', 'none'); // on cache les images
                        $currentImg = $img.eq(i); // on définit la nouvelle image
                        $currentImg.css('display', 'block'); // puis on l'affiche
                    }
                    else{
                        i = indexImg;
                    }
                });


            $('.prev').click(function(){ // image précédente
                    i--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"
                    if( i >= 0 ){
                        $img.css('display', 'none');
                        $currentImg = $img.eq(i);
                        $currentImg.css('display', 'block');
                    }
                    else{
                        i = 0;
                    }
                });

            slideImg(); // enfin, on lance la fonction une première fois
            }
	
    
        
        
        
    /*----------------------------------------*/
    /* --------------- MASONRY -------------- */
	/*----------------------------------------*/
    
	if ( lgDisplayStyle == "masonry" ) {
    
        var masonry = document.querySelector('#masonry');
        masonry.style.maxWidth = lgMasonryMaxWidth + 'px';
    
        /* change la width de l'item dans le CSS avant de lancer le masonry qui re-cree un nouvel ensemble */
        var items = document.querySelectorAll('#masonry .item');
        for (var i = 0; i < items.length; i++) {
            /* items[i].style.backgroundColor = 'yellow'; */
            /* items[i].style.width = lgMaxThumbWidth + 'px'; */
            }


        var container = document.querySelector('#masonry');
        // init
        var pckry = new Packery( container, {
                                            // options
                                            itemSelector: '.item',
                                            gutter: 10
                                            }
                               );

        }
	
    /*----------------------------------------*/
    /* --------------- PACKERY -------------- */
	/*----------------------------------------*/
    if ( lgDisplayStyle == "packery" ) {
    
        var container = document.querySelector('#packery');
        // init
        var pckry = new Packery( container, {
                                            // options
                                            itemSelector: '.item',
                                            gutter: 10
                                            }
                               );

        }
	
	
	/* ---------------------------------- */
	
	
    }); // on windows load() 
	
	
})(jQuery);






//--------------------------- NOT USED -----------------------------------------------
//--------------------------- NOT USED -----------------------------------------------
//--------------------------- NOT USED -----------------------------------------------
//--------------------------- NOT USED -----------------------------------------------
//--------------------------- NOT USED -----------------------------------------------

/*
// the $ isn't yet defined at this time, because it is called before de jQuery call,
// and your script will fail on that first line on console.
JQuery(document).ready(
	function($) {
		// alert("jquery is ready!");
		console.log("Jquery est pret!");
		
		}
	);
*/

// If the jQuery plugin call is next to the </body>, 
// and your script is loaded before that, 
// you need to put your code inside this, like this example:
// LGO - got an error: Uncaught TypeError: object is not a function
/*
window.onload = function($) { 
	//YOUR JQUERY CODE 
	// alert("jquery is ready!");
	console.log("Jquery est pret!");
	
	$('img').click(function() {
		console.log(" click image");
		});

}
*/

/*
---------------- PROTOTYPE -------------------------------------
All objects have a prototype property. It is simply an object from which other objects can inherit properties

function Person(name) {
    this.name = name;
}
Person.prototype.sayHello = function () {
    alert(this.name + " says hello");
};

var james = new Person("James");
james.sayHello(); // Alerts "James says hello"

*/


