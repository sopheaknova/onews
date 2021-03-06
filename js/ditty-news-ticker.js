/**
 * News Ticker
 * Date: 3/21/2013
 *
 * @author Metaphor Creations
 * @version 1.1.3
 *
 **/

( function($) {
	
	var methods = {
	
		init : function( options ) {

			return this.each( function(){

				// Create default options
				var settings = {
					id										: '',
					type									: 'scroll',
					scroll_direction			: 'left',
					scroll_speed					: 10,
					scroll_pause					: 0,
					scroll_spacing				: 40,
					scroll_units					: 10,
					rotate_type						: 'fade',
					auto_rotate						: 0,
					rotate_delay					: 10,
					rotate_pause					: 0,
					rotate_speed					: 10,
					rotate_ease						: 'easeOutExpo',
					nav_reverse						: 0,
					before_change					: function(){},
					after_change					: function(){},
					after_load						: function(){}
				};
				
				// Useful variables. Play carefully.
        var vars = {
        	id							: settings.id,
	        tick_count			: 0,
	        current_tick		: 0,
	        reverse					: 0,
	        running					: 0
        };
				
				// Add any set options
				if (options) { 
					$.extend(settings, options);
				}

				// Create variables
				var $ticker = $(this).find('.mtphr-dnt-tick-container'),
					$nav_prev = $ticker.find('.mtphr-dnt-nav-prev'),
					$nav_next = $ticker.find('.mtphr-dnt-nav-next'),
					$nav_controls = $ticker.siblings('.mtphr-dnt-control-links'),
					ticker_width = $ticker.outerWidth(),
					ticker_height = 0,
					ticks = [],
					ticker_scroll,
					ticker_scroll_resize = true,
					ticker_delay,
					rotate_adjustment = settings.rotate_type,
					after_change_timeout,
					ticker_pause = false,
					offset = 20,
					touch_down_x,
					touch_down_y,
					touch_link = '',
					touch_target = '';

				// Add the vars
				$ticker.data('ditty:vars', vars);
				
				// Save the tick count & total
				vars.tick_count = $ticker.find('.mtphr-dnt-tick').length;

				// Start the first tick
				if( vars.tick_count > 0 ) {

					// Setup a ticker scroll
					if( settings.type == 'scroll' ) {
						mtphr_dnt_scroll_setup();
						
					// Setup a ticker rotator
					} else if( settings.type == 'rotate' ) {
						mtphr_dnt_rotator_setup();
					}	
		    }
		    
		    
		    
		    /**
		     * Setup the ticker scroll
		     *
		     * @since 1.1.0
		     */
		    function mtphr_dnt_scroll_setup() {

		    	var $first = $ticker.find('.mtphr-dnt-tick:first');
		    	if( $first.attr('style') ) {
			    	var style = $first.attr('style');
			    	var style_array = style.split('width:');
			    	ticker_scroll_resize = (style_array.length > 1) ? false : true;
		    	}	
		    	
		    	// Loop through the tick items
					$ticker.find('.mtphr-dnt-tick').each( function(index) {
						
						// Find the greatest tick height
						if( $(this).outerHeight() > ticker_height ) {
							ticker_height = $(this).outerHeight();
						}
						
						if( settings.scroll_direction == 'up' || settings.scroll_direction == 'down' ) {
							$(this).css('height', 'auto');
						}
					});
					
					// Set the ticker height
					$ticker.css('height',ticker_height+'px');
		    	
		    	// Loop through the tick items
					$ticker.find('.mtphr-dnt-tick').each( function(index) {
						
						// Make sure the ticker is visible
						$(this).show();
						
						// Add the tick data
						var tick = [{'headline':$(this)}];
	
						// Add the tick to the array
						ticks.push(tick);
					});
					
					// Set the initial position of the ticks
					mtphr_dnt_scroll_reset_ticks();
										
					// Start the scroll loop
					mtphr_dnt_scroll_loop();
					
					// Clear the loop on mouse hover
					$ticker.hover(
					  function () {
					  	if( settings.scroll_pause ) {
					    	clearInterval( ticker_scroll );
					    }
					  }, 
					  function () {
					  	if( settings.scroll_pause ) {
					    	mtphr_dnt_scroll_loop();
					    }
					  }
					);
		    }
		    
		    /**
		     * Create the ticker scroll loop
		     *
		     * @since 1.0.8
		     */
		    function mtphr_dnt_scroll_loop() {
			    
			    // Start the ticker timer
			    clearInterval( ticker_scroll );
					ticker_scroll = setInterval( function() {

						for( var i=0; i<vars.tick_count; i++ ) {
	
							if( ticks[i][0].visible == true ) {
								
								var pos = 'reset';
								
								if( settings.scroll_direction == 'left' || settings.scroll_direction == 'right' ) {
									
									pos = (settings.scroll_direction == 'left') ? mtphr_dnt_scroll_left(i) : mtphr_dnt_scroll_right(i);
									if( pos == 'reset' ) {
										pos = ticks[i][0].reset;
										ticks[i][0].headline.stop(true,true).css('left',pos+'px');
									} else {
										ticks[i][0].headline.stop(true,true).animate( {
											left: pos+'px'
										}, 100, 'linear' );
									}
								} else {
									
									pos = (settings.scroll_direction == 'up') ? mtphr_dnt_scroll_up(i) : mtphr_dnt_scroll_down(i);
									if( pos == 'reset' ) {
										pos = ticks[i][0].reset;
										ticks[i][0].headline.stop(true,true).css('top',pos+'px');
									} else {
										ticks[i][0].headline.stop(true,true).animate( {
											top: pos+'px'
										}, 100, 'linear' );
									}
								}
								
								ticks[i][0].position = pos;
							}
						}
			    }, 100);	
		    }

		    /**
		     * Scroll the ticker left
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_scroll_left( i ) {
			    
			    // Find the new position
					var pos = parseFloat(ticks[i][0].position - settings.scroll_speed);
					
					// Reset the tick if off the screen
					if( pos < -(ticks[i][0].width+offset) ) {
						pos = mtphr_dnt_scroll_check_current(i);
					} else if( pos < parseFloat(ticker_width-ticks[i][0].width-settings.scroll_spacing) ) {
						mtphr_dnt_scroll_check_next(i);
					}
					
					return pos;
		    }
		    
		    /**
		     * Scroll the ticker right
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_scroll_right( i ) {
			    
			    // Find the new position
					var pos = ticks[i][0].position + settings.scroll_speed;

					// Reset the tick if off the screen
					if( pos > ticker_width+offset ) {
						pos = mtphr_dnt_scroll_check_current(i);
					} else if( pos > settings.scroll_spacing ) {	
						mtphr_dnt_scroll_check_next(i);
					}
					
					return pos;
		    }
		    
		    /**
		     * Scroll the ticker up
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_scroll_up( i ) {
			    
			    // Find the new position
					var pos = ticks[i][0].position - settings.scroll_speed;

					// Reset the tick if off the screen
					if( pos < -(ticks[i][0].height+offset) ) {
						pos = mtphr_dnt_scroll_check_current(i);
					} else if( pos < ticker_height-ticks[i][0].height-settings.scroll_spacing ) {	
						mtphr_dnt_scroll_check_next(i);
					}
					
					return pos;
		    }
		    
		    /**
		     * Scroll the ticker down
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_scroll_down( i ) {
			    
			    // Find the new position
					var pos = ticks[i][0].position + settings.scroll_speed;

					// Reset the tick if off the screen
					if( pos > ticker_height+offset ) {
						pos = mtphr_dnt_scroll_check_current(i);
					} else if( pos > settings.scroll_spacing ) {	
						mtphr_dnt_scroll_check_next(i);
					}
					
					return pos;
		    }
 
		    /**
		     * Check the current tick position
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_scroll_check_current( i ) {
						
					if( vars.tick_count > 1 ) {
						ticks[i][0].visible = false;
					}
					
					return 'reset';
		    }
		    
		    /**
		     * Check the next tick visibility
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_scroll_check_next( i ) {
						
					if( i==(vars.tick_count-1) ) {
						ticks[0][0].visible = true;
					} else {
						ticks[(i+1)][0].visible = true;
					}
		    }
		    
		    /**
		     * Resize the scroll ticks
		     *
		     * @since 1.1.0
		     */
		    function mtphr_dnt_scroll_resize_ticks() {

			    for( var i=0; i<vars.tick_count; i++ ) {
				    
				    // Set the tick position
						var position;
						
						var $tick = ticks[i][0].headline;
						
						switch( settings.scroll_direction ) {
							case 'left':
								position = ticker_width+offset;
								if( ticks[i][0].visible == false ) {
									$tick.css('left',position+'px');
								}
								break;
								
							case 'right':
								position = parseInt('-'+($tick.outerWidth()+offset));
								if( ticks[i][0].visible == false ) {
									$tick.css('left',position+'px');
								}
								break;
								
							case 'up':
								if( ticker_scroll_resize ) {
									$tick.css('width',ticker_width);
								}
								position = parseInt(ticker_height+offset);
								if( ticks[i][0].visible == false ) {
									$tick.css('top',position+'px');
								}
								break;
								
							case 'down':
								if( ticker_scroll_resize ) {
									$tick.css('width',ticker_width);
								}
								position = parseInt('-'+($tick.outerHeight()+offset));
								if( ticks[i][0].visible == false ) {
									$tick.css('top',position+'px');
								}
								break;
						}
						
						// Adjust the tick data
						ticks[i][0].width = $tick.outerWidth();
						ticks[i][0].height = $tick.outerHeight();
						if( ticks[i][0].visible == false ) {
							ticks[i][0].position = position;
						}
						ticks[i][0].reset = position;
			    }
		    }
		    
		    /**
		     * Reset the scroller for vertical scrolls
		     *
		     * @since 1.1.0
		     */
		    function mtphr_dnt_scroll_reset_ticks() {

		    	for( var i=0; i<vars.tick_count; i++ ) {
		    	
		    		var $tick = ticks[i][0].headline;
						
						switch( settings.scroll_direction ) {
							case 'left':
								position = ticker_width+offset;
								$tick.stop(true,true).css('left',position+'px');	
								break;
								
							case 'right':
								position = parseInt('-'+($tick.outerWidth()+offset));
								$tick.stop(true,true).css('left',position+'px');	
								break;
								
							case 'up':
								if( ticker_scroll_resize ) {
									$tick.css('width',ticker_width);
								}
								position = parseInt(ticker_height+offset);
								$tick.stop(true,true).css('top',position+'px');	
								break;
								
							case 'down':
								if( ticker_scroll_resize ) {
									$tick.css('width',ticker_width);
								}
								position = parseInt('-'+($tick.outerHeight()+offset));
								$tick.stop(true,true).css('top',position+'px');	
								break;
						}
						
						ticks[i][0].width = $tick.outerWidth();
						ticks[i][0].height = $tick.outerHeight();
						ticks[i][0].position = position;
						ticks[i][0].reset = position;
						ticks[i][0].visible = false;
						
						// Reset the current tick
						vars.current_tick = 0;
						
						// Set the first tick visibility
						ticks[vars.current_tick][0].visible = true;		
			    }
		    }
		    
		    
		    
		    
		    /**
		     * Setup the ticker rotator
		     *
		     * @since 1.0.8
		     */
		    function mtphr_dnt_rotator_setup() {

		    	// Loop through the tick items
					$ticker.find('.mtphr-dnt-tick').each( function(index) {
	
						// Add the tick to the array
						ticks.push($(this));
						
					});

					// Resize the ticks
					mtphr_dnt_rotator_resize_ticks();
					
					// Find the rotation type and create the dynamic rotation init function
					var rotate_init_name = 'mtphr_dnt_rotator_'+settings.rotate_type+'_init';
					var mtphr_dnt_rotator_type_init = eval('('+rotate_init_name+')');
					mtphr_dnt_rotator_type_init( $ticker, ticks, parseInt(settings.rotate_speed*100), settings.rotate_ease );
					mtphr_dnt_rotator_update_links( 0 );
					
					// Start the rotator rotate
					if( settings.auto_rotate ) {
						mtphr_dnt_rotator_delay();
					}
					
					// Clear the loop on mouse hover
					$ticker.hover(
					  function (e) {
					  	if( settings.auto_rotate && settings.rotate_pause && !vars.running ) {
					    	clearInterval( ticker_delay );
					    }
					  }, 
					  function () {
					  	if( settings.auto_rotate && settings.rotate_pause  && !vars.running ) {
					    	mtphr_dnt_rotator_delay();
					    }
					  }
					);
		    }
		    
		    /**
		     * Create the ticker rotator loop
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_rotator_delay() {

			    // Start the ticker timer
			    clearInterval( ticker_delay );
					ticker_delay = setInterval( function() {

						// Find the new tick
			    	var new_tick = parseInt(vars.current_tick + 1);
						if( new_tick == vars.tick_count ) {
							new_tick = 0;
						}
						
						mtphr_dnt_rotator_update( new_tick );

			    }, parseInt(settings.rotate_delay*1000));	
		    }
		    
		    /**
		     * Create the rotator update call
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_rotator_update( new_tick ) {
		    	
		    	// Clear the interval
		    	if( settings.auto_rotate ) {
			    	clearInterval( ticker_delay );
			    }
		    
		    	// Trigger the before change callback
          settings.before_change.call( this, $ticker );
          
          // Set the running variable
          vars.running = 1;
 
			    // Rotate the current tick out
					mtphr_dnt_rotator_out( new_tick );
					
					// Rotate the new tick in
					mtphr_dnt_rotator_in( new_tick );
					
					// Set the current tick
					vars.current_tick = new_tick;

					// Trigger the after change callback
					after_change_timeout = setTimeout( function() {
					
						settings.after_change.call( this, $ticker );
						
						// Reset the rotator type & variables
						rotate_adjustment = settings.rotate_type;
						vars.reverse = 0;
						vars.running = 0;
						
						// Restart the interval
						if( settings.auto_rotate ) {
				    	mtphr_dnt_rotator_delay();
				    }
						
					}, parseInt(settings.rotate_speed*100) );
		    }
		    
		    /**
		     * Update the control links
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_rotator_update_links( new_tick ) {
			    
			    if( $nav_controls ) {
          	$nav_controls.children('a').removeClass('active');
          	$nav_controls.children('a[href="'+new_tick+'"]').addClass('active');
          }
		    }
		    
		    /**
		     * Create the rotator in function calls
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_rotator_in( new_tick ) {
		    	
		    	// Update the links
		    	mtphr_dnt_rotator_update_links( new_tick );
			    
			    // Find the rotation type and create the dynamic rotation in function
					var rotate_in_name = 'mtphr_dnt_rotator_'+rotate_adjustment+'_in';
					var mtphr_dnt_rotator_type_in = eval('('+rotate_in_name+')');
					mtphr_dnt_rotator_type_in( $ticker, $(ticks[new_tick]), $(ticks[vars.current_tick]), parseInt(settings.rotate_speed*100), settings.rotate_ease );
		    }
		    
		    /**
		     * Create the rotator out function calls
		     *
		     * @since 1.0.0
		     */
		    function mtphr_dnt_rotator_out( new_tick ) {
			    
			    // Find the rotation type and create the dynamic rotation out function
					var rotate_out_name = 'mtphr_dnt_rotator_'+rotate_adjustment+'_out';
					var mtphr_dnt_rotator_type_out = eval('('+rotate_out_name+')');
					mtphr_dnt_rotator_type_out( $ticker, $(ticks[vars.current_tick]), $(ticks[new_tick]), parseInt(settings.rotate_speed*100), settings.rotate_ease );
		    }

		    /**
		     * Resize the rotator ticks
		     *
		     * @since 1.0.8
		     */
		    function mtphr_dnt_rotator_resize_ticks() {

			    for( var i=0; i<vars.tick_count; i++ ) {
				    
				    // Set the width of the tick
				    $(ticks[i]).width( ticker_width+'px' );
			    }
			    
			    // Resize the ticker
			    var h = $(ticks[vars.current_tick]).outerHeight();
					$ticker.stop().css( 'height', h+'px' );
		    }
		    
		    
		    
		    
		    /**
		     * Rotator fade scripts
		     *
		     * @since 1.0.0
		     */
				function mtphr_dnt_rotator_fade_init( $ticker, ticks, rotate_speed, ease ) {
					
					// Get the first tick
					$tick = ticks[0];
					
					// Find the width of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
					
					// Set the height of the ticker
					$ticker.css( 'height', h+'px' );
			
					// Set the initial position of the width & make sure it's visible
					$tick.show();
			  }
			
				// Show the new tick
				function mtphr_dnt_rotator_fade_in( $ticker, $tick, $prev, rotate_speed, ease ) {
			    $tick.fadeIn( rotate_speed );
			    
			    var h = $tick.outerHeight();
			
					// Resize the ticker
					$ticker.stop().animate( {
						height: h+'px'
					}, rotate_speed, ease, function() {
					});
			  }
			  
			  // Hide the old tick
			  function mtphr_dnt_rotator_fade_out( $ticker, $tick, $next, rotate_speed, ease ) {
			    $tick.fadeOut( rotate_speed );
			  }
			  
			  
			  
			  
			  /**
		     * Rotator slide left scripts
		     *
		     * @since 1.0.0
		     */
				function mtphr_dnt_rotator_slide_left_init( $ticker, ticks, rotate_speed, ease ) {
					
					// Get the first tick
					$tick = ticks[0];
					
					// Find the dimensions of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
					
					// Set the height of the ticker
					$ticker.css( 'height', h+'px' );
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'left', 0 );
					$tick.show();
					
					// If there are any images, reset height after loading
					if( $tick.find('img').length > 0 ) {
						
						$tick.find('img').each( function(index) {
							
							jQuery(this).load( function() {
								
								// Find the height of the tick
								var h = $tick.outerHeight();
						
								// Set the height of the ticker
								$ticker.css( 'height', h+'px' );
							});	
						});	
					}
			  }
			  
				// Show the new tick
				function mtphr_dnt_rotator_slide_left_in( $ticker, $tick, $prev, rotate_speed, ease ) {
					
					// Find the dimensions of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'left', parseFloat(w+offset)+'px' );
					$tick.show();
					
					// Resize the ticker
					$ticker.stop().animate( {
						height: h+'px'
					}, rotate_speed, ease, function() {
					});
					
					// Slide the tick in
					$tick.stop().animate( {
						left: '0'
					}, rotate_speed, ease, function() {
					});
			  }
			  
			  // Hide the old tick
			  function mtphr_dnt_rotator_slide_left_out( $ticker, $tick, $next, rotate_speed, ease ) {
			    
			    // Find the dimensions of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
					
					// Slide the tick in
					$tick.stop().animate( {
						left: '-'+parseFloat(w+offset)+'px'
					}, rotate_speed, ease, function() {
						// Hide the tick
						$tick.hide();
					});
			  }
			  
			  
			  
			  
			  /**
			   * Rotator slide right scripts
			   *
			   * @since 1.0.0
			   */
				function mtphr_dnt_rotator_slide_right_init( $ticker, ticks, rotate_speed, ease ) {
					
					// Get the first tick
					$tick = ticks[0];
					
					// Find the dimensions of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
					
					// Set the height of the ticker
					$ticker.css( 'height', h+'px' );
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'left', 0 );
					$tick.show();
					
					// If there are any images, reset height after loading
					if( $tick.find('img').length > 0 ) {
						
						$tick.find('img').each( function(index) {
							
							jQuery(this).load( function() {
								
								// Find the height of the tick
								var h = $tick.outerHeight();
						
								// Set the height of the ticker
								$ticker.css( 'height', h+'px' );
							});	
						});	
					}
			  }
			  
				// Show the new tick
				function mtphr_dnt_rotator_slide_right_in( $ticker, $tick, $prev, rotate_speed, ease ) {
					
					// Find the dimensions of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'left', '-'+parseFloat(w+offset)+'px' );
					$tick.show();
					
					// Resize the ticker
					$ticker.stop().animate( {
						height: h+'px'
					}, rotate_speed, ease, function() {
					});
					
					// Slide the tick in
					$tick.stop().animate( {
						left: '0'
					}, rotate_speed, ease, function() {
					});
			  }
			  
			  // Hide the old tick
			  function mtphr_dnt_rotator_slide_right_out( $ticker, $tick, $next, rotate_speed, ease ) {
			    
			    // Find the dimensions of the tick
					var w = $tick.parents('.mtphr-dnt-rotate').outerWidth();
					var h = $tick.outerHeight();
					
					// Slide the tick in
					$tick.stop().animate( {
						left: parseFloat(w+offset)+'px'
					}, rotate_speed, ease, function() {
						// Hide the tick
						$tick.hide();
					});
			  }
			  
			  
			  
			  
			  /**
			   * Rotator slide down scripts
			   *
			   * @since 1.0.0
			   */
				function mtphr_dnt_rotator_slide_down_init( $ticker, ticks, rotate_speed, ease ) {
					
					// Get the first tick
					$tick = ticks[0];
					
					// Find the height of the tick
					var h = $tick.outerHeight();
					
					// Set the height of the ticker
					$ticker.css( 'height', h+'px' );
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'top', 0 );
					$tick.show();
					
					// If there are any images, reset height after loading
					if( $tick.find('img').length > 0 ) {
						
						$tick.find('img').each( function(index) {
							
							jQuery(this).load( function() {
								
								// Find the height of the tick
								var h = $tick.outerHeight();
						
								// Set the height of the ticker
								$ticker.css( 'height', h+'px' );
							});	
						});	
					}
			  }
			  
				// Show the new tick
				function mtphr_dnt_rotator_slide_down_in( $ticker, $tick, $prev, rotate_speed, ease ) {
					
					// Find the height of the tick
					var h = $tick.outerHeight();
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'top', '-'+parseFloat(h+offset)+'px' );
					$tick.show();
					
					// Resize the ticker
					$ticker.stop().animate( {
						height: h+'px'
					}, rotate_speed, ease, function() {
					});
					
					// Slide the tick in
					$tick.stop().animate( {
						top: '0'
					}, rotate_speed, ease, function() {
					});
			  }
			  
			  // Hide the old tick
			  function mtphr_dnt_rotator_slide_down_out( $ticker, $tick, $next, rotate_speed, ease ) {
			    
			    // Find the height of the next tick
					var h = $next.outerHeight();
					
					// Slide the tick in
					$tick.stop().animate( {
						top: parseFloat(h+offset)+'px'
					}, rotate_speed, ease, function() {
						// Hide the tick
						$tick.hide();
					});
			  }

		    

			  
			  /**
			   * Rotator slide up scripts
			   *
			   * @since 1.0.0
			   */
				function mtphr_dnt_rotator_slide_up_init( $ticker, ticks, rotate_speed, ease ) {
					
					// Get the first tick
					$tick = ticks[0];
					
					// Find the height of the tick
					var h = $tick.outerHeight();
			
					// Set the height of the ticker
					$ticker.css( 'height', h+'px' );
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'top', 0 );
					$tick.show();
					
					// If there are any images, reset height after loading
					if( $tick.find('img').length > 0 ) {
						
						$tick.find('img').each( function(index) {
							
							jQuery(this).load( function() {
								
								// Find the height of the tick
								var h = $tick.outerHeight();
						
								// Set the height of the ticker
								$ticker.css( 'height', h+'px' );
							});	
						});	
					}
			  }
			  
				// Show the new tick
				function mtphr_dnt_rotator_slide_up_in( $ticker, $tick, $prev, rotate_speed, ease ) {
					
					// Find the height of the tick
					var h = $tick.outerHeight();
			
					// Set the initial position of the width & make sure it's visible
					$tick.css( 'top', parseFloat($prev.outerHeight()+offset)+'px' );
					$tick.show();
					
					// Resize the ticker
					$ticker.stop().animate( {
						height: h+'px'
					}, rotate_speed, ease, function() {
					});
					
					// Slide the tick in
					$tick.stop().animate( {
						top: '0'
					}, rotate_speed, ease, function() {
					});
			  }
			  
			  // Hide the old tick
			  function mtphr_dnt_rotator_slide_up_out( $ticker, $tick, $next, rotate_speed, ease ) {
			    
			    // Find the height of the next tick
					var h = $tick.outerHeight();
					
					// Slide the tick in
					$tick.stop().animate( {
						top: '-'+parseFloat(h+offset)+'px'
					}, rotate_speed, ease, function() {
						// Hide the tick
						$tick.hide();
					});
			  }
			  
			  
			  

		    /**
		     * Navigation clicks
		     *
		     * @since 1.0.0
		     */
		    if( $nav_prev && settings.type == 'rotate' ) {
		    
		    	$nav_prev.bind('click', function( e ) {
		    		e.preventDefault();
		    		
		    		if(vars.running) return false;
			    	
			    	// Find the new tick
			    	var new_tick = parseInt(vars.current_tick-1);
						if( new_tick < 0 ) {
							new_tick = vars.tick_count-1;
						}
						if( settings.nav_reverse ) {
							if( settings.rotate_type == 'slide_left' ) {
								rotate_adjustment = 'slide_right';
							} else if( settings.rotate_type == 'slide_right' ) {
								rotate_adjustment = 'slide_left';
							} else if( settings.rotate_type == 'slide_down' ) {
								rotate_adjustment = 'slide_up';
							} else if( settings.rotate_type == 'slide_up' ) {
								rotate_adjustment = 'slide_down';
							}
							vars.reverse = 1;
						}
						mtphr_dnt_rotator_update( new_tick );	
		    	});
		    	
		    	$nav_next.bind('click', function(e) {
		    		e.preventDefault();

		    		if(vars.running) return false;
			    	
			    	// Find the new tick
			    	var new_tick = parseInt(vars.current_tick + 1);
						if( new_tick == vars.tick_count ) {
							new_tick = 0;
						}
						mtphr_dnt_rotator_update( new_tick );	
		    	});
		    }
		    
		    
		    
		    
		    /**
		     * Nav controls
		     *
		     * @since 1.0.2
		     */
		    if( $nav_controls && settings.type == 'rotate' ) {

			    $nav_controls.children('a').bind('click', function( e ) {
		    		e.preventDefault();
		    		
		    		// Find the new tick
			    	var new_tick = parseInt( $(this).attr('href') );
			    	
		    		if(vars.running) return false;
		    		if(new_tick == vars.current_tick) return false;
		    		
			    	var reverse = ( new_tick < vars.current_tick ) ? 1 : 0;
		    		
		    		if( settings.nav_reverse && reverse ) {
							if( settings.rotate_type == 'slide_left' ) {
								rotate_adjustment = 'slide_right';
							} else if( settings.rotate_type == 'slide_right' ) {
								rotate_adjustment = 'slide_left';
							} else if( settings.rotate_type == 'slide_down' ) {
								rotate_adjustment = 'slide_up';
							} else if( settings.rotate_type == 'slide_up' ) {
								rotate_adjustment = 'slide_down';
							}
							vars.reverse = 1;
						}
						mtphr_dnt_rotator_update( new_tick );	
		    	});
		    }



		    
		    /**
		     * Resize listener
		     * Reset the ticker width
		     *
		     * @since 1.0.9
		     */
		    $(window).resize( function() {
			    
			    // Resize the tickers if the width is different
			    if( $ticker.outerWidth() != ticker_width ) {
			    
				    ticker_width = $ticker.outerWidth();
				    
				    if( settings.type == 'scroll' ) {
				    	if( settings.scroll_direction=='up' || settings.scroll_direction=='down' ) {
				    		if( ticker_scroll_resize ) {
				    			mtphr_dnt_scroll_reset_ticks();
				    		} else {
					    		mtphr_dnt_scroll_resize_ticks();
				    		}
				    	} else {
					    	mtphr_dnt_scroll_resize_ticks();
				    	} 
				    } else if( settings.type == 'rotate' ) {
					    mtphr_dnt_rotator_resize_ticks();
				    }
			    }
		    });


		    
		    
		    // Trigger the afterLoad callback
        settings.after_load.call(this, $ticker);

			});
		}
	};
	




	/**
	 * Setup the class
	 *
	 * @since 1.0.0
	 */
	$.fn.ditty_news_ticker = function( method ) {
		
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call(arguments, 1) );
		} else if ( typeof method === 'object' || !method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist in ditty_news_ticker' );
		}
	};
		
})( jQuery );