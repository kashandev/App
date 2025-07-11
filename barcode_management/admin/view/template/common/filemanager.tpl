<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<script type="text/javascript" src="view/javascript/jquery/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.9.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.9.custom.css" />
<script type="text/javascript" src="view/javascript/jquery/ui/external/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jstree/jquery.tree.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
<style type="text/css">
    body {
        padding: 0;
        margin: 0;
        background: #F7F7F7;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
    }
    img {
        border: 0;
    }
    #container {
        padding: 0px 10px 7px 10px;
        height: 340px;
    }
    #menu {
        clear: both;
        height: 29px;
        margin-bottom: 3px;
    }
    #column-left {
        background: #FFF;
        border: 1px solid #CCC;
        float: left;
        width: 20%;
        height: 320px;
        overflow: auto;
    }
    #column-right {
        background: #FFF;
        border: 1px solid #CCC;
        float: right;
        width: 78%;
        height: 320px;
        overflow: auto;
        text-align: center;
    }
    #column-right div {
        text-align: left;
        padding: 5px;
    }
    #column-right a {
        display: inline-block;
        text-align: center;
        border: 1px solid #EEEEEE;
        cursor: pointer;
        margin: 5px;
        padding: 5px;
    }
    #column-right a.selected {
        border: 1px solid #7DA2CE;
        background: #EBF4FD;
    }
    #column-right input {
        display: none;
    }
    #dialog {
        display: none;
    }
    .button {
        display: block;
        float: left;
        padding: 8px 5px 8px 25px;
        margin-right: 5px;
        background-position: 5px 6px;
        background-repeat: no-repeat;
        cursor: pointer;
    }
    .button:hover {
        background-color: #EEEEEE;
    }
    .thumb {
        padding: 5px;
        width: 105px;
        height: 105px;
        background: #F7F7F7;
        border: 1px solid #CCCCCC;
        cursor: pointer;
        cursor: move;
        position: relative;
    }
</style>
</head>
<body>
    <div id="container">
        <div id="menu"><a id="create" class="button" style="background-image: url('view/image/filemanager/folder.png');"><?php echo $button_folder; ?></a><a id="delete" class="button" style="background-image: url('view/image/filemanager/edit-delete.png');"><?php echo $button_delete; ?></a><a id="move" class="button" style="background-image: url('view/image/filemanager/edit-cut.png');"><?php echo $button_move; ?></a><a id="copy" class="button" style="background-image: url('view/image/filemanager/edit-copy.png');"><?php echo $button_copy; ?></a><a id="rename" class="button" style="background-image: url('view/image/filemanager/edit-rename.png');"><?php echo $button_rename; ?></a><a id="upload" class="button" style="background-image: url('view/image/filemanager/upload.png');"><?php echo $button_upload; ?></a><a id="refresh" class="button" style="background-image: url('view/image/filemanager/refresh.png');"><?php echo $button_refresh; ?></a></div>
        <div id="column-left"></div>
        <div id="column-right"></div>
    </div>
    <script type="text/javascript"><!--
