$(document).ready(function() {
		$(".fancybox").fancybox({
			openEffect		: 'elastic',
			closeEffect		: 'elastic',
//			autoPlay		: 'false',
			helpers	: {
				title	: {
					type: 'inside'
				},
				thumbs	: {
					width	: 75,
					height	: 75
				}
			}
		});
});