jQuery(document).ready(function ($) {

	$('.insert-into-input').css({
		'color':'#0074A3',
		'cursor':'pointer',
		'text-decoration':'none',
		'border-bottom':'1px #0074A3 dotted'
	});

	$('.insert-into-input').on('click', function(event) {
		event.preventDefault();
		var targetInput = $(this).data('targetinput');
		$('#'+targetInput).val($(this).text());
	});



	//Conditionally toggle metabox' visibility if other metabox' checkbox is checked
	function show_metaboxes_on_condition($checkbox, $toggled_box, inverse) {
		inverse = typeof inverse !== 'undefined' ? inverse : false;
		if ($checkbox.length && $toggled_box.length) {
			$toggled_box = $toggled_box.parents('.rwmb-field');
			$toggled_box.hide();
			if (inverse === false) {
				if ($checkbox.is(':checked')) {
					$toggled_box.show();
				}
			} else {
				if (!$checkbox.is(':checked')) {
					$toggled_box.show();
				}
			}
			$checkbox.on('change', function() {
				$toggled_box.toggle();
			});
		}
	}

	show_metaboxes_on_condition($('#lmmb_languages_is_closed'), $('#lmmb_languages_start_month'));


	//Toggle metabox display based on slider value (other metabox)
	if ($('#lmmb_pages_modules_levels_desc_extremum').length && $('#lmmb_pages_modules_number').length) {
		var $slider = $('#lmmb_pages_modules_number');
		var $extr_textbox = $('#lmmb_pages_modules_levels_desc_extremum').parents('.rwmb-field');
		var $extr_textbox_label = $('#lmmb_pages_modules_levels_desc_extremum_longdesc');
		$extr_textbox.hide();

		var slider_min = $slider.slider( "option", "min" );
		var slider_max = $slider.slider( "option", "max" );

		if ($slider.slider('value') === slider_min || $slider.slider('value') === slider_max) {
			$extr_textbox.show();
		}
		if ($slider.slider('value') === slider_min) {
			$extr_textbox_label.text($extr_textbox_label.data('longdesc_lowest'));
		}
		if ($slider.slider('value') === slider_max) {
			$extr_textbox_label.text($extr_textbox_label.data('longdesc_highest'));
		}
		$slider.on("slide", function (e,ui) {
			if (ui.value === slider_min || ui.value === slider_max) {
				$extr_textbox.show();
				if (ui.value === slider_min) {
					$extr_textbox_label.text($extr_textbox_label.data('longdesc_lowest'));
				} else {
					$extr_textbox_label.text($extr_textbox_label.data('longdesc_highest'));
				}
			} else {
				$extr_textbox.hide();
			}
		});
	}
});