jQuery( function ($) {
	if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ){
		jQuery( '.color' ).wpColorPicker();
	}
	else {
		$('.color').each(function () {
			if (this.id) {
				$('#cp_' + this.id).farbtastic('#' + this.id);
			}
		}).click(function() {
			$(this).next().show();
		});

		$('.colorpicker').hide();

		$(document).mousedown(function() {
			$('.colorpicker:visible').hide();
		});
	}

	(function () {

		$(".add-field").click(function(e){
			number = $(this).parent().siblings().length/4 + 1;
			string = '<label><input class="text_rotator_field" type="text" name="vt_general_settings[header_text_rotator_fields][quote][]" value="" />';
			string += ' Quote ' + number + '</label><br/><label><input class="text_rotator_field" type="text" name="vt_general_settings[header_text_rotator_fields][author][]" value="" />';
			string += ' Author ' + number + '</label><br/>';
			e.preventDefault();
			$(this).parents("td").append($(string));
		});
		$(".remove-field").click(function(e){
			e.preventDefault();
			if (!$(this).parent().siblings().length) return;
			$(this).parents("td").children().slice(-4).remove();
		});
	})();

	$(".enabler").change(function() {
		if (!this.checked) $("." + $(this).data("for")).attr("disabled", "disabled");
		else $("." + $(this).data("for")).removeAttr("disabled");
	})

	function vt_color_scheme_toggles() {

		colorScheme = $('#color_scheme');
		dependents = $('#link_color, #nmenu_color, #footer_color, #details_color');
		dependents.parents(".wp-picker-container").after('<span class="notify">Disabled</span>');
		colorScheme.parents(".wp-picker-container").after('<span class="notify">Disabled</span>');

		if ($(".color_scheme_enabler")[0].checked) {
			dependents.parents(".wp-picker-container").css("display", "none");
			dependents.parents(".wp-picker-container").next(".notify").css("display", "block");
		}
		else {
			colorScheme.parents(".wp-picker-container").css("display", "none");
			colorScheme.parents(".wp-picker-container").next(".notify").css("display", "block");
		}

		$(".color_scheme_enabler").change(function() {
			if (this.checked) {
				dependents.parents(".wp-picker-container").css("display", "none");
				dependents.parents(".wp-picker-container").next(".notify").css("display", "block");
				colorScheme.parents(".wp-picker-container").css("display", "block");
				colorScheme.parents(".wp-picker-container").next(".notify").css("display", "none");
			}
			else {
				dependents.parents(".wp-picker-container").css("display", "block");
				dependents.parents(".wp-picker-container").next(".notify").css("display", "none");
				colorScheme.parents(".wp-picker-container").css("display", "none");
				colorScheme.parents(".wp-picker-container").next(".notify").css("display", "block");
			}
		})
	}

	if ($('#color_scheme').length) {
		vt_color_scheme_toggles();
	}

	function vt_fwidget_color_toggle() {

		x = $("#fwidget_color");
		x.parents(".wp-picker-container").after('<span class="notify">Disabled</span>');
		if ($("#transparent_fwidget").attr("checked") == "checked") {
			x.parents(".wp-picker-container").css("display", "none");
			x.parents(".wp-picker-container").next(".notify").css("display", "block");
		}
		$("#transparent_fwidget").change(function() {
			if ($(this).attr("checked") == "checked") {
				x.parents(".wp-picker-container").css("display", "none");
				x.parents(".wp-picker-container").next(".notify").css("display", "block");
			}
			else {
				x.parents(".wp-picker-container").css("display", "block");
				x.parents(".wp-picker-container").next(".notify").css("display", "none");
			}
		})
	}

	if ($('#color_scheme').length) {
	vt_fwidget_color_toggle();
	}

	$('.tabbable').css("min-height", $('#wpbody').height());
	$('.tab-content').css("min-height", $('#wpbody').height());
});
