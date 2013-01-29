$(function(){
	$('.carousel').carousel({
		interval: 6000
	});

	$(".feature-box")
		.addClass("closed")
		.click(function() {
			var open = $(this).is(".open") ? true : false;

			if ( open ) {
				$(this).find(".details").slideUp();
				$(this).removeClass("open").addClass("closed");
			} else {
				$(this).find(".details").slideDown();
				$(this).removeClass("closed").addClass("open");
			}
		});

	$(".feature-box a").click(function(event) {
		event.stopPropagation()
	});
});




