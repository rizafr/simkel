$(function(){
		$(document.body).append('<div id="page-loader"></div>');
	$(window).on("beforeunload", function() {
		$('#page-loader').fadeIn(500).delay(3000).fadeOut(5000);
	});
});