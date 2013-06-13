
/* ---------------------------------------------------------------------- */
/*	DEFAULT ACTIONS
/* ---------------------------------------------------------------------- */
	browserWidth = document.body.clientWidth; // get body content width
	
	//jQuery( '.no-js' ).removeClass( 'no-js' );

	//IE8 fixes
		jQuery( '.lie8 img[height]' ).removeAttr( 'height' );
		//jQuery( 'html.lie8 .price-spec li:nth-child(even)' ).addClass( 'even' );

	//logo
		function isHighDPI() {
			var mediaQuery = '(-webkit-min-device-pixel-ratio: 1.5),(min--moz-device-pixel-ratio: 1.5),(-o-min-device-pixel-ratio: 3/2),(min-device-pixel-ratio: 1.5),(min-resolution: 1.5dppx)';
			return ( window.devicePixelRatio > 1 || ( window.matchMedia && window.matchMedia(mediaQuery).matches ) );
		} // /isHighDPI

		if ( isHighDPI() && jQuery( '.logo img' ).data( 'highdpi' ) )
			jQuery( '.logo img' ).attr( 'src', jQuery( '.logo img' ).data( 'highdpi' ) );

	//posts/projects/staff image overlay
		jQuery( '.image-container a' ).hover( function() {
				jQuery( this ).find( '.overlay' ).stop().animate( { top : 0 }, 250 );
			}, function() {
				jQuery( this ).find( '.overlay' ).stop().animate( { top : '150%' }, 250 );
			} );
			
	//Set content page to fit with browser height
	wrapHeight = jQuery('.wrapper').height();
	screenBrowserHeight = jQuery(window).height(); // get browser height 
	
	if ( wrapHeight < screenBrowserHeight ) {
		jQuery('#content').css({height: screenBrowserHeight-220});
	}

