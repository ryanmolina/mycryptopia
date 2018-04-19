/* global jQuery:false */
/* global CRYPTON_BLOG_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";

	var theme_init_counter = 0;
	
	crypton_blog_init_actions();
	if(jQuery('body').hasClass('extra_boxed')) {
        go_anim();
    }
	
	// Theme init actions
	function crypton_blog_init_actions() {

        if (CRYPTON_BLOG_STORAGE['vc_edit_mode'] && jQuery('.vc_empty-placeholder').length==0 && theme_init_counter++ < 30) {
			setTimeout(crypton_blog_init_actions, 200);
			return;
		}

		// Check fullheight elements
		jQuery(document).on('action.init_hidden_elements', crypton_blog_stretch_height);
		jQuery(document).on('action.init_shortcodes', crypton_blog_stretch_height);
		jQuery(document).on('action.sc_layouts_row_fixed_off', crypton_blog_stretch_height);
		jQuery(document).on('action.sc_layouts_row_fixed_on', crypton_blog_stretch_height);
	
		// Add resize on VC action vc-full-width-row
		// But we emulate 'action.resize_vc_row_start' and 'action.resize_vc_row_end'
		// to correct resize sliders and video inside 'boxed' pages
		var vc_resize = false;
		jQuery(document).on('action.resize_vc_row_start', function(e, el) {
			vc_resize = true;
			crypton_blog_resize_actions(el);
		});
	
		// Resize handlers
		jQuery(window).resize(function() {
			if (!vc_resize) {
				crypton_blog_resize_actions();
			}
		});
		
		// Scroll handlers
		jQuery(window).scroll(function() {
			crypton_blog_scroll_actions();
		});
		
		// First call to init core actions
		crypton_blog_ready_actions();
		crypton_blog_resize_actions();
		crypton_blog_scroll_actions();
		
		// Wait for logo load
		if (jQuery('body').hasClass('menu_style_side') && !crypton_blog_check_images_complete(jQuery('.menu_side_wrap .sc_layouts_logo'))) {
			setTimeout(function() {
				crypton_blog_stretch_sidemenu();
			}, 500);
		}
	}
	
	
	
	// Theme first load actions
	//==============================================
	function crypton_blog_ready_actions() {
	
		// Add scheme class and js support
		//------------------------------------
		document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'js');
		if (document.documentElement.className.indexOf(CRYPTON_BLOG_STORAGE['site_scheme'])==-1)
			document.documentElement.className += ' ' + CRYPTON_BLOG_STORAGE['site_scheme'];



		if (jQuery('.ccpw-container:not(.inited)').length > 0) {
			jQuery('.ccpw-container:not(.inited)').addClass('trx-display-ccpw-container');
			jQuery('.ccpw-container:not(.inited)').addClass('inited');
		}

		// Init background video
		//------------------------------------
		// Use Bideo to play local video
		if (CRYPTON_BLOG_STORAGE['background_video'] && jQuery('.top_panel.with_bg_video').length > 0 && window.Bideo) {
			// Waiting 10ms after mejs init
			setTimeout(function() {
				jQuery('.top_panel.with_bg_video').prepend('<video id="background_video" loop muted></video>');
				var bv = new Bideo();
				bv.init({
					// Video element
					videoEl: document.querySelector('#background_video'),
					
					// Container element
					container: document.querySelector('.top_panel'),
					
					// Resize
					resize: true,
					
					// autoplay: false,
					
					isMobile: window.matchMedia('(max-width: 768px)').matches,
					
					playButton: document.querySelector('#background_video_play'),
					pauseButton: document.querySelector('#background_video_pause'),
					
					// Array of objects containing the src and type
					// of different video formats to add
					// For example:
					//	src: [
					//			{	src: 'night.mp4', type: 'video/mp4' }
					//			{	src: 'night.webm', type: 'video/webm;codecs="vp8, vorbis"' }
					//		]
					src: [
						{
							src: CRYPTON_BLOG_STORAGE['background_video'],
							type: 'video/'+crypton_blog_get_file_ext(CRYPTON_BLOG_STORAGE['background_video'])
						}
					],
					
					// What to do once video loads (initial frame)
					onLoad: function () {
						//document.querySelector('#background_video_cover').style.display = 'none';
					}
				});
			}, 10);
		
		// Use Tubular to play video from Youtube
		} else if (jQuery.fn.tubular) {
			jQuery('div#background_video').each(function() {
				var youtube_code = jQuery(this).data('youtube-code');
				if (youtube_code) {
					jQuery(this).tubular({videoId: youtube_code});
					jQuery('#tubular-player').appendTo(jQuery(this)).show();
					jQuery('#tubular-container,#tubular-shield').remove();
				}
			});
		}
	
		// Tabs
		//------------------------------------
		if (jQuery('.crypton_blog_tabs:not(.inited)').length > 0 && jQuery.ui && jQuery.ui.tabs) {
			jQuery('.crypton_blog_tabs:not(.inited)').each(function () {
				// Get initially opened tab
				var init = jQuery(this).data('active');
				if (isNaN(init)) {
					init = 0;
					var active = jQuery(this).find('> ul > li[data-active="true"]').eq(0);
					if (active.length > 0) {
						init = active.index();
						if (isNaN(init) || init < 0) init = 0;
					}
				} else {
					init = Math.max(0, init);
				}
				// Init tabs
				jQuery(this).addClass('inited').tabs({
					active: init,
					show: {
						effect: 'fadeIn',
						duration: 300
					},
					hide: {
						effect: 'fadeOut',
						duration: 300
					},
					create: function( event, ui ) {
						if (ui.panel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
					},
					activate: function( event, ui ) {
						if (ui.newPanel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
					}
				});
			});
		}
		// AJAX loader for the tabs
		jQuery('.crypton_blog_tabs_ajax').on( "tabsbeforeactivate", function( event, ui ) {
			if (ui.newPanel.data('need-content')) crypton_blog_tabs_ajax_content_loader(ui.newPanel, 1, ui.oldPanel);
		});
		// AJAX loader for the pages in the tabs
		jQuery('.crypton_blog_tabs_ajax').on( "click", '.nav-links a', function(e) {
			var panel = jQuery(this).parents('.crypton_blog_tabs_content');
			var page = 1;
			var href = jQuery(this).attr('href');
			var pos = -1;
			if ((pos = href.lastIndexOf('/page/')) != -1 ) {
				page = Number(href.substr(pos+6).replace("/", ""));
				if (!isNaN(page)) page = Math.max(1, page);
			}
			crypton_blog_tabs_ajax_content_loader(panel, page);
			e.preventDefault();
			return false;
		});
	
		// Menu
		//----------------------------------------------
		// Add class in the vertical menu
		if (jQuery('.vertical_menu_no_margin').length > 0)
			jQuery('.vertical_menu_no_margin').closest('.sc_layouts_item').addClass( "sc_layouts_item_no_margin" );
	
		// Add TOC in the side menu
		if (jQuery('.menu_side_inner').length > 0 && jQuery('#toc_menu').length > 0)
			jQuery('#toc_menu').appendTo('.menu_side_inner');
	
		// Open/Close side menu
		jQuery('.menu_side_button').on('click', function(e){
			jQuery(this).parent().toggleClass('opened');
			e.preventDefault();
			return false;
		});

		// Add images to the menu items with classes image-xxx
		jQuery('.sc_layouts_menu li[class*="image-"]').each(function() {
			var classes = jQuery(this).attr('class').split(' ');
			var icon = '';
			for (var i=0; i < classes.length; i++) {
				if (classes[i].indexOf('image-') >= 0) {
					icon = classes[i].replace('image-', '');
					break;
				}
			}
			if (icon) jQuery(this).find('>a').css('background-image', 'url('+CRYPTON_BLOG_STORAGE['theme_url']+'/trx_addons/css/icons.png/'+icon+'.png');
		});
	
		// Add arrows to the mobile menu
		jQuery('.menu_mobile .menu-item-has-children > a').append('<span class="open_child_menu"></span>');

		// ---- Add arrows to the vertical menu
		jQuery('.sc_layouts_menu_dir_vertical .menu-item-has-children > a').append('<span class="open_child_menu"></span>');
	

		// Open/Close mobile menu
		jQuery('.sc_layouts_menu_mobile_button > a,.menu_mobile_button,.menu_mobile_description').on('click', function(e) {
			if (jQuery(this).parent().hasClass('sc_layouts_menu_mobile_button_burger') && jQuery(this).next().hasClass('sc_layouts_menu_popup')) return;
			jQuery('.menu_mobile_overlay').fadeIn();
			jQuery('.menu_mobile').addClass('opened');
			jQuery(document).trigger('action.stop_wheel_handlers');
			e.preventDefault();
			return false;
		});
		jQuery(document).on('keypress', function(e) {
			if (e.keyCode == 27) {
				if (jQuery('.menu_mobile.opened').length == 1) {
					jQuery('.menu_mobile_overlay').fadeOut();
					jQuery('.menu_mobile').removeClass('opened');
					jQuery(document).trigger('action.start_wheel_handlers');
					e.preventDefault();
					return false;
				}
			}
		});;
		jQuery('.menu_mobile_close, .menu_mobile_overlay').on('click', function(e){
			jQuery('.menu_mobile_overlay').fadeOut();
			jQuery('.menu_mobile').removeClass('opened');
			jQuery(document).trigger('action.start_wheel_handlers');
			e.preventDefault();
			return false;
		});
	
		// Open/Close mobile submenu
		jQuery('.menu_mobile').on('click', 'li a, li a .open_child_menu', function(e) {
			var $a = jQuery(this).hasClass('open_child_menu') ? jQuery(this).parent() : jQuery(this);
			if ($a.parent().hasClass('menu-item-has-children')) {
				if ($a.attr('href')=='#' || jQuery(this).hasClass('open_child_menu')) {
					if ($a.siblings('ul:visible').length > 0)
						$a.siblings('ul').slideUp().parent().removeClass('opened');
					else {
						jQuery(this).parents('li').siblings('li').find('ul:visible').slideUp().parent().removeClass('opened');
						$a.siblings('ul').slideDown().parent().addClass('opened');
					}
				}
			}
			if (!jQuery(this).hasClass('open_child_menu') && crypton_blog_is_local_link($a.attr('href')))
				jQuery('.menu_mobile_close').trigger('click');
			if (jQuery(this).hasClass('open_child_menu') || $a.attr('href')=='#') {
				e.preventDefault();
				return false;
			}
		});

		// Open/Close vertical submenu
		jQuery('.sc_layouts_menu_dir_vertical').on('click', 'li a, li a .open_child_menu', function(e) {
			var $a = jQuery(this).hasClass('open_child_menu') ? jQuery(this).parent() : jQuery(this);
			if ($a.parent().hasClass('menu-item-has-children')) {
				if ($a.attr('href')=='#' || jQuery(this).hasClass('open_child_menu')) {
					if ($a.siblings('ul:visible').length > 0)
						$a.siblings('ul').slideUp().parent().removeClass('opened');
					else {
						jQuery(this).parents('li').siblings('li').find('ul:visible').slideUp().parent().removeClass('opened');
						$a.siblings('ul').slideDown(function() {
							// Init layouts
							if (!jQuery(this).hasClass('layouts_inited') && jQuery(this).parents('.menu_mobile').length > 0) {
								jQuery(this).addClass('layouts_inited');
								jQuery(document).trigger('action.init_hidden_elements', [jQuery(this)]);
							}
						}).parent().addClass('opened');
					}
				}
			}
			if (!jQuery(this).hasClass('open_child_menu') && jQuery(this).parents('.menu_mobile').length > 0 && basekit_is_local_link($a.attr('href')))
				jQuery('.menu_mobile_close').trigger('click');
			if (jQuery(this).hasClass('open_child_menu') || $a.attr('href')=='#') {
				e.preventDefault();
				return false;
			}
		});
	
		if (!CRYPTON_BLOG_STORAGE['trx_addons_exist'] || jQuery('.top_panel.top_panel_default .sc_layouts_menu_default').length > 0) {
			// Init superfish menus
			crypton_blog_init_sfmenu('.sc_layouts_menu:not(.inited) > ul:not(.inited)');
			// Show menu		
			jQuery('.sc_layouts_menu:not(.inited)').each(function() {
				if (jQuery(this).find('>ul.inited').length == 1) jQuery(this).addClass('inited');
			});
			// Generate 'scroll' event after the menu is showed
			jQuery(window).trigger('scroll');
		}

		
		// Forms
		//----------------------------------------------
	
		// Wrap select with .select_container
		jQuery('select:not(.esg-sorting-select):not([class*="trx_addons_attrib_"])').each(function() {
			var s = jQuery(this);
			if (s.css('display') != 'none' 
				&& !s.next().hasClass('select2') 
				&& !s.hasClass('select2-hidden-accessible'))
				s.wrap('<div class="select_container"></div>');
		});
	
		// Comment form
		jQuery("form#commentform").submit(function(e) {
			var rez = crypton_blog_comments_validate(jQuery(this));
			if (!rez)
				e.preventDefault();
			return rez;
		});
	
		jQuery("form").on('keypress', '.error_field', function() {
			if (jQuery(this).val() != '')
				jQuery(this).removeClass('error_field');
		});
	
	
		// Blocks with stretch width
		//----------------------------------------------
		// Action to prepare stretch blocks in the third-party plugins
		jQuery(document).trigger('action.prepare_stretch_width');
		// Wrap stretch blocks
		jQuery('.trx-stretch-width').wrap('<div class="trx-stretch-width-wrap"></div>');
		jQuery('.trx-stretch-width').after('<div class="trx-stretch-width-original"></div>');
		crypton_blog_stretch_width();
			
	
		// Pagination
		//------------------------------------
	
		// Load more
		jQuery('.nav-links-more a').on('click', function(e) {
			if (CRYPTON_BLOG_STORAGE['load_more_link_busy']) return;
			CRYPTON_BLOG_STORAGE['load_more_link_busy'] = true;
			var more = jQuery(this);
			var page = Number(more.data('page'));
			var max_page = Number(more.data('max-page'));
			if (page >= max_page) {
				more.parent().hide();
				return;
			}
			more.parent().addClass('loading');
			var panel = more.parents('.crypton_blog_tabs_content');
			if (panel.length == 0) {															// Load simple page content
				jQuery.get(location.href, {
					paged: page+1
				}).done(function(response) {
					// Get inline styles and add to the page styles
					var selector = 'crypton_blog-inline-styles-inline-css';
					var p1 = response.indexOf(selector);
					if (p1 < 0) {
						selector = 'trx_addons-inline-styles-inline-css';
						p1 = response.indexOf(selector);
					}
					if (p1 > 0) {
						p1 = response.indexOf('>', p1) + 1;
						var p2 = response.indexOf('</style>', p1);
						var inline_css_add = response.substring(p1, p2);
						var inline_css = jQuery('#'+selector);
						if (inline_css.length == 0)
							jQuery('body').append('<style id="'+selector+'" type="text/css">' + inline_css_add + '</style>');
						else
							inline_css.append(inline_css_add);
					}
					// Get new posts and append to the .posts_container
					crypton_blog_loadmore_add_items(jQuery('.content .posts_container').eq(0),
											   jQuery(response).find('.content .posts_container > article,'
											   						+'.content .posts_container > div[class*="column-"],'
																	+'.content .posts_container > .masonry_item')
												);
				});
			} else {																			// Load tab's panel content
				jQuery.post(CRYPTON_BLOG_STORAGE['ajax_url'], {
					nonce: CRYPTON_BLOG_STORAGE['ajax_nonce'],
					action: 'crypton_blog_ajax_get_posts',
					blog_template: panel.data('blog-template'),
					blog_style: panel.data('blog-style'),
					posts_per_page: panel.data('posts-per-page'),
					cat: panel.data('cat'),
					parent_cat: panel.data('parent-cat'),
					post_type: panel.data('post-type'),
					taxonomy: panel.data('taxonomy'),
					page: page+1
				}).done(function(response) {
					var rez = {};
					try {
						rez = JSON.parse(response);
					} catch (e) {
						rez = { error: CRYPTON_BLOG_STORAGE['strings']['ajax_error'] };
						console.log(response);
					}
					if (rez.error !== '') {
						panel.html('<div class="crypton_blog_error">'+rez.error+'</div>');
					} else {
						crypton_blog_loadmore_add_items(panel.find('.posts_container'), jQuery(rez.data).find('article'));
					}
				});
			}
			// Append items to the container
			function crypton_blog_loadmore_add_items(container, items) {
				if (container.length > 0 && items.length > 0) {
					container.append(items);
					if (container.hasClass('portfolio_wrap') || container.hasClass('masonry_wrap')) {
						container.masonry( 'appended', items ).masonry();
						if (container.hasClass('gallery_wrap')) {
							CRYPTON_BLOG_STORAGE['GalleryFx'][container.attr('id')].appendItems();
						}
					}
					more.data('page', page+1).parent().removeClass('loading');
					// Remove TOC if exists (rebuild on init_shortcodes)
					jQuery('#toc_menu').remove();
					// Trigger actions to init new elements
					CRYPTON_BLOG_STORAGE['init_all_mediaelements'] = true;
					jQuery(document).trigger('action.init_shortcodes', [container.parent()]);
					jQuery(document).trigger('action.init_hidden_elements', [container.parent()]);
				}
				if (page+1 >= max_page)
					more.parent().hide();
				else
					CRYPTON_BLOG_STORAGE['load_more_link_busy'] = false;
				// Fire 'window.scroll' after clearing busy state
				jQuery(window).trigger('scroll');
			}
			e.preventDefault();
			return false;
		});
	
		// Infinite scroll
		jQuery(document).on('action.scroll_crypton_blog', function(e) {
			if (CRYPTON_BLOG_STORAGE['load_more_link_busy']) return;
			var container = jQuery('.content > .posts_container').eq(0);
			var inf = jQuery('.nav-links-infinite');
			if (inf.length == 0) return;
			if (container.offset().top + container.height() < jQuery(window).scrollTop() + jQuery(window).height()*1.5)
				inf.find('a').trigger('click');
		});
			
	
		// Other settings
		//------------------------------------
	
		jQuery(document).trigger('action.ready_crypton_blog');
	
		// Init post format specific scripts
		jQuery(document).on('action.init_hidden_elements', crypton_blog_init_post_formats);
	
		// Init hidden elements (if exists)
		jQuery(document).trigger('action.init_hidden_elements', [jQuery('body').eq(0)]);
		
	} //end ready
	
	
	
	
	// Scroll actions
	//==============================================
	
	// Do actions when page scrolled
	function crypton_blog_scroll_actions() {

		var scroll_offset = jQuery(window).scrollTop();
		var adminbar_height = Math.max(0, jQuery('#wpadminbar').height());
	
		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.scroll_crypton_blog');
		
		// Fix/unfix sidebar
		//crypton_blog_fix_sidebar();
	
		// Shift top and footer panels when header position equal to 'Under content'
		if (jQuery('body').hasClass('header_position_under') && !crypton_blog_browser_is_mobile()) {
			var delta = 50;
			var adminbar = jQuery('#wpadminbar');
			var adminbar_height = adminbar.length == 0 && adminbar.css('position') == 'fixed' ? 0 : adminbar.height();
			var header = jQuery('.top_panel');
			var header_height = header.height();
			var mask = header.find('.top_panel_mask');
			if (mask.length==0) {
				header.append('<div class="top_panel_mask"></div>');
				mask = header.find('.top_panel_mask');
			}
			if (scroll_offset > adminbar_height) {
				var offset = scroll_offset - adminbar_height;
				if (offset <= header_height) {
					var mask_opacity = Math.max(0, Math.min(0.8, (offset-delta)/header_height));
					// Don't shift header with Revolution slider in Chrome
					if ( !(/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) || header.find('.slider_engine_revo').length == 0 )
						header.css('top', Math.round(offset/1.2)+'px');
					mask.css({
						'opacity': mask_opacity,
						'display': offset==0 ? 'none' : 'block'
					});
				} else if (parseInt(header.css('top')) != 0) {
					header.css('top', Math.round(offset/1.2)+'px');
				}
			} else if (parseInt(header.css('top')) != 0 || mask.css('display')!='none') {
				header.css('top', '0px');
				mask.css({
					'opacity': 0,
					'display': 'none'
				});
			}
			var footer = jQuery('.footer_wrap');
			var footer_height = Math.min(footer.height(), jQuery(window).height());
			var footer_visible = (scroll_offset + jQuery(window).height()) - (header.outerHeight() + jQuery('.page_content_wrap').outerHeight());
			if (footer_visible > 0) {
				mask = footer.find('.top_panel_mask');
				if (mask.length==0) {
					footer.append('<div class="top_panel_mask"></div>');
					mask = footer.find('.top_panel_mask');
				}
				if (footer_visible <= footer_height) {
					var mask_opacity = Math.max(0, Math.min(0.8, (footer_height - footer_visible)/footer_height));
					// Don't shift header with Revolution slider in Chrome
					if ( !(/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) || footer.find('.slider_engine_revo').length == 0 )
						footer.css('top', -Math.round((footer_height - footer_visible)/1.2)+'px');
					mask.css({
						'opacity': mask_opacity,
						'display': footer_height - footer_visible <= 0 ? 'none' : 'block'
					});
				} else if (parseInt(footer.css('top')) != 0 || mask.css('display')!='none') {
					footer.css('top', 0);
					mask.css({
						'opacity': 0,
						'display': 'none'
					});
				}
			}
		}
	}
	
	
	// Resize actions
	//==============================================
	
	// Do actions when page scrolled
	function crypton_blog_resize_actions(cont) {
		crypton_blog_check_layout();
		//crypton_blog_fix_sidebar();
		crypton_blog_fix_footer();
		crypton_blog_stretch_width(cont);
		crypton_blog_stretch_height(null, cont);
		crypton_blog_stretch_bg_video();
		crypton_blog_vc_row_fullwidth_to_boxed(cont);
		if (CRYPTON_BLOG_STORAGE['menu_side_stretch']) crypton_blog_stretch_sidemenu();
	
		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.resize_crypton_blog', [cont]);
	}
	
	// Stretch sidemenu (if present)
	function crypton_blog_stretch_sidemenu() {
		var toc_items = jQuery('.menu_side_wrap.menu_side_icons .toc_menu_item');
		if (toc_items.length < 5) return;
		var toc_items_height = jQuery(window).height() 
								- crypton_blog_fixed_rows_height(true, false) 
								- jQuery('.menu_side_wrap .sc_layouts_logo').outerHeight() 
								- toc_items.length;
		var th = Math.floor(toc_items_height / toc_items.length);
		var th_add = toc_items_height - th*toc_items.length;
		toc_items.find(".toc_menu_description,.toc_menu_icon").css({
			'height': th+'px',
			'lineHeight': th+'px'
		});
		toc_items.eq(0).find(".toc_menu_description,.toc_menu_icon").css({
			'height': (th+th_add)+'px',
			'lineHeight': (th+th_add)+'px'
		});
	}
	
	// Check for mobile layout
	function crypton_blog_check_layout() {
		var resize = true;
		if (jQuery('body').hasClass('no_layout')) {
			jQuery('body').removeClass('no_layout');
			resize = false;
		}
		var w = window.innerWidth;
		if (w == undefined) 
			w = jQuery(window).width()+(jQuery(window).height() < jQuery(document).height() || jQuery(window).scrollTop() > 0 ? 16 : 0);
		if (CRYPTON_BLOG_STORAGE['mobile_layout_width'] >= w) {
			if (!jQuery('body').hasClass('mobile_layout')) {
				jQuery('body').removeClass('desktop_layout').addClass('mobile_layout');
				if (resize) jQuery(window).trigger('resize');
			}
		} else {
			if (!jQuery('body').hasClass('desktop_layout')) {
				jQuery('body').removeClass('mobile_layout').addClass('desktop_layout');
				jQuery('.menu_mobile').removeClass('opened');
				jQuery('.menu_mobile_overlay').hide();
				if (resize) jQuery(window).trigger('resize');
			}
		}
		if (CRYPTON_BLOG_STORAGE['mobile_device'] || crypton_blog_browser_is_mobile()) 
			jQuery('body').addClass('mobile_device');
	}
	
	// Stretch area to full window width
	function crypton_blog_stretch_width(cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.trx-stretch-width').each(function() {
			var $el = jQuery(this);
			var $el_cont = $el.parents('.page_wrap');
			var $el_cont_offset = 0;
			if ($el_cont.length == 0) 
				$el_cont = jQuery(window);
			else
				$el_cont_offset = $el_cont.offset().left;
			var $el_full = $el.next('.trx-stretch-width-original');
			var el_margin_left = parseInt( $el.css( 'margin-left' ), 10 );
			var el_margin_right = parseInt( $el.css( 'margin-right' ), 10 );
			var offset = $el_cont_offset - $el_full.offset().left - el_margin_left;
			var width = $el_cont.width();
			if (!$el.hasClass('inited')) {
				$el.addClass('inited invisible');
				$el.css({
					'position': 'relative',
					'box-sizing': 'border-box'
				});
			}
			$el.css({
				'left': offset,
				'width': $el_cont.width()
			});
			if ( !$el.hasClass('trx-stretch-content') ) {
				var padding = Math.max(0, -1*offset);
				var paddingRight = Math.max(0, width - padding - $el_full.width() + el_margin_left + el_margin_right);
				$el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
			}
			$el.removeClass('invisible');
		});
	}
	
	// Stretch area to the full window height
	function crypton_blog_stretch_height(e, cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.crypton_blog-full-height').each(function () {
			var fullheight_item = jQuery(this);
			// If item now invisible
			if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) {
				return;
			}
			var fullheight_row = jQuery(this).parents('.vc_row-o-full-height');
			if (fullheight_row.length > 0)
				fullheight_item.height(fullheight_row.height());
			else {
				var fh = crypton_blog_fixed_rows_height();
				var wh = jQuery(window).width() >= 960
							? jQuery(window).height() - fh
							: 'auto';
				if (wh > 0) {
					if (fullheight_item.data('display') != fullheight_item.css('display'))
						fullheight_item.css('display', fullheight_item.data('display'));
					fullheight_item.css('height', wh);
				} else if (wh=='auto' && fullheight_item.css('height')!='auto') {
					if (fullheight_item.data('display')==undefined)
						fullheight_item.attr('data-display', fullheight_item.css('display'));
					fullheight_item.css({'height': wh, 'display': 'block'});
				}
			}
		});
	}
	
	// Stretch background video
	function crypton_blog_stretch_bg_video() {
		var video_wrap = jQuery('div#background_video,.tourmaster-background-video');
		if (video_wrap.length == 0) return;
		var cont = video_wrap.hasClass('tourmaster-background-video') ? video_wrap.parent() : video_wrap,
			w = cont.width(),
			h = cont.height(),
			video = video_wrap.find('>iframe,>video');
		if (w/h < 16/9)
			w = h/9*16;
		else
			h = w/16*9;
		video
			.attr({'width': w, 'height': h})
			.css({'width': w, 'height': h});
	}
		
	// Recalculate width of the vc_row[data-vc-full-width="true"] when content boxed or menu_style=='left|right'
	function crypton_blog_vc_row_fullwidth_to_boxed(cont) {
		if (jQuery('body').hasClass('body_style_boxed') || jQuery('body').hasClass('menu_style_side')) {
			if (cont === undefined || !cont.hasClass('.vc_row') || !cont.data('vc-full-width'))
				cont = jQuery('.vc_row[data-vc-full-width="true"]');
			var width_content = jQuery('.page_wrap').width();
			var width_content_wrap = jQuery('.page_content_wrap .content_wrap').width();
			var indent = ( width_content - width_content_wrap ) / 2;
			var rtl = jQuery('html').attr('dir') == 'rtl';
			cont.each( function() {
				var mrg = parseInt(jQuery(this).css('marginLeft'));
				var stretch_content = jQuery(this).attr('data-vc-stretch-content');
				var in_content = jQuery(this).parents('.content_wrap').length > 0;
				jQuery(this).css({
					'width': width_content,
					'left': rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
					'right': !rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
					'padding-left': stretch_content ? 0 : indent + mrg,
					'padding-right': stretch_content ? 0 : indent + mrg
				});
			});
		}
	}
	
	
	// Fix/unfix footer
	function crypton_blog_fix_footer() {
		if (jQuery('body').hasClass('header_position_under') && !crypton_blog_browser_is_mobile()) {
			var ft = jQuery('.footer_wrap');
			if (ft.length > 0) {
				var ft_height = ft.outerHeight(false),
					pc = jQuery('.page_content_wrap'),
					pc_offset = pc.offset().top,
					pc_height = pc.height();
				if (pc_offset + pc_height + ft_height < jQuery(window).height()) {
					if (ft.css('position')!='absolute') {
						ft.css({
							'position': 'absolute',
							'left': 0,
							'bottom': 0,
							'width' :'100%'
						});
					}
				} else {
					if (ft.css('position')!='relative') {
						ft.css({
							'position': 'relative',
							'left': 'auto',
							'bottom': 'auto'
						});
					}
				}
			}
		}
	}
	
	
	// Fix/unfix sidebar
	function crypton_blog_fix_sidebar() {
		var sb = jQuery('.sidebar');
		var content = sb.siblings('.content');
		if (sb.length > 0) {
	
			// Unfix when sidebar is under content
			if (content.css('float') == 'none') {

				var old_style = sb.data('old_style');
				if (old_style !== undefined) sb.attr('style', old_style).removeAttr('data-old_style');
	
			} else {
	
				var sb_height = sb.outerHeight();
				var content_height = content.outerHeight();
				var content_top = content.offset().top;
				var scroll_offset = jQuery(window).scrollTop();
				
				var top_panel_fixed_height = crypton_blog_fixed_rows_height();
				
				// If sidebar shorter then content and page scrolled below the content's top
				if (sb_height < content_height && scroll_offset + top_panel_fixed_height > content_top) {
					
					var sb_init = {
							'position': 'undefined',
							'float': 'none',
							'top': 'auto',
							'bottom' : 'auto'
							};
					
					if (typeof CRYPTON_BLOG_STORAGE['scroll_offset_last'] == 'undefined') {
						CRYPTON_BLOG_STORAGE['sb_top_last'] = content_top;
						CRYPTON_BLOG_STORAGE['scroll_offset_last'] = scroll_offset;
						CRYPTON_BLOG_STORAGE['scroll_dir_last'] = 1;
					}
					var scroll_dir = scroll_offset - CRYPTON_BLOG_STORAGE['scroll_offset_last'];
					if (scroll_dir == 0)
						scroll_dir = CRYPTON_BLOG_STORAGE['scroll_dir_last'];
					else
						scroll_dir = scroll_dir > 0 ? 1 : -1;
					
					var sb_big = sb_height + 30 >= jQuery(window).height() - top_panel_fixed_height,
						sb_top = sb.offset().top;
						
					if (sb_top < 0) sb_top = CRYPTON_BLOG_STORAGE['sb_top_last'];

					// If sidebar height greater then window height
					if (sb_big) {
	
						// If change scrolling dir
						if (scroll_dir != CRYPTON_BLOG_STORAGE['scroll_dir_last'] && sb.css('position') == 'fixed') {
							sb_init.top = sb_top - content_top;
							sb_init.position = 'absolute';
	
						// If scrolling down
						} else if (scroll_dir > 0) {
							if (scroll_offset + jQuery(window).height() >= content_top + content_height + 30) {
								sb_init.bottom = 0;
								sb_init.position = 'absolute';
							} else if (scroll_offset + jQuery(window).height() >= (sb.css('position') == 'absolute' ? sb_top : content_top) + sb_height + 30) {
								
								sb_init.bottom = 30;
								sb_init.position = 'fixed';
							}
						
						// If scrolling up
						} else {
							if (scroll_offset + top_panel_fixed_height <= sb_top) {
								sb_init.top = top_panel_fixed_height;
								sb_init.position = 'fixed';
							}
						}
					
					// If sidebar height less then window height
					} else {
						if (scroll_offset + top_panel_fixed_height >= content_top + content_height - sb_height) {
							sb_init.bottom = 0;
							sb_init.position = 'absolute';
						} else {
							sb_init.top = top_panel_fixed_height;
							sb_init.position = 'fixed';
						}
					}
					
					if (sb_init.position != 'undefined') {
						// Detect horizontal position when resize
						var pos = 0;
						if (sb_init.position == 'fixed' || (!jQuery('body').hasClass('body_style_wide') && !jQuery('body').hasClass('body_style_boxed'))) {
							var sb_parent = sb.parent();
							pos = sb_parent.position();
							pos = pos.left + Math.max(0, parseInt(sb_parent.css('paddingLeft'), 10)) 
											+ Math.max(0, parseInt(sb_parent.css('marginLeft'), 10))
											+ (jQuery('body').hasClass('menu_style_right')
												? Math.max(0, parseInt(jQuery('body').css('marginRight'), 10))
												: 0);
						}
						if (sb.hasClass('right'))	sb_init.right = pos;
						else						sb_init.left = pos;
						
						// Set position
						if (sb.css('position') != sb_init.position || CRYPTON_BLOG_STORAGE['scroll_dir_last'] != scroll_dir) {
							if (sb.data('old_style') === undefined) {
								var style = sb.attr('style');
								if (!style) style = '';
								sb.attr('data-old_style', style);
							}
							sb.css(sb_init);
						}
					}

					CRYPTON_BLOG_STORAGE['sb_top_last'] = sb_top;
					CRYPTON_BLOG_STORAGE['scroll_offset_last'] = scroll_offset;
					CRYPTON_BLOG_STORAGE['scroll_dir_last'] = scroll_dir;
	
				} else {
	
					// Unfix when page scrolling to top
					var old_style = sb.data('old_style');
					if (old_style !== undefined)
						sb.attr('style', old_style).removeAttr('data-old_style');
	
				}
			}
		}
	}
	
	
	
	
	
	// Navigation
	//==============================================
	
	// Init Superfish menu
	function crypton_blog_init_sfmenu(selector) {
		jQuery(selector).show().each(function() {
			var animation_in = jQuery(this).parent().data('animation_in');
			if (animation_in == undefined) animation_in = "none";
			var animation_out = jQuery(this).parent().data('animation_out');
			if (animation_out == undefined) animation_out = "none";
			jQuery(this).addClass('inited').superfish({
				delay: 500,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: 		animation_in!='none' ? 500 : 200,
				speedOut:	animation_out!='none' ? 500 : 200,
				autoArrows: false,
				dropShadows: false,
				onBeforeShow: function(ul) {
					if (jQuery(this).parents("ul").length > 1){
						var w = jQuery('.page_wrap').width();  
						var par_offset = jQuery(this).parents("ul").offset().left;
						var par_width  = jQuery(this).parents("ul").outerWidth();
						var ul_width   = jQuery(this).outerWidth();
						if (par_offset+par_width+ul_width > w-20 && par_offset-ul_width > 0)
							jQuery(this).addClass('submenu_left');
						else
							jQuery(this).removeClass('submenu_left');
					}
					if (animation_in!='none') {
						jQuery(this).removeClass('animated fast '+animation_out);
						jQuery(this).addClass('animated fast '+animation_in);
					}
				},
				onBeforeHide: function(ul) {
					if (animation_out!='none') {
						jQuery(this).removeClass('animated fast '+animation_in);
						jQuery(this).addClass('animated fast '+animation_out);
					}
				}
			});
		});
	}
	
	
	
	
	// Post formats init
	//=====================================================
	
	function crypton_blog_init_post_formats(e, cont) {
	
		// MediaElement init
		crypton_blog_init_media_elements(cont);
		
		// Video play button
		cont.find('.format-video .post_featured.with_thumb .post_video_hover:not(.inited)')
			.addClass('inited')
			.on('click', function(e) {
				jQuery(this).parents('.post_featured')
					.addClass('post_video_play')
					.find('.post_video').html(jQuery(this).data('video'));
				jQuery(window).trigger('resize');
				e.preventDefault();
				return false;
			});
	}
	
	
	function crypton_blog_init_media_elements(cont) {
		if (CRYPTON_BLOG_STORAGE['use_mediaelements'] && cont.find('audio:not(.inited),video:not(.inited)').length > 0) {
            if (window.mejs) {
                if (window.mejs.MepDefaults) window.mejs.MepDefaults.enableAutosize = true;
                if (window.mejs.MediaElementDefaults) window.mejs.MediaElementDefaults.enableAutosize = true;
                cont.find('audio:not(.inited),video:not(.inited)').each(function() {
					// If item now invisible
					if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) {
						return;
					}
					if (jQuery(this).parents('.mejs-mediaelement').length == 0 
							&& (CRYPTON_BLOG_STORAGE['init_all_mediaelements'] 
								|| (!jQuery(this).hasClass('wp-audio-shortcode') 
									&& !jQuery(this).hasClass('wp-video-shortcode') 
									&& !jQuery(this).parent().hasClass('wp-playlist')))) {
						var media_tag = jQuery(this);
						var settings = {
							enableAutosize: true,
							videoWidth: -1,		// if set, overrides <video width>
							videoHeight: -1,	// if set, overrides <video height>
							audioWidth: '100%',	// width of audio player
							audioHeight: 30,	// height of audio player
							success: function(mejs) {
								var autoplay, loop;
								if ( 'flash' === mejs.pluginType ) {
									autoplay = mejs.attributes.autoplay && 'false' !== mejs.attributes.autoplay;
									loop = mejs.attributes.loop && 'false' !== mejs.attributes.loop;
									autoplay && mejs.addEventListener( 'canplay', function () {
										mejs.play();
									}, false );
									loop && mejs.addEventListener( 'ended', function () {
										mejs.play();
									}, false );
								}
							}
						};
						jQuery(this).mediaelementplayer(settings);
					}
				});
			} else
				setTimeout(function() { crypton_blog_init_media_elements(cont); }, 400);
		}
	}
	
	
	// Load the tab's content
	function crypton_blog_tabs_ajax_content_loader(panel, page, oldPanel) {
		if (panel.html().replace(/\s/g, '')=='') {
			var height = oldPanel === undefined ? panel.height() : oldPanel.height();
			if (isNaN(height) || height < 100) height = 100;
			panel.html('<div class="crypton_blog_tab_holder" style="min-height:'+height+'px;"></div>');
		} else
			panel.find('> *').addClass('crypton_blog_tab_content_remove');
		panel.data('need-content', false).addClass('crypton_blog_loading');
		jQuery.post(CRYPTON_BLOG_STORAGE['ajax_url'], {
			nonce: CRYPTON_BLOG_STORAGE['ajax_nonce'],
			action: 'crypton_blog_ajax_get_posts',
			blog_template: panel.data('blog-template'),
			blog_style: panel.data('blog-style'),
			posts_per_page: panel.data('posts-per-page'),
			cat: panel.data('cat'),
			parent_cat: panel.data('parent-cat'),
			post_type: panel.data('post-type'),
			taxonomy: panel.data('taxonomy'),
			page: page
		}).done(function(response) {
			panel.removeClass('crypton_blog_loading');
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: CRYPTON_BLOG_STORAGE['strings']['ajax_error'] };
				console.log(response);
			}
			if (rez.error !== '') {
				panel.html('<div class="crypton_blog_error">'+rez.error+'</div>');
			} else {
				panel.prepend(rez.data).fadeIn(function() {
					jQuery(document).trigger('action.init_shortcodes', [panel]);
					jQuery(document).trigger('action.init_hidden_elements', [panel]);
					jQuery(window).trigger('scroll');
					setTimeout(function() {
						panel.find('.crypton_blog_tab_holder,.crypton_blog_tab_content_remove').remove();
						jQuery(window).trigger('scroll');
					}, 600);
				});
			}
		});
	}
	
	
	// Forms validation
	//-------------------------------------------------------
	
	// Comments form
	function crypton_blog_comments_validate(form) {
		form.find('input').removeClass('error_field');
		var comments_args = {
			error_message_text: CRYPTON_BLOG_STORAGE['strings']['error_global'],	// Global error message text (if don't write in checked field)
			error_message_show: true,									// Display or not error message
			error_message_time: 4000,									// Error message display time
			error_message_class: 'crypton_blog_messagebox crypton_blog_messagebox_style_error',	// Class appended to error message block
			error_fields_class: 'error_field',							// Class appended to error fields
			exit_after_first_error: false,								// Cancel validation and exit after first error
			rules: [
				{
					field: 'comment',
					min_length: { value: 1, message: CRYPTON_BLOG_STORAGE['strings']['text_empty'] },
					max_length: { value: CRYPTON_BLOG_STORAGE['comment_maxlength'], message: CRYPTON_BLOG_STORAGE['strings']['text_long']}
				}
			]
		};
		if (form.find('.comments_author input[aria-required="true"]').length > 0) {
			comments_args.rules.push(
				{
					field: 'author',
					min_length: { value: 1, message: CRYPTON_BLOG_STORAGE['strings']['name_empty']},
					max_length: { value: 60, message: CRYPTON_BLOG_STORAGE['strings']['name_long']}
				}
			);
		}
		if (form.find('.comments_email input[aria-required="true"]').length > 0) {
			comments_args.rules.push(
				{
					field: 'email',
					min_length: { value: 1, message: CRYPTON_BLOG_STORAGE['strings']['email_empty']},
					max_length: { value: 60, message: CRYPTON_BLOG_STORAGE['strings']['email_long']},
					mask: { value: CRYPTON_BLOG_STORAGE['email_mask'], message: CRYPTON_BLOG_STORAGE['strings']['email_not_valid']}
				}
			);
		}
		var error = crypton_blog_form_validate(form, comments_args);
		return !error;
	}


});



function go_anim(){
    window.onload = function() {

        // Adjustable variables
        var settings = {
            pointDensity: 8,
            connections: 2,
            sizeVariation: 0.3,
            velocity: 0.00003,
            maxMovement: 50,
            attractionRange: 400,
            attractionFactor: 0.06,
            imagePath: CRYPTON_BLOG_STORAGE['theme_url'] + '/images/bitcoin.png',
            imgWidth: 23,
            imgHeight: 23,
            lineColor: "#343b47",
            particleDensity: 0.2,
            particleChance: 0.2,
            particleVelocity: 70,
            particleColor: "#49505c",
            particleLength: 10,
            flashRadius: 18,
            flashOpacity: 0, //0.3,
            flashDecay: 0 //0.3
        };

        var start = null,
            delta = 0,
            lasttimestamp = null;

        var points = [],
            particles = [];

        var mousePoint = {x: 0, y: 0};

        var img = new Image();
        img.src = settings.imagePath;

        var canvas = document.getElementById('canvas'),
            ctx = canvas.getContext('2d');

        // resize the canvas to fill browser window dynamically
        var resizeTimer;
        window.addEventListener('resize', resizeCanvas, false);
        function resizeCanvas() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                createPoints();
                drawFrame();
                //canvas.className += " go";
            }, 250);

        }
        resizeCanvas();

        createPoints();



        setTimeout(function() {
            canvas.className += " ready";
        }, 500);



        document.onmousemove = handleMouseMove;

        window.requestAnimationFrame(animate);

        function createPoints() {
            points = [];
            particles = [];
            for(var x = 0 - 100; x < canvas.width + 100; x = x + 1000/settings.pointDensity) {
                for(var y = 0 - 100; y < canvas.height + 100; y = y + 1000/settings.pointDensity) {
                    var px = Math.floor(x + Math.random()*1000/settings.pointDensity);
                    var py = Math.floor(y + Math.random()*1000/settings.pointDensity);
                    var pSizeMod = Math.random()*settings.sizeVariation+1;
                    var pw = settings.imgWidth*pSizeMod;
                    var ph = settings.imgHeight*pSizeMod;
                    var pAnimOffset = Math.random()*2*Math.PI;
                    var p = {x: px, originX: px, y: py, originY: py, w: pw, h: ph, sizeMod: pSizeMod, animOffset: pAnimOffset, attraction: 0, flashOpacity: 0};
                    points.push(p);
                }
            }

            for(var i = 0; i < points.length; i++) {
                var closest = [];
                var p1 = points[i];
                for(var j = 0; j < points.length; j++) {
                    var p2 = points[j];
                    if(!contains(p2.closest, p1) && p1 != p2) {
                        var placed = false;
                        for(var k = 0; k < settings.connections; k++) {
                            if(!placed && closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }

                        for(var k = 0; k < settings.connections; k++) {
                            if(!placed && getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
                p1.closest = closest;
            }
        }

        function animate(timestamp) {
            // Calculate frametime
            if (!start) {
                start = timestamp;
                lasttimestamp = timestamp;
            }
            var elapsed = timestamp - start,
                delta = (timestamp - lasttimestamp)/100;
            lasttimestamp = timestamp;

            // Move points around
            for (var i = 0; i < points.length; i++) {
                var point = points [i];

                var attractionOffset = {x: 0, y: 0};
                var distanceToMouse = getDistance({x: point.originX, y: point.originY}, mousePoint);
                if (distanceToMouse <= settings.attractionRange) {
                    displacementFactor = (Math.cos(distanceToMouse / settings.attractionRange * Math.PI) + 1) / 2 * settings.attractionFactor;
                    attractionOffset.x = displacementFactor * (mousePoint.x - point.x);
                    attractionOffset.y = displacementFactor * (mousePoint.y - point.y);
                }

                point.x = point.originX + Math.sin(elapsed*settings.velocity+point.animOffset)*settings.maxMovement*point.sizeMod+attractionOffset.x;
                point.y = point.originY - Math.cos(elapsed*settings.velocity+point.animOffset)*settings.maxMovement*point.sizeMod+attractionOffset.y;

                point.flashOpacity = Math.max(0, point.flashOpacity - settings.flashDecay * delta);
            }

            // Move particles
            for (var i = 0; i < particles.length; i++) {
                var particle = particles[i];

                var origin = points[particle.origin];
                var target = origin.closest[particle.target];

                var distance = getDistance({x: origin.x, y: origin.y}, {x: target.x, y: target.y});
                var direction = {x: (target.x - origin.x) / distance, y: (target.y - origin.y) / distance};

                particle.traveled += settings.particleVelocity * delta;
                particle.direction = direction;

                particle.x = origin.x + direction.x * particle.traveled;
                particle.y = origin.y + direction.y * particle.traveled;

                if (!between(origin, {x: particle.x}, target)) {
                    particles.splice(i, 1);
                    i--;
                }

            }

            // Spawn new particles
            for (var i = 0; i < settings.particleDensity * points.length; i++) {
                if (Math.random() < settings.particleChance * delta) {
                    var pOriginNum = Math.floor(Math.random()*points.length);
                    var pOrigin = points[pOriginNum];
                    var pTargetNum = Math.floor(Math.random()*pOrigin.closest.length);
                    var px = pOrigin.x;
                    var py = pOrigin.y;
                    var p = {origin: pOriginNum, target: pTargetNum, x: px, y: py, traveled: 0, direction: {x: 0, y: 0}};
                    particles.push(p);
                    pOrigin.flashOpacity = settings.flashOpacity;
                }
            }

            drawFrame();

            window.requestAnimationFrame(animate);

        }

        function handleMouseMove(event) {
            mousePoint.x = event.pageX;
            mousePoint.y = event.pageY;
            // console.log(mousePoint.x, mousePoint.y);
        }

        function drawFrame() {
            ctx.clearRect(0,0,canvas.width,canvas.height);

            for (var i = 0; i < points.length; i++) {
                drawLines(points[i]);
            }

            for (var i = 0; i < particles.length; i++) {
                var particle = particles[i];
                ctx.moveTo(particle.x, particle.y);
                ctx.lineTo(particle.x - particle.direction.x * settings.particleLength, particle.y - particle.direction.y * settings.particleLength);
                ctx.strokeStyle = settings.particleColor;
                ctx.stroke();
            }

            for (var i = 0; i < points.length; i++) {
                var point = points [i];
                if (point.flashOpacity > 0) {
                    ctx.beginPath();
                    ctx.rect(point.x - settings.flashRadius, point.y - settings.flashRadius, settings.flashRadius * 2, settings.flashRadius * 2);
                    var gradient = ctx.createRadialGradient(point.x, point.y, settings.flashRadius, point.x, point.y, 1);
                    gradient.addColorStop(0, "rgba(255, 255, 255, 0)");
                    gradient.addColorStop(1, "rgba(255, 255, 255, " + point.flashOpacity + ")");
                    ctx.fillStyle = gradient;
                    ctx.fill();
                }
                ctx.drawImage(img, point.x-point.w/2, point.y-point.h/2, point.w, point.h);
            }
        }

        function drawLines(p) {
            for(var i in p.closest) {
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
                ctx.lineTo(p.closest[i].x, p.closest[i].y);
                ctx.strokeStyle = settings.lineColor;
                ctx.stroke();
            }
        }

        //Util
        function getDistance(p1, p2) {
            return Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));
        }

        function contains(a, obj) {
            if (a !== undefined) {
                for (var i = 0; i < a.length; i++) {
                    if (a[i] === obj) {
                        return true;
                    }
                }
            }
            return false;
        }

        function between(p1, p2, t) {
            return (p1.x - p2.x) * (p2.x - t.x) > 0;
        }

    }

}