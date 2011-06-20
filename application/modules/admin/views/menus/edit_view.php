<?php
    if($menu->parent_id=="main"){
        $title = "Edit Main Menu";
    }else{
        $title = "Edit Sub Menu";
    }
?>
    <div class="clear"></div> <!-- End .clear -->
    
    <div class="content-box">
        <div class="content-box-header"><h3><?=$title?></h3></div>
        <div class="content-box-content">
            <div id="error_msg" class="notification error png_bg" style="display:none;"></div>
            <div class="tab-content default-tab">
            <form>
                <fieldset>
                <p>
                    <label>Title:</label>
                    <input class="text-input medium-input" type="text" id="title" name="title" value="<?=$menu->title_txt?>" />
                </p>
                <p>
                    <label>URL:</label>
                    <input class="text-input medium-input" type="text" id="url" name="url" value="<?=$menu->url_txt?>" />
                </p>
                
                <p align="right">
                    <input class="button" type="button" onclick='doEditMenu(); return false;' value="Edit" />&nbsp;
                    <input class="button" type="button" onclick="jQuery(document).trigger('close.facebox')" value="Cancel" />
                </p>
                </fieldset>
            </form>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>

<script type="text/javascript">
//<![CDATA[   

    var doEditMenu = function() {
    
        var title = $.trim($('#title').val());
        var url = $.trim($('#url').val());
        
        var error = 0;
        var error_msg = '';
        
        if (title == '') {
            error_msg += 'Title is required.<br />';
            error++;
        }
        
        if (error > 0) {
            $('#error_msg').html("<div>" + error_msg + "</div>");
            $('#error_msg').show();
            return false;
        }else{
            $('#error_msg').hide();
        }
        
        ajaxRequest({
            'url': '/admin/menus/process_edit',
            'data': {
                'id': '<?=$menu->id?>',
                'title': title,
                'url': url
            },
            'on_success' : function(data, status) {
                if (data.status == 'ok') {
                    jQuery(document).trigger('close.facebox');
                    alert(data.msg);
                    renderMainMenus();
                } else {
                    $('#error_msg').html("<div>" + data.msg + "</div>");
                    $('#error_msg').show();
                }
            },
            'on_error' : function(request, status, error_thrown) {
                alert(error_thrown);
            }
        });
    }

//]]>
</script>
