    <div class="clear"></div> <!-- End .clear -->
    
    <div class="content-box">
        <div class="content-box-header"><h3>Edit Admin User</h3></div>
        <div class="content-box-content">
            <div id="error_msg" class="notification error png_bg" style="display:none;"></div>
            <div class="tab-content default-tab">
            <form>
                <fieldset>
                <p>
                    <label>Full Name:</label>
                    <input class="text-input medium-input" type="text" id="full_name" name="full_name" value="<?=$u->full_name_txt?>" />
                </p>
                <p>
                    <label>Role:</label>
                    <select class="medium-input" name="role_id" id="role_id">
                        <option value="1" <?php echo ($u->role_id_num == 1 ? "selected" : ""); ?>>Administrator</option>
                        <option value="2" <?php echo ($u->role_id_num == 2 ? "selected" : ""); ?>>Developer</option>
                        <option value="3" <?php echo ($u->role_id_num == 3 ? "selected" : ""); ?>>Guest</option>
                    </select>
                </p>
                <p>
                    <label>Activated:</label>
                    <select class="small-input" name="is_activated" id="is_activated">
                        <option value="0" <?php echo ($u->is_activated_num==0 ? "selected" : ""); ?> >No</option>
                        <option value="1" <?php echo ($u->is_activated_num==1 ? "selected" : ""); ?>>Yes</option>
                    </select>
                </p>
                <p align="right">
                    <input class="button" type="button" onclick="doEditAdmin(); return false;" value="Edit" />&nbsp;
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

    var doEditAdmin = function() {
    
        var full_name = $.trim($('#full_name').val());
        var role_id = $('#role_id').val();
        var is_activated = $('#is_activated').val();
        
        var error = 0;
        var error_msg = '';
        
        if (full_name == '') {
            error_msg += 'Full Name is required.<br />';
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
            'url': '/admin/admins/process_edit',
            'data': {
                'id': '<?=$u->id;?>',
                'full_name': full_name,
                'role_id': role_id,
                'is_activated': is_activated
            },
            'on_success' : function(data, status) {
                if (data.status == 'ok') {
                    jQuery(document).trigger('close.facebox');
                    alert(data.msg);
                    admin_pagination('admin_list', '/admin/admins/view');
                } else {
                    $('#error_msg').html("<div>" + error_msg + "</div>");
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
