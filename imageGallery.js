$(document).ready(function() {
				
				
	// wrap each img in link 
	$(".gallery-image").each(function(indexImage){
		
		// change url of the image
	//	var src = $(this).find("img").attr("src");//.split("/").pop(); 
	//	src = src+".png";
		
		// create link 
	//	$(this).find("img").wrap('<a class="gallery-link" href="'+src+'" title="" target="_gallery_slideshow"></a>');
		
		// change url of the image
	//	$(this).find("img").attr("src", src);
					
	});
	
	// make normal images clickable
	$(".confluence-embedded-image").each(function(){
		
		src = $(this).attr("src");
		var title = $(this).attr("title");
		$(this).wrap('<a class="single-link" href="'+src+'" title="'+title+'"></a>');
		
	}); 
	
	
	// name each gallery
	$(".gallery").each(function(indexGallery){
		$(this).find("a").attr("rel", "gallery-"+indexGallery);
	});
	
	$('.single-link').fancybox();
	$('.gallery-link').fancybox({'type' : 'image'});

});