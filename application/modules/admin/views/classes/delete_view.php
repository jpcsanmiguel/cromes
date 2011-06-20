    <div class="clear"></div> <!-- End .clear -->
    
    <div class="notification attention png_bg">
        <div>
            Are you sure you want to delete Class <?=$c->name?> (<?=$c->code?>)?
        </div>
    </div>
    <p align="right">
        <input type="hidden" id="id" name="id" value="<?=$c->id?>" />
        <input class="button" type="button" onclick='doDeleteClass(); return false;' value="Delete" />&nbsp;
        <input class="button" type="button" onclick="jQuery(document).trigger('close.facebox')" value="Cancel" />
    </p>

    <div class="clear"></div>

<script type="text/javascript">
//<![CDATA[   

    var doDeleteClass = function() {
    
        var id = $.trim($('#id').val()); // hidden input
        
        var error = 0;
        
        ajaxRequest({
            'url': '/admin/classes/process_delete',
            'data': {
                'id': id
            },
            'on_success' : function(data, status) {
                if (data.status == 'ok') {
                    jQuery(document).trigger('close.facebox');
                    alert(data.msg);
                    admin_pagination('class_list', '/admin/classes/view');
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
