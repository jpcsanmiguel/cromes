        <div id="sidebar">
            <div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
                <h1 id="sidebar-title"><a href="#">Jagged-Alliance</a></h1>
              
                <!-- Logo (221px wide) -->
                
                <a href="#">
                    <p><b>Jagged-Alliance</b></p>
                    <!-- <img id="logo" src="/storage/admin/images/logo.png" alt="Simple Admin logo" width='221' /> -->
                </a>
              
                <!-- Sidebar Profile links -->
                <div id="profile-links">
                    Hello, <a href="#" title="Edit your profile"><?= $this->nws_auth->user->full_name_txt; ?></a><br />
                    <br />
                    <a href="<?= $this->urls->fb_base_url; ?>" title="Goto the Game" target='_blank'>Goto the Game</a> | <a href="/admin/auth/logout" title="Sign Out">Sign Out</a>
                </div>        
                
                <ul id="main-nav">  
                    <li>
                        <a class="nav-top-item no-submenu" id="nav-dashboard" href="<?= $this->urls->base_url; ?>admin" style="padding-right: 15px;">Dashboard</a>
                    </li>
                <?php
                    $menus = $this->admin_nav_menu_model->get_nav_menus("parent_id:main");
                    
                    foreach($menus as $menu){
                        $sub_menus = $this->admin_nav_menu_model->get_nav_menus("parent_id:".$menu->id);
                        $url = "javascript://void(0);";
                        if(!empty($menu->url_txt)) $url = $menu->url_txt;
                        print "
                            <li>
                            ".anchor($url, $menu->title_txt, array( 'id' => $menu->elem_id, 'class' => 'nav-top-item no-submenu current'));
                        
                        if(count($sub_menus)) print "<ul>";
                        foreach($sub_menus as $sub_menu){
                            print "
                                    <li>
                                    ".anchor($sub_menu->url_txt, $sub_menu->title_txt, array( 'id' => $sub_menu->elem_id))."
                                    </li>";
                        }
                        if(count($sub_menus)) print "</ul>";
                        print "
                            </li>";
                    }
                ?>
                  </ul> <!-- End #main-nav -->
                
                
            </div>
        </div> <!-- End #sidebar -->
        
<script type="text/javascript">
//<![CDATA[

    // set selected menu
    var selected_nav = '<?= $this->selected_menu; ?>';
    var selected_sub_nav = '<?= $this->selected_sub_menu; ?>';

    // remove curent selected elements; this will traverse all instance top and sub nav
    $('#main-nav li a.current').removeClass('current');

    // assign new selected navs
    $('#' + selected_nav).addClass('current');
    $('#' + selected_sub_nav).addClass('current');


//]]>
</script>