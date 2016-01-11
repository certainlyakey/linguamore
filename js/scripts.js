// @codekit-prepend "cssattr.min.js"

jQuery(document).ready(function ($) {


	/* ========================================================================= */

	// !– Dev tools

	/* ========================================================================= */




	/* ========================================================================= */

	// !– Cosmetics

	/* ========================================================================= */


	$('html').removeClass('no-js');

	var is_touch_device = 'ontouchstart' in document.documentElement;
	if (is_touch_device) {$('body').addClass('touchdevice');}

	$('.sitename a, .socialmenu a').wrapInner('<span class="wrapper-hidden"></span>');
	$('.zapis-link a, .test-link a').wrapInner('<span class="wrapper"></span>');

	if($('body.touchdevice').length) {
		$(".menu>li>a").click(function(e) {
			if ($(this).next('ul').length) {
				var $thismenu = $(this).parents('.menu');
				$thismenu.find('a').not($(this)).removeClass("clicked");
				$(this).toggleClass("clicked");
				if ($(this).hasClass("clicked")) {
					e.preventDefault();
				}
			}
		});
	}

	if ($('body.single-post img.wp-post-image').length) {
		$('.post-content img.wp-post-image').wrap('<div class="wp-post-image-wrapper"></div>');
		var bgi = $('.wp-post-image-wrapper').find('img').attr('src');
		$('.wp-post-image-wrapper').css('background-image', 'url('+bgi+')');
		$('.wp-post-image-wrapper').find('img').hide();
	}
	// $('.post-image-intro-round').find('img').hide();
	// $('.post-image-intro-round').each(function() {
	// 	var bgi = $(this).find('img').attr('src');
	// 	$(this).css('background-image', 'url('+bgi+')');
	// 	$(this).find('img').hide();
	// });


	$('.social-buttons').on('click', 'a', function(event) {
		event.preventDefault();
		window.open($(this).attr("href"), "popupWindow", "width=626,height=436,scrollbars=yes,toolbar=no,status=0");
	});


	if ($('.modules_horizontal').length) {
		$('.modules_horizontal li').wrapInner('<div class="first-wrapper"><div class="second-wrapper"></div></div>');

		$('.modules_horizontal').prepend('<style>');
		$('.modules_horizontal style').html(' \
			.modules_horizontal li {color:attr(data-color);} \
		');
	}
	
	if ($('.modules_vertical').length) {
		// $('.modules_vertical li').wrapInner('<div class="first-wrapper"><div class="second-wrapper"></div></div>');

		$('.modules_vertical').append('<style>');
		$('.modules_vertical style').html(' \
			.modules_vertical li {color:attr(data-color);} \
		');
	}

	if ($('.route-gallery').length) {
		$('.route-gallery').append('<style>');
		$('.route-gallery style').html(' \
			.route-gallery a {background-image:url(attr(href));} \
		');
	}

	if ($('.modules_detailed').length) {
		$('.modules_detailed li .symbol_small').wrap('<div class="symbol-wrapper"></div>');
		$('.modules_detailed .text li, .modules_detailed .text p').wrapInner('<span class="wrapper"></span>');

		$('.modules_detailed').append('<style>');
		$('.modules_detailed style').html(' \
			.modules_detailed li {color:attr(data-color);} \
			.modules_detailed .text {color:attr(data-color);} \
			.modules_detailed .more-link {color:attr(data-color);} \
		');
	}

	if ($('.choice').length) {
		$('.choice').append('<style>');
		$('.choice style').html(' \
			.choice .button-big {background-color:attr(data-color);} \
		');
	}
	
	if ($('.price_illustration_savings').length) {
		var $this = $('.price_illustration_savings');
		$this.prepend('<style>');
		$this.find('style').html(' \
			.price_illustration_savings {border-color:attr(data-color);} \
		');
		var lighter = ColorLuminance($this.data('color'), 0.3);
		console.log($this.data('color'));
		$this.css('color', lighter);
	}
	
	if ($('.letsgo').length) {
		$('.letsgo').prepend('<style>');
		$('.letsgo style').html(' \
			.letsgo {color:attr(data-color);} \
		');
	}

	//initialize CSS attr() polyfill
	// Get CSS for all styles
	var styleNode = document.querySelectorAll('style'),
		css = '';
	for (var i = 0; i < styleNode.length; i++) {
		css += styleNode[i].innerHTML;
	}
	//Parse the CSS, show it and observe for changes.
	cssattr.parse(css).show().observe();


	function ColorLuminance(hex, lum) {

		// validate hex string
		hex = String(hex).replace(/[^0-9a-f]/gi, '');
		if (hex.length < 6) {
			hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
		}
		lum = lum || 0;

		// convert to decimal and change luminosity
		var rgb = "#", c, i;
		for (i = 0; i < 3; i++) {
			c = parseInt(hex.substr(i*2,2), 16);
			c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
			rgb += ("00"+c).substr(c.length);
		}

		return rgb;
	}



	/* ========================================================================= */

	// !– teachers archive

	/* ========================================================================= */



		// !Append HTML



		// !Set vars



		// !Functions



		// !Launch onload functions
		$('body.post-type-archive-teacher, body.single-teacher').find('article').each(function() {
			$(this).find('.more-link').parent('p').addClass('more-link-parent').nextAll().wrapAll('<div class="wrapper"></div>');
		});
		$('.more-link-parent').next('.wrapper').hide();
		$('.more-link-parent').on('click', 'a', function(event) {
			event.preventDefault();
			$(this).parent('.more-link-parent').next('.wrapper').toggle();
		});
		
		$('.modules_detailed').children('li').each(function() {
			$(this).find('.more-link').nextAll().wrapAll('<div class="wrapper"></div>');
		});
		$('.modules_detailed .more-link').next('.wrapper').hide();
		$('.modules_detailed .more-link').on('click', function(event) {
			event.preventDefault();
			$(this).next('.wrapper').toggle();
		});

		if ($('body.post-type-archive-teacher').length) {
			var hash = location.hash.substring(1);
			if (hash != '') {
				$('#'+hash).find('.wrapper').show();
			}
		}


		// !Events






	/* ========================================================================= */

	// !– Test choice page

	/* ========================================================================= */



		// !Append HTML



		// !Set vars



		// !Functions



		// !Launch onload functions
		if ($('body.page-template-template-choice').length) {
			$('.lang_test_choice').after('<div class="type_choice">&nbsp;</div>');
			$('.lang_test_choice a').attr('title','');
			$('.lang_test_choice a[data-preselected=true]').addClass('selected');
			$('.lang_test_choice').one('click', 'a', function(event) {
				event.preventDefault();
				$('.type_choice').html('<ul><li class="simple"><a href="javascript:;"><strong>Начинающий</strong> (<span class="isadvanced_q">12</span> вопросов)</a></li><li class="advanced"><a href="javascript:;"><strong>Продвинутый</strong> (<span class="isadvanced_q">24</span> вопросов)</a></li></ul>');
			});
			$('.lang_test_choice').on('click', 'a', function(event) {
				event.preventDefault();
				var test_href = $(this).attr('href');
				var test_isadvanced_q = $(this).data('isadvanced-q');
				$('.lang_test_choice .selected').removeClass('selected');
				$(this).addClass('selected');
				$('.type_choice a .isadvanced_q').html(test_isadvanced_q);
				$('.type_choice .simple a').attr('href', test_href + '?testing=true');
				$('.type_choice .advanced a').attr('href', test_href + '?testing=true&is_advanced=true');
			});
			$('.lang_test_choice a[data-preselected=true]').trigger('click');
		}


		// !Events




	/* ========================================================================= */

	// !– testings 

	/* ========================================================================= */



		// !Append HTML



		// !Set vars



		// !Functions
		// function createpdf() {
		// 	var doc = new jsPDF();
		// 	var copied_content = $('#test_results .question_list').clone();
		// 	copied_content.find('.correct').wrapInner('<strong></strong>');
		// 	copied_content.find('.question_name').wrapInner('<strong></strong>');
		// 	copied_content.find('.incorrect').wrapInner('<em></em>');
		// 	var doc_content = copied_content.html();
		// 	doc.fromHTML(doc_content, 20, 20, 'arial');
		// 	// var elementHandler = {
		// 	//   '#ignorePDF': function (element, renderer) {
		// 	//     return true;
		// 	//   }
		// 	// };
		// 	// doc.fromHTML($('#test_results').get(0), 15, 15, {
		// 	// 	'width': 170,
		// 	// 	'elementHandlers': elementHandler
		// 	// });
		// 	doc.save('Test.pdf');
		// }



		// !Launch onload functions
		if ($('.language_testing_result .testing').length) {
			$('.testing').prepend('<a href="javascript:;" class="show_results">Показать результаты</a>');
			$('.show_results').nextAll().wrapAll('<div class="wrapper"></div>');
			$('.testing .wrapper').hide();
			$('.show_results').on('click', function() {
				$(this).toggleClass('open');
				$('.testing').find('.wrapper').toggle();
			});
		}

		// $('#savetopdf').on('click', function() {createpdf();});


		// !Events





	/* ========================================================================= */

	// !– single posts

	/* ========================================================================= */



		// !Append HTML

		//Slideshow
	    //Simple slideshow that: 
	    // - produces prev/next links, 
	    // - produces numbered pagination,
	    // - may be loopable,
	    // - has auto advance feature.
	    //Optimized for Wordpress gallery but OK for any other use.
	    //CSS has to be set separately.

		function slideshow(selector) {
			var slC = selector; //this value should contain a slideshow container like div, it is not suited for 'ul' selector (because it cannot contain another uls as direct children) so better choose its parent

			//User settings
			var slEl = slC.find('figure'); //slideshow element
			var pagPrevTxt = '<span>&lt;</span>';
			var pagNextTxt = '<span>&gt;</span>';
			var hasPagination = false;
			if ($('body.page-template-template-contacts').length) {
				var hasPagination = true;
			}
			// var loop = false;
			// if ($('body.single-post').length) {
				var loop = true;
			// }
			var speed = 5000;
			var autoAdvance = false; //loop setting must be true

			//Script inner variables
			slC.find(slEl).hide().first().addClass('current').show();
			var count = slEl.length;
			var currIndex = slEl.filter('.current').index();
			var currIUp;
			var currIDown;
			var pagination = '<ul class="pagination route-gallery" />';
			var prevnext = '<ul class="prevnext"><li class="prev"><a href="javascript:void(0);">'+pagPrevTxt+'</a></li><li class="next"><a href="javascript:void(0);">'+pagNextTxt+'</a></li></ul>';
			var slideShowInterval; 

			//Script inner functions 
			function moveCurrentPagination(nextCurrent) {
				pagLink.removeClass('current').filter(':eq('+nextCurrent+')').addClass('current');
			}
			function moveCurrentSlide(nextCurrent) {
				slEl.removeClass('current').hide().filter(':eq('+nextCurrent+')').addClass('current').fadeIn('fast');
			}

			function moveToPrev() {
				currIDown = currIndex - 1;
				prevEl.show();
				nextEl.show();
				if (currIDown > -1) {
					if (hasPagination) {
						moveCurrentPagination(currIDown);
					}
					if (!loop) {
						if (currIDown === (0)) {
							prevEl.hide();
						}
					}
					moveCurrentSlide(currIDown);
					currIndex = currIDown;
				}
				else if (currIDown === -1) {
					if (loop) {
						if (hasPagination) {
							moveCurrentPagination(count-1);
						}
						moveCurrentSlide(count-1);
						currIndex = (count-1);
					}
				}
			}

			function moveToNext() {
				currIUp = currIndex + 1;
				prevEl.show();
				nextEl.show();
				if (currIUp < count) {
					if (hasPagination) {
						moveCurrentPagination(currIUp);
					}
					if (!loop) {
						if (currIUp === (count-1)) {
							nextEl.hide();
						}
					}
					moveCurrentSlide(currIUp);
					currIndex++;
				}
				else if (currIUp === count) {
					if (loop) {
						if (hasPagination) {
							moveCurrentPagination(0);
						}
						moveCurrentSlide(0);
						currIndex = 0;	
					}
				}
			}

			if (count > 1) {
				//Insert pagination
				if (hasPagination) {
					slC.after(pagination);
					var pagEl = slC.parent().find('.pagination');
					var pagImg;
					$(slEl).each(function(index) {
						pagImg = $(this).find('img').attr('src');
						pagEl.append('<li><a href="javascript:void(0);" style="background-image:url('+pagImg+');"><span>'+(index+1)+'</span></a></li>');
					});
					var pagLink = pagEl.find('a');
					pagEl.find('a').first().addClass('current');
					pagLink.on('click', function(e) {
						e.preventDefault();
						pagLink.removeClass('current');
						$(this).addClass('current');
						var pagLinkN = $(pagLink).index(this);
						slEl.removeClass('current').hide().filter(':eq('+pagLinkN+')').addClass('current').show();
						currIndex = pagLinkN;
					});
				}
				
				var slLink = slEl.find('a');
				slLink.on('click', function(e) {
					e.preventDefault();
					moveToNext();
				});

				//Insert prev and next navigation
				if (count > 2) {
					slC.after(prevnext);
					var prevEl = slC.next('.prevnext').find('.prev');
					var nextEl = slC.next('.prevnext').find('.next');

					prevEl.on('click', function(e) {
						e.preventDefault();
						moveToPrev();
					});
					nextEl.on('click', function(e) {
						e.preventDefault();
						moveToNext();
					});

					if (!loop) {
						prevEl.hide();
					}
					else {
						if (autoAdvance) {
							slideShowInterval = setInterval(moveToNext, speed);
						}
					}
				}
			}
		}

		$('.gallery').each( function() {
			slideshow($(this));
			if ($('body.page-template-template-contacts').length) {
				$(this).add('.prevnext').add('.pagination').wrapAll('<div class="gallery-wrapper"></div>')
			} else {
				$(this).add('.prevnext').wrapAll('<div class="gallery-wrapper"></div>')
			}
		});
		// if ($('.route-gallery').length) {
		// 	$('.route-gallery').appendTo($('.route'));
		// }




		// !Set vars



		// !Functions



		// !Launch onload functions
		


		// !Events






	/* ========================================================================= */

	// !– contact forms 

	/* ========================================================================= */



		// !Append HTML



		// !Set vars



		// !Functions



		// !Launch onload functions
		if ($('.wpcf7-form select').length) {
			$('.wpcf7-form select').select2({minimumResultsForSearch: Infinity});
		}
		if ($('.wpcf7-form label[title]').length) {
			var label_tip = '';
			$('.wpcf7-form label[title]').each(function() {
				label_tip = $(this).attr('title');
				$(this).append('<div class="form-tip">'+label_tip+'</div>');
			});
		}
		if ($('.wpcf7-form').length) {
			$('.wpcf7-form input[aria-required="true"]').parents('p').addClass('required');
		}


		// !Events



});