
$(document).ready(function() {

	$(window).scroll(function(e) {
		var y = $(this).scrollTop();
		var h = $("body").height();
		var wh = $(window).height();
		var p = Math.round(10*y/(h-wh))*10;
		console.log("Scrolled: "+p+"%");
		$("#fond").removeClass().addClass("scrolled"+p);
		if (p>=10)
			$("#fond").addClass("scrolled");
		if (p>=30)
			$("#fond").addClass("more-scrolled");

	});
});
