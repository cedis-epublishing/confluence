$(document).ready(function() {
				
	// remove name of wiki from title
	var newTitle = $("#title-text").html().split(" : ");
	$("#title-text").html(newTitle[1]);
				
	// wrap each img in link 
	$(".gallery-image").each(function(indexImage){
		
		// change url of the image
		var src = $(this).find("img").attr("src").split("/").pop();
		src = "http://localhost/ojs/index.php/index/publicfiles/download/1/"+src+".png";
		
		// create link 
		$(this).find("img").wrap('<a class="gallery-link" href="'+src+'" title="" target="_gallery_slideshow"></a>');
		
		// change url of the image
		$(this).find("img").attr("src", src);
					
	});
	
	// change the urls of normal images
	$(".confluence-embedded-image").each(function(){
		var src = $(this).attr("src").split("/").pop();
		src = "http://localhost/ojs/index.php/index/publicfiles/download/1/"+src;
		$(this).attr("src", src);
	});
					
	// name each gallery
	$(".gallery").each(function(indexGallery){
		$(this).find("a").attr("rel", "gallery-"+indexGallery);
	});
			
	$('.gallery-link').fancybox();
				
});