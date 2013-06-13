<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
require_once('../../../../../../wp-load.php');
?>
<!doctype html>
<html lang="en">
	<head>
	<title>Insert Tabs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
	}
	function submitData() {				
		var shortcode;
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
		var contentTabsTitle   = $('#tab_title').val(),
			contentTabsContent = $('#tab_content').val(),
			contentTabsSingle  = $('#tab_single').is(':checked');	
		
		shortcode = ( !contentTabsSingle ? '[tabgroup] ' : '' );

		shortcode += '[tab';

		shortcode += ' title="' + contentTabsTitle + '"';

		shortcode += ']' + contentTabsContent + '[/tab]';

		if( !contentTabsSingle )
			shortcode += ' [/tabgroup]';
		
			
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcode);
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	
	
	</script>

	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="tabs" action="#" >
		<div class="tabs">
			<ul>
				<li id="tabs_tab" class="current"><span><a href="javascript:mcTabs.displayTab('tabs_tab','tabs_panel');" onMouseDown="return false;">Tabs</a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
			
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend>Type of tabs:</legend>
					<label for="tab_single">Single tab</label><br><span>(Remove wrapping shortcode)</span>
					<input type="checkbox" name="tab_single" id="tab_single" />		
                    
                    <br><br><br>

					<label for="tab_title">Tab title:</label><br><br>
                    <input type="text" name="tab_title" id="tab_title" style="width:250px" />	
                    
                	<br><br><br>

					<label for="tab_content">Tab content:</label><br><br>
                    <textarea name="tab_content" id="tab_content" cols="45" rows="5"></textarea>    
				
				</fieldset>	
		</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onClick="submitData();" />
			</div>
		</div>
	</form>
</body>
</html>