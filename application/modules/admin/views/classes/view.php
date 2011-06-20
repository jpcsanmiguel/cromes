<div id='settings_content_container'>
    <h2>Manage Classes</h2>
    <p>
        <a href="#" onclick='addClass(); return false;' class="button" >Add New Class</a><br /><br />
    </p>
    <p>
    <div class="content-box"><!-- Start Content Box -->
        <div class="content-box-content">
            <div id="class_list" ></div>
        </div>
    </div>
    </p>
</div>

<script type="text/javascript">
//<![CDATA[   
    
    var addClass = function(){
        jQuery.facebox({ajax : base_url + "admin/classes/add"});
    }
    
    var editClass = function(key){
        jQuery.facebox({ ajax: base_url + "admin/classes/edit?key=" + key});
    }
    
    var deleteClass = function(key){
        jQuery.facebox({ ajax: base_url + "/admin/classes/delete?key=" + key});
    }
    
    setTimeout(function() {
        admin_pagination('class_list', '/admin/classes/view');
    }, 0);
    
//]]>
</script>