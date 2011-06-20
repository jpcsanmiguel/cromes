    <div class="clear"></div> <!-- End .clear -->
    
    <div class="content-box">
        <div class="content-box-header"><h3>Add New Admin</h3></div>
        <div class="content-box-content">
            <div id="error_msg" class="notification error png_bg" style="display:none;"></div>
            <div class="tab-content default-tab">
            <form>
                <fieldset>
                <p>
                    <label>Full Name:</label>
                    <input class="text-input medium-input" type="text" id="full_name" name="full_name" value="" />
                </p>
                <p>
                    <label>Email:</label>
                    <input class="text-input medium-input" type="text" id="email" name="email" value="" />
                </p>
                <p>
                    <label>Role:</label>
                    <select class="medium-input" name="role_id" id="role_id">
                        <option value="1">Administrator</option>
                        <option value="2">Developer</option>
                        <option value="3">Guest</option>
                    </select>
                </p>
                <p>
                    <label>Password:</label>
                    <input class="text-input medium-input" type="password" id="pword1" name="pword1" value="" />
                </p>
                <p>
                    <label>Confirm Password:</label>
                    <input class="text-input medium-input" type="password" id="pword2" name="pword2" value="" />
                </p>
                <p>
                    <label>Activated:</label>
                    <select class="small-input" name="is_activated" id="is_activated">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </p>
                <p align="right">
                    <input class="button" type="button" onclick='doAddAdmin(); return false;' value="Add" />&nbsp;
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

    var doAddAdmin = function() {
    
        var full_name = $.trim($('#full_name').val());
        var email = $.trim($('#email').val());
        var pword1 = $.trim($('#pword1').val());
        var pword2 = $.trim($('#pword2').val());
        var role_id = $('#role_id').val();
        var is_activated = $('#is_activated').val();
        var password;
        
        var error = 0;
        var error_msg = '';
        
        if (full_name == '') {
            error_msg += 'Full Name is required.<br />';
            error++;
        }
        
        if (email == '') {
            error_msg += 'Email is required.<br />';
            error++;
        }else if(!isValidEmail(email)){
            error_msg += 'Invalid Email format.<br />';
            error++;
        }
        
        if (pword1 == '') {
            error_msg += 'Password is required.<br />';
            error++;
        }
        
        if (pword2 == '') {
            error_msg += 'Confirmation Password is required.<br />';
            error++;
        }
        
        if(pword1 != pword2){
            error_msg += 'Invalid Confirmation Password.<br />';
            error++;
        }
        
        if (error > 0) {
            $('#error_msg').html("<div>" + error_msg + "</div>");
            $('#error_msg').show();
            return false;
        }else{
            $('#error_msg').hide();
        }
        
        password = pword1;
        
        ajaxRequest({
            'url': '/admin/admins/process_add',
            'data': {
                'full_name': full_name,
                'email': email,
                'password': password,
                'role_id': role_id,
                'is_activated': is_activated
            },
            'on_success' : function(data, status) {
                if (data.status == 'ok') {
                    jQuery(document).trigger('close.facebox');
                    alert(data.msg);
                    admin_pagination('admin_list', '/admin/admins/view');
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
