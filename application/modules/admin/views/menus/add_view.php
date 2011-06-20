<?php
    if($parent_id=="main"){
        $title = "Add New Main Menu";
        $elem_id_val = "nav-";
    }else{
        $parent = $this->admin_nav_menu_model->get_nav_menu_by_id($parent_id);
        $elem_id_val = $parent->elem_id . "-";
        $title = "Add New Sub Menu";
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
                    <input class="text-input medium-input" type="text" id="title" name="title" value="" />
                </p>
                <p>
                    <label>ElemID:</label>
                    <input class="text-input medium-input" type="text" id="elem_id" name="elem_id" value="<?=$elem_id_val?>" />
                </p>
                <p>
                    <label>URL:</label>
                    <input class="text-input medium-input" type="text" id="url" name="url" value="" />
                </p>
                
                <p align="right">
                    <input class="button" type="button" onclick='doAddMenu(); return false;' value="Add" />&nbsp;
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

    var doAddMenu = function() {
    
        var title = $.trim($('#title').val());
        var elem_id = $.trim($('#elem_id').val());
        var url = $.trim($('#url').val());
        
        var error = 0;
        var error_msg = '';
        
        if (title == '') {
            error_msg += 'Title is required.<br />';
            error++;
        }
        
        if (elem_id == '') {
            error_msg += 'ElemID is required.<br />';
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
            'url': '/admin/menus/process_add',
            'data': {
                'title': title,
                'elem_id': elem_id,
                'url': url,
                'parent_id': '<?=$parent_id?>'
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
