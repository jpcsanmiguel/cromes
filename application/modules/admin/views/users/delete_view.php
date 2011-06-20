    <div class="clear"></div> <!-- End .clear -->
    
    <div class="notification attention png_bg">
        <div>
            Are you sure you want to delete <?=$u->first_name?> <?=$u->last_name?> (<?=$u->username_txt?>)?
        </div>
    </div>
    <p align="right">
        <input type="hidden" id="id" name="id" value="<?=$u->id?>" />
        <input class="button" type="button" onclick='doDeleteUser(); return false;' value="Delete" />&nbsp;
        <input class="button" type="button" onclick="jQuery(document).trigger('close.facebox')" value="Cancel" />
    </p>

    <div class="clear"></div>

<script type="text/javascript">
//<![CDATA[   

    var doDeleteUser = function() {
    
        var id = $.trim($('#id').val()); // hidden input
        
        var error = 0;
        
        ajaxRequest({
            'url': '/admin/users/process_delete',
            'data': {
                'id': id
            },
            'on_success' : function(data, status) {
                if (data.status == 'ok') {
                    jQuery(document).trigger('close.facebox');
                    alert(data.msg);
                    admin_pagination('user_list', '/admin/users/view');
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
