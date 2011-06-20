<h2>Manage Menus</h2>
<p>
    <div class="clear"></div>
    <div class="content-box column-left">    
        <div class="content-box-content">
            <div class="tab-content default-tab">
                <h4>Main Menus <a href="#" onclick="addMenu('main'); return false;" ><img src="/storage/admin/images/icons/tick_plus.png" /></a></h4>
                <p><div id='main_menus' ></div></p>
            </div> <!-- End #tab3 -->        
        </div> <!-- End .content-box-content -->
    </div>
    <div class="content-box column-right">
        <div class="content-box-content">
            <div class="tab-content default-tab" style="display: block;">
                <h4>Sub-menus <a href="#" onclick="addSubMenu(); return false;" ><img src="/storage/admin/images/icons/tick_plus.png" /></a></h4>
                <input type="hidden" id="sub_menu_parent_id" value="main" >
                <p>
                    <div id='sub_menus' >
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>ElemID</th>
                                <th>URL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan=4 >&laquo; Select Main Menu</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </p>
            </div> <!-- End #tab3 -->        
        </div> <!-- End .content-box-content -->
    </div>
    <div class="clear"></div>
</p>

<script type="text/javascript">
//<![CDATA[
    
    var renderMainMenus = function(){
        jQuery('#main_menus').html("Loading...");
            
        ajaxRequest({
            'url' : '/admin/menus/main_menus',
            'data' : {},
            'on_success' : function(data, status) {
                jQuery('#main_menus').html(data.html);
            },
            'on_error' : function(request, status, error_thrown) {
                jQuery('#main_menus').html("<div>Error loading page.</div>");              
            }
        });
    };
    
    var renderSubMenus = function(parent_id){
        
        $('#sub_menu_parent_id').val(parent_id);
        $('tbody tr').removeClass("alt-row");
        $('#'+parent_id).addClass("alt-row");
        
        jQuery('#sub_menus').html("Loading...");
            
        ajaxRequest({
            'url' : '/admin/menus/sub_menus',
            'data' : { 'parent_id': parent_id },
            'on_success' : function(data, status) {
                jQuery('#sub_menus').html(data.html);
            },
            'on_error' : function(request, status, error_thrown) {
                jQuery('#sub_menus').html("<div>Error loading page.</div>");              
            }
        });
    };
    
    setTimeout(function() {
        renderMainMenus();
    }, 0);
    
    var addMenu = function(parent_id){
        jQuery.facebox({ajax : base_url + "admin/menus/add?parent_id=" + parent_id});
    }
    
    var addSubMenu = function(){
        
        var parent_id = $('#sub_menu_parent_id').val();
        
        if(parent_id=='main'){
            alert('Select from Main Menu.');
            return false;
        }
    
        addMenu(parent_id);
    
    }
    
    var editMenu = function(id){
        jQuery.facebox({ajax : base_url + "admin/menus/edit?id=" + id});
    }
    
    var deleteMenu = function(id){
        jQuery.facebox({ajax : base_url + "admin/menus/delete?id=" + id});
    }
    
//]]>
</script>