/**
 * @package    hubzero-cms
 * @copyright  Copyright 2005-2019 HUBzero Foundation, LLC.
 * @license    http://opensource.org/licenses/MIT MIT
 */

/*
USAGE:

    $.growl(title, msg);
    $.growl(title, msg, image);
    $.growl(title, msg, image, priority);

THEME/SKIN:

You can override the default look and feel by updating these objects:
$.growl.settings.displayTimeout = 4000;
$.growl.settings.noticeTemplate = ''
    + '<div>'
    + '<div style="float: right; background-image: url(my.growlTheme/normalTop.png); position: relative; width: 259px; height: 16px; margin: 0pt;"></div>'
    + '<div style="float: right; background-image: url(my.growlTheme/normalBackground.png); position: relative; display: block; color: #ffffff; font-family: Arial; font-size: 12px; line-height: 14px; width: 259px; margin: 0pt;">' 
    + '  <img style="margin: 14px; margin-top: 0px; float: left;" src="%image%" />'
    + '  <h3 style="margin: 0pt; margin-left: 77px; padding-bottom: 10px; font-size: 13px;">%title%</h3>'
    + '  <p style="margin: 0pt 14px; margin-left: 77px; font-size: 12px;">%message%</p>'
    + '</div>'
    + '<div style="float: right; background-image: url(my.growlTheme/normalBottom.png); position: relative; width: 259px; height: 16px; margin-bottom: 10px;"></div>'
    + '</div>';
$.growl.settings.noticeCss = {
    position: 'relative'
};

To change the 'dock' look, and position: 

$.growl.settings.dockTemplate = '<div></div>';
$.growl.settings.dockCss = {
    position: 'absolute',
    top: '10px',
    right: '10px',
    width: '300px'
};

The dockCss will allow you to 'dock' the notifications to a specific area
on the page, such as TopRight (the default) or TopLeft, perhaps even in a
smaller area with "overflow: scroll" enabled?
*/

(function($) {
	$.growl = function(title,message,image,priority) { notify(title,message,image,priority); }
	$.growl.version = "1.0.2";

	function create(rebuild) {
		var instance = document.getElementById('growlDock');
		if (!instance || rebuild) {
			instance = $(jQuery.growl.settings.dockTemplate).attr('id', 'growlDock').addClass('growl');
			if (jQuery.growl.settings.defaultStylesheet) {
				$('head').append('<link rel="stylesheet" type="text/css" href="' + jQuery.growl.settings.defaultStylesheet + '" />');
			}
		} else {
			instance = $(instance);
		}
		$('body').append(instance.css(jQuery.growl.settings.dockCss));
		return instance;
	};

	function r(text, expr, val) {
		while (expr.test(text)) {
			text = text.replace(expr, val);
		}
		return text;
	};

	function notify(title,message,image,priority) {
		var instance = create();
		var html = jQuery.growl.settings.noticeTemplate;
		if (typeof(html) == 'object') {
			html = $(html).html();
		}
		html = r(html, /%message%/, (message?message:''));
		html = r(html, /%title%/, (title?title:''));
		html = r(html, /%image%/, (image?image:jQuery.growl.settings.defaultImage));
		html = r(html, /%priority%/, (priority?priority:'normal'));

		var notice = $(html)
			.hide()
			.css(jQuery.growl.settings.noticeCss)
			.fadeIn(jQuery.growl.settings.notice);

		$.growl.settings.noticeDisplay(notice);
		instance.append(notice);
		$('a[rel="close"]', notice).on('click', function() {
			notice.remove();
		});
		if ($.growl.settings.displayTimeout > 0) {
			$('a[rel="close"]', notice).hide();
			setTimeout(function(){
				jQuery.growl.settings.noticeRemove(notice, function(){
					notice.remove();
				});
			}, jQuery.growl.settings.displayTimeout);
		}
	};

	// default settings
	$.growl.settings = {
		dockTemplate: '<div></div>',
		dockCss: {
			position: 'fixed',
			top: '30%',
			right: '50%',
			//width: '30em',
			zIndex: 50000
		},
		noticeTemplate: 
			'<div class="growl-notice">' +
			'  %message%' + '<a href="#" class="growl-close" rel="close" title="Close">Close</a>' +
			'</div>',
		noticeCss: {
			opacity: 1, //.75,
			backgroundColor: 'transparent', //#333333',
			color: '#fff'
		},
		noticeDisplay: function(notice) {
			notice.css({'opacity':'0'}).fadeIn(jQuery.growl.settings.noticeFadeTimeout);
		},
		noticeRemove: function(notice, callback) {
			//notice.animate({opacity: '0', height: '0px'}, {duration:jQuery.growl.settings.noticeFadeTimeout, complete: callback});
			notice.fadeOut({duration:jQuery.growl.settings.noticeFadeTimeout, complete: callback});
		},
		noticeFadeTimeout: 'slow',
		displayTimeout: 2000,
		defaultImage: 'growl.jpg',
		defaultStylesheet: null,
		noticeElement: function(el) {
			$.growl.settings.noticeTemplate = $(el);
		}
	};
})(jQuery);

jQuery(document).ready(function($){
	$('html').removeClass('nojs');

	var menu = $('#toolbar-box'),
		top = menu.offset().top - parseFloat(menu.css('margin-top').replace(/auto/, 0));

	// Stick the toolbar to the top of the screen when the browser has scrolled
	$(window).on('scroll', function(event) {
		// what the y position of the scroll is
		var y = $(window).scrollTop();
		// whether that's below the form
		if (y >= top) {
			// if so, add the fixed class
			menu.addClass('fixed');
		} else {
			// otherwise remove it
			menu.removeClass('fixed');
		}
	});

	// Mobile device fix
	$('#toolbar ul').on('click', function(e){
		$(this).toggleClass('active');
	});

	$('.main-navigation li.node>a').on('click', function(e){
		$(this).parent().toggleClass('active');
	});

	// Display system messages in Growl-like way
	$(document).on("renderMessages", function() {
		var msg = $('#system-message-container');
		if (msg.length && msg.html().replace(/\s+/, '') != '') {
			if (msg.find('dd.error, dd.warning, dd.info').length) {
				$.growl.settings.displayTimeout = 0;
			} else {
				msg.find('dd.message').each(function(i, el) {
					var tm = ($(el).text().length * 10) + 500;
					if (tm > 2000) {
						$.growl.settings.displayTimeout = tm;
					}
				});
			}
			$.growl('', msg.html());
		}
	});

	$(document).trigger('renderMessages');
});
