(function ($){

$(window).load(function () {
	config = $('#storage').data('config');
	animation = $('#slider_meta').data('options');
	$('.flexslider').flexslider({
		animation: animation,
		controlNav: false,
	});

	if (typeof google == 'object' && google) {
		(function initialize() {
			$(".google_maps").each( function () {
				coords = $.extend({
					latitude: 0,
					longitude: 0,
					zoom: 3
				}, $(this).data('coordinates'));
				var mapProp = {
					center:new google.maps.LatLng(coords.latitude, coords.longitude),
					zoom: coords.zoom,
					mapTypeId:google.maps.MapTypeId.ROADMAP,
					};
				map = new google.maps.Map(this, mapProp)
				var marker = new google.maps.Marker({
					position: map.getCenter(),
					map: map,
					title: 'Click to zoom'
				});
			})
		})();
	}

});// end $(window).load(S)

$(document).ready(function($){

config = $('#storage').data('config');

	$('.carousel_wrapper').each(function (i) {
		$(this).attr("id", "carousel" + i);
		ref = this;

		params = {
			onSliderLoad: function(ref){
			$("#carousel" + i).height("auto");
			},
			minSlides: 2,
			maxSlides: 4,
			slideMargin: 20,
			pager: false,
			moveSlides: 2
		}

		carousel = $(".carousel", this);
		options = carousel.data('options');
		width = parseFloat(options.width) || 220;
		if (options.max_items !== undefined) params.maxSlides = parseInt(options.max_items);
		if (options.item_margin !== undefined) params.slideMargin = parseFloat(options.item_margin);
		if (options.move_slides !== undefined) params.moveSlides = parseInt(options.move_slides);
		params.slideWidth = width;
		if (options.top) {
			params.nextSelector = "#carousel" + i + " .cust-bx-next";
			params.prevSelector = "#carousel" + i + " .cust-bx-prev";
		}

		$(carousel).bxSlider(params);
		if (options.top) {
			$("a", '.cust-bx-next').css("background", "url('" + config.img_path + "images/square_controls.png') 0 0");
			$("a", '.cust-bx-prev').css("background", "url('" + config.img_path + "images/square_controls.png') -24px 0");
		}
	});

	function hextorgb(hex) {
		color = config.color_scheme.substring(1,7);
		r = parseInt(color.substring(0,2), 16);
		g = parseInt(color.substring(2,4), 16);
		b = parseInt(color.substring(4,6), 16);
	
		return {r: r, g: g, b: b};
	}

function rgb2hsv () {
	var rr, gg, bb,
	r = arguments[0] / 255,
	g = arguments[1] / 255,
	b = arguments[2] / 255,
	h, s,
	v = Math.max(r, g, b),
	diff = v - Math.min(r, g, b),
	diffc = function(c){
		return (v - c) / 6 / diff + 1 / 2;
	};

	if (diff == 0) {
		h = s = 0;
	} else {
		s = diff / v;
		rr = diffc(r);
		gg = diffc(g);
		bb = diffc(b);

		if (r === v) {
			h = bb - gg;
		}else if (g === v) {
			h = (1 / 3) + rr - bb;
		}else if (b === v) {
			h = (2 / 3) + gg - rr;
		}
		if (h < 0) {
			h += 1;
		}else if (h > 1) {
			h -= 1;
		}
	}
	return {
		h: Math.round(h * 360),
		s: Math.round(s * 100),
		v: Math.round(v * 100)
	};
}

/* Good nav menu animation and arrows */

$(".nav-menu li").each(function() {

	if ($(this).has('ul').length)
		if ($(this).parent('.nav-menu').length) $(this).children('a').append('<i class="icon-angle-down">');

	var blur = 0, spread = 0, enteree, leavee, timeout;
	$(this).mouseenter(function(e) {
		$($(this).parent()).trigger("pseudoleave");
		$(this).css("background-color", "rgba(255,255,255,0.5)");
		if (!Modernizr.boxshadow) {
			if ($(this).parents("li").length) $(this).parents("li").css("filter", "alpha(Opacity=100)")
			$(this).css({"background-color": "rgb(255, 255, 255)", "filter": "alpha(Opacity=50)"});
			return;
		}
		blur = 37, spread = 37;
	})
	$(this).mouseleave(function(e) {
		if (e) { $(this).css("background-color", "transparent")
			a = $(this).parents("li")[0];
			e.stopPropagation; clearTimeout(timeout);
			var relTarg = e.relatedTarget || e.toElement;
			if (!Modernizr.boxshadow) {
				$(this).css("filter", "alpha(Opacity=100)");
				if ($(relTarg).parent().is(a)) $(a).css({"background-color": "rgb(255, 255, 255)", "filter": "alpha(Opacity=50)"});
				return;
			}
			if ($(relTarg).parent().is(a)) {
				$(a).trigger("pseudoenter");
			};
		}
		if (!leavee) leavee = this;
		if (blur >= 0) $(leavee).css("box-shadow", "0 0 " + blur-- + "px " + spread-- + "px " + "rgba(255,255,255,0.5) inset");
		else {return;}
		timeout = setTimeout(arguments.callee, 5);
	})
	$(this).on("pseudoleave", function(e) {
		if (e) e.stopPropagation; $(this).css("background-color", "transparent");
		if (!leavee) leavee = this;
		if (blur >= 0) $(leavee).css("box-shadow", "0 0 " + blur-- + "px " + spread-- + "px " + "rgba(255,255,255,0.5) inset");
		else {return;}
		timeout = setTimeout(arguments.callee, 5);
	})
	$(this).on("pseudoenter", function(e) {
		if (!$(this).is(e.target)) return;
		$(this).css("background-color", "rgba(255,255,255,0.5)");
		blur = 37, spread = 37;
	})
})

function image_covers() {
	var r, g, b;

	if (config.color_scheme.charAt(0) == '#') {
		color = config.color_scheme.substring(1,7);
		r = parseInt(color.substring(0,2), 16);
		g = parseInt(color.substring(2,4), 16);
		b = parseInt(color.substring(4,6), 16);
	}
	else if (config.color_scheme.charAt(0) == 'r'){
		match = regex.exec(config.color_scheme);
		r = parseInt(match[1]);
		g = parseInt(match[2]);
		b = parseInt(match[3]);
	}
	
	color = "rgba(" + r + ", " + g + ", " + b + ", 0.5)";
	$('.port_img').each(function() {
		var blur = 0, spread = 0, enteree, leavee, timeout, inc;
		$(this).mouseenter(function(e) {

			if (!enteree) enteree = $(this).find('[class^="vt_img_cover"]');
			stop = parseInt(enteree[0].clientHeight);
			mgwidth = parseInt(enteree[0].clientWidth)/2;
			stop = stop/2;

			otop = (stop - 12) + 'px';
			right = (mgwidth - 12) + 'px';
			$(".vt_mg", this).css({
				'visibility': 'visible',
				'top': otop,
				'right': right
			})
			if (!Modernizr.boxshadow) {
				enteree.css({"background-color": "rgb(" + r + ", " + g + ", " + b + ")", "filter": "alpha(Opacity=50)"});
				return;
			}

			blur = spread = stop;
			inc = stop/20;
			$(enteree).css("box-shadow", "0 0 " + blur + "px " + spread + "px " + color + " inset");
		});
		$(this).mouseleave(function(e) {
			if (!Modernizr.boxshadow) {
				$('[class^="vt_img_cover"]', this).css({"filter": "alpha(Opacity=0)"});
				$(".vt_mg", this).css("visibility", "hidden");
				return;
			}

			$(".vt_mg", this).css("visibility", "hidden");
			if (!leavee) leavee = $(this).find('[class^="vt_img_cover"]');
			leavee.css("box-shadow", "0 0 0 0 " + color + " inset");
		});
	})
}
if ($('#port_group').length) {
	image_covers();
}

/* newsfeed widget */
	function newsfeed() {
		var i = 0, arr = $('.vt_news_feed_item'); var elem;
		$(arr[0]).css("display", "block");
		function x() {
			elem = $(arr[i]);
			i++;
			if (i == arr.length) i = 0;
			elem.fadeOut(2000, 'easeInOutQuart', y);
			function y() {
				$(arr[i]).css("display","block");
			}
			setTimeout(x, 5000);
		}
		x();
	}
	newsfeed();

/* Global setup */
	$("#storage").data("window", $(window).width())
	$('#port_group img').removeAttr('width');
	$('.post-edit-link').addClass('vt_global_text');
	$('ul.filter').find('a').addClass('vt_global_text');
	function vt_append_arrow() {
		parents = $(".nav-menu").children().find("li").has("ul").children("a").append('<i class="icon-angle-right">');
		arrows = $("i:last-child", parents);
		fstring = arrows.css("font-size"); 
		fs = parseFloat(fstring)/2;
		arrows.css({
			"position": "absolute",
			"top": "50%",
			"margin-top": "-" + fs + "px",
		});
	}
	vt_append_arrow();

/* Dropdowns */
	$(".nav-menu li").has("ul").hover(function(){
		$(this).addClass("current").children("ul").fadeIn(500, 'easeInOutQuart');
	}, function() {
		$(this).removeClass("current").children("ul").stop(true, true).css("display", "none");
	});

/* Portfolio Quicksand */

function portfolio_quicksand() {
	$filter = $('.filter li.active a').attr('class');  
	$filterLink = $('.filter li a');  
	$container = $('div.port_group');  
	$containerClone = $container.clone();
	var $filteredItems;

	$filterLink.click(function(e) {
		$('.filter li').removeClass('active');  
		$filter = $(this).attr('class').split(' ')[0];  
		$(this).parent().addClass('active');

		if ($filter == 'all') {  
			$filteredItems = $containerClone.find('div.port_item');   
		}  
		else {  
			$filteredItems = $containerClone.find('div[data-type~=' + $filter + ']');   
		}
		$container.quicksand($filteredItems, {
			duration: 500,  
			easing: 'easeInQuint',
			adjustWidth: false
		});

		$container.quicksand($filteredItems,   
			function () { 
				lightbox(); 
				image_covers();
			}  
		);

	});

};//end portfolio_quicksand();


if($().quicksand) {  
	portfolio_quicksand();
}

/* Responsive Theme */
var our_menu = $(".nav-menu");
var html = '<select id="shrunk-menu">';
var ind = 0;

function walker (index, ul) {
	lis = $(ul).children();
	if (lis.is("ul")) lis = lis.children();
	lis.each( function (){
		li = $(this);
		anchor = li.children("a");
		pref = '';
		for (i=0; i<ind; i++) {pref += '&nbsp;';};
		html += '<option value="' + anchor.attr("href") + '">' + pref + anchor.text() + '</option>';
		chl = li.children('ul');
		if (chl.length){
			ind++;
			chl.each(walker);
		}
	});
ind--;
};
walker(0, ".nav-menu");
html += "</select>";
var select = $(html);

our_menu.parent().append(select);

$('#shrunk-menu').change(function () {
	document.location = $(this).val();
})

$(window).resize(function(e) {
	$('.port_item').attr('style', '');
})

$(window).resize(function() {
	$('.port_group').attr('style', '');
})

function lightbox() {
jQuery("a[rel^='prettyPhoto']").prettyPhoto({  
	animationSpeed:'fast',  
	slideshow:5000,  
	theme:'pp_default',  
	show_title:false,  
	overlay_gallery: false,  
	social_tools: false  
}); 
}

if(jQuery().prettyPhoto) {
	lightbox();  
}

/* Onhover Portfolio */

$(".vt_img_cover").hover(
	function () {
		$(this).find("img").fadeIn(200);
	},
	function () {
		$(this).find("img").fadeOut(200);
});

(function () {
	max = 0;
	$(".footer-section").each(function () {
		if ($(this).height() > max) max = $(this).height();
	})
	$(".footer-divider").height(max - 130);
})();

$('.accordion').accordion();
});//end $(document).ready();


})(jQuery); 