jQuery(document).ready(function () { 
	jQuery('#column-left').tree({
		data: { 
			type: 'json',
			async: true, 
			opts: { 
				method: 'POST', 
				url: 'index.php?route=common/filemanager/directory&token=<?php echo $token; ?>'
			} 
		},
		selected: 'top',
		ui: {		
			theme_name: 'classic',
			animation: 700
		},	
		types: { 
			'default': {
				clickable: true,
				creatable: false,
				renameable: false,
				deletable: false,
				draggable: false,
				max_children: -1,
				max_depth: -1,
				valid_children: 'all'
			}
		},
		callback: {
			beforedata: function(NODE, TREE_OBJ) { 
				if (NODE == false) {
					TREE_OBJ.settings.data.opts.static = [ 
						{
							data: 'image',
							attributes: { 
								'id': 'top',
								'directory': ''
							}, 
							state: 'closed'
						}
					];
					
					return { 'directory': '' } 
				} else {
					TREE_OBJ.settings.data.opts.static = false;  
					
					return { 'directory': jQuery(NODE).attr('directory') } 
				}
			},		
			onselect: function (NODE, TREE_OBJ) {
				$.ajax({
					url: 'index.php?route=common/filemanager/files&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'directory=' + encodeURIComponent(jQuery(NODE).attr('directory')),
					dataType: 'json',
					success: function(json) {
						html = '<div>';
						
						if (json) {
							for (i = 0; i < json.length; i++) {
								
								name = '';
								
								filename = json[i]['filename'];
								
								for (j = 0; j < filename.length; j = j + 15) {
									name += filename.substr(j, 15) + '<br />';
								}
								
								name += json[i]['size'];
								
								html += '<a file="' + json[i]['file'] + '"><img src="' + json[i]['thumb'] + '" title="' + json[i]['filename'] + '" /><br />' + name + '</a>';
							}
						}
						
						html += '</div>';
						
						jQuery('#column-right').html(html);
					}
				});
			}
		}
	});	
	
	jQuery('#column-right a').live('click', function () {
		if (jQuery(this).attr('class') == 'selected') {
			jQuery(this).removeAttr('class');
		} else {
			jQuery('#column-right a').removeAttr('class');
			
			jQuery(this).attr('class', 'selected');
		}
	});
	
	jQuery('#column-right a').live('dblclick', function () {
		<?php if ($fckeditor) { ?>
		window.opener.CKEDITOR.tools.callFunction(<?php echo $fckeditor; ?>, '<?php echo $directory; ?>' + jQuery(this).attr('file'));
		
		self.close();	
		<?php } else { ?>
		parent.jQuery('#<?php echo $field; ?>').attr('value', 'data/' + jQuery(this).attr('file'));
		parent.jQuery('#dialog').dialog('close');
		
		parent.jQuery('#dialog').remove();	
		<?php } ?>
	});		
						
	jQuery('#create').bind('click', function () {
		var tree = $.tree.focused();
		
		if (tree.selected) {
			jQuery('#dialog').remove();
			
			html  = '<div id="dialog">';
			html += '<?php echo $entry_folder; ?> <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
			html += '</div>';
			
			jQuery('#column-right').prepend(html);
			
			jQuery('#dialog').dialog({
				title: '<?php echo $button_folder; ?>',
				resizable: false
			});	
			
			jQuery('#dialog input[type=\'button\']').bind('click', function () {
				$.ajax({
					url: 'index.php?route=common/filemanager/create&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'directory=' + encodeURIComponent(jQuery(tree.selected).attr('directory')) + '&name=' + encodeURIComponent(jQuery('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} else {
							alert(json.error);
						}
					}
				});
			});
		} else {
			alert('<?php echo $error_directory; ?>');	
		}
	});
	
	jQuery('#delete').bind('click', function () {
		path = jQuery('#column-right a.selected').attr('file');
							 
		if (path) {
			$.ajax({
				url: 'index.php?route=common/filemanager/delete&token=<?php echo $token; ?>',
				type: 'POST',
				data: 'path=' + path,
				dataType: 'json',
				success: function(json) {
					if (json.success) {
						var tree = $.tree.focused();
					
						tree.select_branch(tree.selected);
						
						alert(json.success);
					}
					
					if (json.error) {
						alert(json.error);
					}
				}
			});				
		} else {
			var tree = $.tree.focused();
			
			if (tree.selected) {
				$.ajax({
					url: 'index.php?route=common/filemanager/delete&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'path=' + encodeURIComponent(jQuery(tree.selected).attr('directory')),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					}
				});			
			} else {
				alert('<?php echo $error_select; ?>');
			}			
		}
	});
	
	jQuery('#move').bind('click', function () {
		jQuery('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += '<?php echo $entry_move; ?> <select name="to"></select> <input type="button" value="Submit" />';
		html += '</div>';

		jQuery('#column-right').prepend(html);
		
		jQuery('#dialog').dialog({
			title: '<?php echo $button_move; ?>',
			resizable: false
		});

		jQuery('#dialog select[name=\'to\']').load('index.php?route=common/filemanager/folders&token=<?php echo $token; ?>');
		
		jQuery('#dialog input[type=\'button\']').bind('click', function () {
			path = jQuery('#column-right a.selected').attr('file');
							 
			if (path) {																
				$.ajax({
					url: 'index.php?route=common/filemanager/move&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'from=' + encodeURIComponent(path) + '&to=' + encodeURIComponent(jQuery('#dialog select[name=\'to\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
							
							var tree = $.tree.focused();
							
							tree.select_branch(tree.selected);
							
							alert(json.success);
						}
						
						if (json.error) {
							alert(json.error);
						}
					}
				});
			} else {
				var tree = $.tree.focused();
				
				$.ajax({
					url: 'index.php?route=common/filemanager/move&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'from=' + encodeURIComponent(jQuery(tree.selected).attr('directory')) + '&to=' + encodeURIComponent(jQuery('#dialog select[name=\'to\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
							
							tree.select_branch('#top');
								
							tree.refresh(tree.selected);
							
							alert(json.success);
						}						
						
						if (json.error) {
							alert(json.error);
						}
					}
				});				
			}
		});
	});

	jQuery('#copy').bind('click', function () {
		jQuery('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += '<?php echo $entry_copy; ?> <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
		html += '</div>';

		jQuery('#column-right').prepend(html);
		
		jQuery('#dialog').dialog({
			title: '<?php echo $button_copy; ?>',
			resizable: false
		});
		
		jQuery('#dialog select[name=\'to\']').load('index.php?route=common/filemanager/folders&token=<?php echo $token; ?>');
		
		jQuery('#dialog input[type=\'button\']').bind('click', function () {
			path = jQuery('#column-right a.selected').attr('file');
							 
			if (path) {																
				$.ajax({
					url: 'index.php?route=common/filemanager/copy&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent(jQuery('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
							
							var tree = $.tree.focused();
							
							tree.select_branch(tree.selected);
							
							alert(json.success);
						}						
						
						if (json.error) {
							alert(json.error);
						}
					}
				});
			} else {
				var tree = $.tree.focused();
				
				$.ajax({
					url: 'index.php?route=common/filemanager/copy&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'path=' + encodeURIComponent(jQuery(tree.selected).attr('directory')) + '&name=' + encodeURIComponent(jQuery('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
							
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 						
						
						if (json.error) {
							alert(json.error);
						}
					}
				});				
			}
		});	
	});
	
	jQuery('#rename').bind('click', function () {
		jQuery('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += '<?php echo $entry_rename; ?> <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
		html += '</div>';

		jQuery('#column-right').prepend(html);
		
		jQuery('#dialog').dialog({
			title: '<?php echo $button_rename; ?>',
			resizable: false
		});
		
		jQuery('#dialog input[type=\'button\']').bind('click', function () {
			path = jQuery('#column-right a.selected').attr('file');
							 
			if (path) {		
				$.ajax({
					url: 'index.php?route=common/filemanager/rename&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent(jQuery('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
							
							var tree = $.tree.focused();
					
							tree.select_branch(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					}
				});			
			} else {
				var tree = $.tree.focused();
				
				$.ajax({ 
					url: 'index.php?route=common/filemanager/rename&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'path=' + encodeURIComponent(jQuery(tree.selected).attr('directory')) + '&name=' + encodeURIComponent(jQuery('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							jQuery('#dialog').remove();
								
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					}
				});
			}
		});		
	});
	
	new AjaxUpload('#upload', {
		action: 'index.php?route=common/filemanager/upload&token=<?php echo $token; ?>',
		name: 'image',
		autoSubmit: false,
		responseType: 'json',
		onChange: function(file, extension) {
			var tree = $.tree.focused();
			
			if (tree.selected) {
				this.setData({'directory': jQuery(tree.selected).attr('directory')});
			} else {
				this.setData({'directory': ''});
			}
			
			this.submit();
		},
		onSubmit: function(file, extension) {
			jQuery('#upload').append('<img src="view/image/loading.gif" id="loading" style="padding-left: 5px;" />');
		},
		onComplete: function(file, json) {
			if (json.success) {
				var tree = $.tree.focused();
					
				tree.select_branch(tree.selected);
				
				alert(json.success);
			}
			
			if (json.error) {
				alert(json.error);
			}
			
			jQuery('#loading').remove();	
		}
	});
	
	jQuery('#refresh').bind('click', function () {
		var tree = $.tree.focused();
		
		tree.refresh(tree.selected);
	});	
});
//--></script>
</body>
</html>