jQuery(document).ready(function($) {
	
	/* ---------------------------------------------------------------------- */
	/*	Dropdown menu navigation - TOP and MAIN menu
	/* ---------------------------------------------------------------------- */
	$('#main-nav ul > li > ul, #main-nav ul > li > ul > li > ul, #main-nav ul > li > ul > li > ul> li > ul, .top-menu  ul > li > ul, .top-menu  ul > li > ul > li > ul, .top-menu  ul > li > ul > li > ul> li > ul ').parent('li').addClass('parent-list');
	$('.parent-list').find("a:first").append(' <span class="sub-indicator">&raquo;</span>');

	$("#main-nav li , .top-menu li").each(function(){	
		var $sublist = $(this).find('ul:first');		
		$(this).hover(function(){	
			$sublist.stop().css({overflow:"hidden", height:"auto", display:"none"}).slideDown(200, function(){
				$(this).css({overflow:"visible", height:"auto"});
			});	
		},
		function(){	
			$sublist.stop().slideUp(200, function()	{	
				$(this).css({overflow:"hidden", display:"none"});
			});
		});	
	});
	
	//MISC
	
	/*if ($(".menu-item:last")){
		$(".menu-item:last").html($(".menu-item:last").html().replace("</a> |","</a>")); 
	} */  

	/* ---------------------------------------------------------------------- */
	/*	Detect touch device
	/* ---------------------------------------------------------------------- */

	(function() {

		if( Modernizr.touch ) {

			$('body').addClass('touch-device');

		}

	})();
	
	/* ---------------------------------------------------------------------- */
	/*	FitVids
	/* ---------------------------------------------------------------------- */

	(function() {

		function adjustVideos() {

			var $videos = $('.fluid-width-video-wrapper');

			$videos.each(function() {

				var $this        = $(this)
					playerWidth  = $this.parent().width(),
					playerHeight = playerWidth / $this.data('aspectRatio');

				$this.css({
					'height' : playerHeight,
					'width'  : playerWidth
				})

			});

		}

		$('.container').each(function(){

			var selectors  = [
				"iframe[src^='http://player.vimeo.com']",
				"iframe[src^='http://www.youtube.com']",
				"iframe[src^='http://blip.tv']",
				"iframe[src^='http://www.kickstarter.com']", 
				"object",
				"embed"
			],
				$allVideos = $(this).find(selectors.join(','));

			$allVideos.each(function(){

				var $this = $(this);

				if ( $this.hasClass('vjs-tech') || this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length )
					return;

				var videoHeight = $this.attr('height') || $this.height(),
					videoWidth  = $this.attr('width') || $this.width();

				$this.css({
					'height' : '100%',
					'width'  : '100%'
				}).removeAttr('height').removeAttr('width')
				.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css({
					'height' : videoHeight,
					'width'  : videoWidth
				}).data( 'aspectRatio', videoWidth / videoHeight );

				adjustVideos();

			});

		});

		$(window).on('resize', function() {

			var timer = window.setTimeout( function() {
				window.clearTimeout( timer );
				adjustVideos();
			}, 30 );

		});

	})();
	
	/* ---------------------------------------------------------------------- */
	/*	AudioPlayerV1
	/* ---------------------------------------------------------------------- */

	(function() {

		var $player = $('.APV1_wrapper');

		if( $player.length ) {

			function adjustPlayer( resize ){
			
				$player.each(function( i ) {

					var $this            = $(this),
						$lis             = $this.children('li'),
						$progressBar     = $this.children('li.APV1_container'),
						playerWidth      = $this.parent().width(),
						lisWidth         = 0;

					if( !resize )
						$this.prev('audio').hide()

					if( playerWidth <= 300 ) {
						$this.addClass('APV1_player_width_300');
					} else {
						$this.removeClass('APV1_player_width_300');
					}

					if( playerWidth <= 250 ) {
						$this.addClass('APV1_player_width_250');
					} else {
						$this.removeClass('APV1_player_width_250');
					}

					if( playerWidth <= 200 ) {
						$this.addClass('APV1_player_width_200');
					} else {
						$this.removeClass('APV1_player_width_200');
					}

					$lis.each(function() {

						var $li = $(this);
						lisWidth += $li.width()

					});

					$this.width( $this.parent().width() );
					$progressBar.width( playerWidth - ( lisWidth - $progressBar.width() ) );
					
				});

			}

			adjustPlayer();

			$(window).on('resize', function() {

				var timer = window.setTimeout( function() {
					window.clearTimeout( timer );
					adjustPlayer( resize = true );
				}, 30 );

			});

		}

	})();
	
	/* ---------------------------------------------------------------------- */
	/*	Toggle Content
	/* ---------------------------------------------------------------------- */
	
	$(".toggle-container").hide(); 
		$("h3.trigger").click(function(){
			$(this).toggleClass("active").next().slideToggle("normal");
			return false;
		});
	
	/* ---------------------------------------------------------------------- */
	/*	Accordion Content
	/* ---------------------------------------------------------------------- */

	(function() {

		var $container = $('.acc-container'),
			$trigger   = $('.acc-trigger');

		$container.hide();
		$trigger.first().addClass('active').next().show();

		var fullWidth = $container.outerWidth(true);
		$trigger.css('width', fullWidth);
		$container.css('width', fullWidth);
		
		$trigger.on('click', function(e) {
			if( $(this).next().is(':hidden') ) {
				$trigger.removeClass('active').next().slideUp(300);
				$(this).toggleClass('active').next().slideDown(300);
			}
			e.preventDefault();
		});

		// Resize
		$(window).on('resize', function() {
			fullWidth = $container.outerWidth(true)
			$trigger.css('width', $trigger.parent().width() );
			$container.css('width', $container.parent().width() );
		});

	})();
	
	/* ---------------------------------------------------- */
	/*	Content Tabs
	/* ---------------------------------------------------- */

	(function() {

		var $tabsNav    = $('.tabs-nav'),
			$tabsNavLis = $tabsNav.children('li'),
			$tabContent = $('.tab-content');

		$tabsNav.each(function() {
			var $this = $(this);

			$this.next().children('.tab-content').hide()
												 .first().show()
												 .css('background-color','#ffffff');

			$this.children('li').first().addClass('active').show();
		});

		$tabsNavLis.on('click', function(e) {
			var $this = $(this);

			$this.siblings().removeClass('active').end()
				 .addClass('active');
			
			$this.parent().next().children('.tab-content').hide()
														  .siblings( $this.find('a').attr('href') ).fadeIn()
														  .css('background-color','#ffffff');

			e.preventDefault();
		});

	})();
	
	
	/* ---------------------------------------------------- */
	/*	Widget Tabs
	/* ---------------------------------------------------- */
	(function() {
		
	$("#tabbed-widget .tabs-wrap").hide();
	$("#tabbed-widget ul.posts-taps li:first").addClass("active").show();
	$("#tabbed-widget .tabs-wrap:first").show(); 
	$("#tabbed-widget  li.tabs").click(function() {
		$("#tabbed-widget ul.posts-taps li").removeClass("active");
		$(this).addClass("active");
		$("#tabbed-widget .tabs-wrap").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).slideDown();
		return false;
	});
	
	})();
	
});