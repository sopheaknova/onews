(function() {
    tinymce.create('tinymce.plugins.sp_buttons', {
		 
        init : function(ed, url){
            
			//Highlight
			ed.addButton('highlight', {
            title : 'Highlight text',
                onclick : function() {
					
                    ed.focus();
					ed.selection.setContent(' [highlight] ' + ed.selection.getContent() + ' [/highlight] ');
                   
                },
             image:  url +  "../../img/ed_highlight.png"
            });
			
			//Notifications
			ed.addCommand('notifications', function() {
				ed.windowManager.open({
					file : url +  '../../shortcodes/notifications.php'+sp_wpml_lang,
					width : 350,
					height : 330,
					inline : 1
				});
			
			});
			
			ed.addButton('notifications', {
            title : 'Insert Notification',
               cmd : 'notifications',
               image:  url +  "../../img/ed_notifications.png"
            });
			
			//Buttons
			ed.addCommand('buttons', function() {
				ed.windowManager.open({
					file : url +  '../../shortcodes/buttons.php'+sp_wpml_lang,
					width : 350,
					height : 560,
					inline : 1
				});
			
			});
						
			ed.addButton('buttons', {
            title : 'Insert Button',
               cmd : 'buttons',
               image:  url +  "../../img/ed_buttons.png"
            });
			
			//Separator line
			ed.addButton('divider', {
            title : 'Insert Separator line',
              image:  url +  "../../img/ed_divider.png",
			  onclick : function() {
                ed.selection.setContent("<hr>");
            }
            });
			
			//Toggles
			ed.addCommand('toggle', function() {
				ed.windowManager.open({
					file : url +  '../../shortcodes/toggle.php'+sp_wpml_lang,
					width : 350,
					height : 320,
					inline : 1
				});
			
			});
						
			ed.addButton('toggle', {
            title : 'Insert Toggle',
               cmd : 'toggle',
               image:  url +  "../../img/ed_toggle.png"
            });
			
			//Tabs
			ed.addCommand('tabs', function() {
				ed.windowManager.open({
					file : url +  '../../shortcodes/tabs.php'+sp_wpml_lang,
					width : 350,
					height : 380,
					inline : 1
				});
			
			});
			
			ed.addButton('tabs', {
            title : 'Insert Tabs',
                   cmd : 'tabs',
               image:  url +  "../../img/ed_tabs.png"
            });
			
			//Accordian
			ed.addCommand('accordian', function() {
				ed.windowManager.open({
					file : url +  '../../shortcodes/accordion.php'+sp_wpml_lang,
					width : 350,
					height : 320,
					inline : 1
				});
			
			});
						
			ed.addButton('accordian', {
            title : 'Insert Accordian',
               cmd : 'accordian',
               image:  url +  "../../img/ed_accordian.png"
            });
			
			//Dropcaps
			ed.addButton('dropcaps', {
            title : 'Dropcaps',
                onclick : function() {
					
                    ed.focus();
					ed.selection.setContent(' [dropcaps] 1 [/dropcaps] ');
                   
                },
             image:  url +  "../../img/ed_dropcaps.png"
            });
			
        },
		createControl:function(n, cm) {
			return null;
		},
		
		
		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
        getInfo : function() {
            return {
                longname : 'WP Editor Buttons',
                author : 'nova',
                authorurl : 'http://novacambodia.com',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }		
    });

    tinymce.PluginManager.add('sp_buttons', tinymce.plugins.sp_buttons);
})();