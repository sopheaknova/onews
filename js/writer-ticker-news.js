function createTicker(){    	
	var tickerLIs = jQuery(".breaking-news ul").children();          
	tickerItems = new Array();                                
	tickerLIs.each(function(el) {                             
		tickerItems.push( jQuery(this).html() );                
	});                                                       
	i = 0  ;                                                 
	rotateTicker();                                           
}                                                           
function rotateTicker(){                                    
	if( i == tickerItems.length ){                            
	  i = 0;                                                  
	}                                                         
  tickerText = tickerItems[i];                              
	c = 0;                                                    
	typetext();                                               
	setTimeout( "rotateTicker()", 8000 );                     
	i++;                                                      
}                                                           
var isInTag = false;                                        
function typetext() {	                                      
	var thisChar = tickerText.substr(c, 1);                   
	if( thisChar == '<' ){ isInTag = true; }                  
	if( thisChar == '>' ){ isInTag = false; }                 
	jQuery('.breaking-news ul').html(tickerText.substr(0, c++));   
	if(c < tickerText.length+1)                                     
		if( isInTag ){                                                
			typetext();                                                 
		}else{                                                        
			setTimeout("typetext()", 28);                               
		}                                                             
	else {                                                          
		c = 1;                                                        
		tickerText = "";                                              
	}	                                                              
}

//innerfade
function removeFilter(a){if(a.style.removeAttribute){a.style.removeAttribute("filter")}}(function(a){a.fn.innerfade=function(b){return this.each(function(){a.innerfade(this,b)})};a.innerfade=function(b,c){var d={animationtype:"fade",speed:"normal",type:"sequence",timeout:2e3,containerheight:"auto",runningclass:"innerfade",children:null};if(c)a.extend(d,c);if(d.children===null)var e=a(b).children();else var e=a(b).children(d.children);if(e.length>1){a(b).css("position","relative").css("height",d.containerheight).addClass(d.runningclass);for(var f=0;f<e.length;f++){a(e[f]).css("z-index",String(e.length-f)).css("position","absolute").hide()}if(d.type=="sequence"){setTimeout(function(){a.innerfade.next(e,d,1,0)},d.timeout);a(e[0]).show()}else if(d.type=="random"){var g=Math.floor(Math.random()*e.length);setTimeout(function(){do{h=Math.floor(Math.random()*e.length)}while(g==h);a.innerfade.next(e,d,h,g)},d.timeout);a(e[g]).show()}else if(d.type=="random_start"){d.type="sequence";var h=Math.floor(Math.random()*e.length);setTimeout(function(){a.innerfade.next(e,d,(h+1)%e.length,h)},d.timeout);a(e[h]).show()}else{alert("Innerfade-Type must either be 'sequence', 'random' or 'random_start'")}}};a.innerfade.next=function(b,c,d,e){if(c.animationtype=="slide"){a(b[e]).slideUp(c.speed);a(b[d]).slideDown(c.speed)}else if(c.animationtype=="fade"){a(b[e]).fadeOut(c.speed);a(b[d]).fadeIn(c.speed,function(){removeFilter(a(this)[0])})}else alert("Innerfade-animationtype must either be 'slide' or 'fade'");if(c.type=="sequence"){if(d+1<b.length){d=d+1;e=d-1}else{d=0;e=b.length-1}}else if(c.type=="random"){e=d;while(d==e)d=Math.floor(Math.random()*b.length)}else alert("Innerfade-Type must either be 'sequence', 'random' or 'random_start'");setTimeout(function(){a.innerfade.next(b,c,d,e)},c.timeout)}})(jQuery);