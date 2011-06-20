<div id='settings_content_container'>
    <h2>Manage Administrators</h2>
    <p>
        <a href="#" onclick='addAdmin(); return false;' class="button" >Add New Administrator</a><br /><br />
    </p>
    <p>
    <div class="content-box"><!-- Start Content Box -->
        <div class="content-box-content">
            <div id="admin_list" ></div>
        </div>
    </div>
    </p>
</div>

<script type="text/javascript">
//<![CDATA[   
    
    var addAdmin = function(){
        jQuery.facebox({ajax : base_url + "admin/admins/add"});
    }
    
    var editAdmin = function(key){
        jQuery.facebox({ ajax: base_url + "admin/admins/edit?key=" + key});
    }
    
    var deleteAdmin = function(key){
        jQuery.facebox({ ajax: base_url + "/admin/admins/delete?key=" + key});
    }
    
    setTimeout(function() {
        admin_pagination('admin_list', '/admin/admins/view');
    }, 0);
    
//]]>
</script>