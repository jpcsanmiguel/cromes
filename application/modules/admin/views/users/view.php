<div id='settings_content_container'>
    <h2>Manage Users</h2>
    <p>
    <div class="content-box"><!-- Start Content Box -->
        <div class="content-box-content">
            <div id="user_list" ></div>
        </div>
    </div>
    </p>
</div>

<script type="text/javascript">
//<![CDATA[   
    
    var editUser = function(key){
        jQuery.facebox({ ajax: base_url + "admin/users/edit?key=" + key});
    }
    
    var deleteUser = function(key){
        jQuery.facebox({ ajax: base_url + "/admin/users/delete?key=" + key});
    }
    
    setTimeout(function() {
        admin_pagination('user_list', '/admin/users/view');
    }, 0);
    
//]]>
</script>