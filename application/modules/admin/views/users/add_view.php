    <div class="clear"></div> <!-- End .clear -->
    
    <div class="content-box">
        <div class="content-box-header"><h3>Add New Class</h3></div>
        <div class="content-box-content">
            <div id="error_msg" class="notification error png_bg" style="display:none;"></div>
            <div class="tab-content default-tab">
            <form>
                <fieldset>
                <div style="width:700px" >
                    <div style="float:left;width:300px;">
                        <p>
                            <label>Code:</label>
                            <input class="text-input medium-input" type="text" id="code" name="code" value="" />
                        </p>
                        <p>
                            <label>Name:</label>
                            <input class="text-input medium-input" type="text" id="name" name="name" value="" />
                        </p>
                    </div>
                    <div style="float:right;width:300px;margin-left:50px">
                        <p>
                            <label>Description:</label>
                            <textarea id="description" name="description" cols="79" rows="15"></textarea>
                        </p>
                        <p align="right">
                            <input class="button" type="button" onclick='doAddClass(); return false;' value="Add" />&nbsp;
                            <input class="button" type="button" onclick="jQuery(document).trigger('close.facebox')" value="Cancel" />
                        </p>
                    <div>
                </div>
                </fieldset>
            </form>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>

<script type="text/javascript">
//<![CDATA[   

    var doAddClass = function() {
    
        var code = $.trim($('#code').val());
        var name = $.trim($('#name').val());
        var description = $.trim($('#description').val());
        
        var error = 0;
        var error_msg = '';
        
        if (code == '') {
            error_msg += 'Code is required.<br />';
            error++;
        }
        
        if (name == '') {
            error_msg += 'Name is required.<br />';
            error++;
        }
        
        if (description == '') {
            error_msg += 'Description is required.<br />';
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
            'url': '/admin/classes/process_add',
            'data': {
                'code': code,
                'name': name,
                'description': description
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
