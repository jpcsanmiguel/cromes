        <div class="tab-content default-tab" >
            <table>
                <thead>
                    <!-- disable pagination
                    <tr>
                        <td colspan="4">
                            <?=admin_pagination_create('admin_list', $current_page, $total_records, $records_per_page, $pager_adjacents, "/admin/admins/view" );?>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    -->
                    <tr>
                       <th>Full Name</th>
                       <th>Email</th>
                       <th>Role</th>
                       <th>Activated</th>
                       <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($admin_users) > 0){
                        foreach($admin_users as $au){
                            if($au->role_id_num == 1){
                                $role_name = "Administrator";
                            }elseif($au->role_id_num == 2){
                                $role_name = "Developer";
                            }elseif($au->role_id_num == 3){
                                $role_name = "Guest";
                            }
                            
                            $activated = ($au->is_activated_num ? "Yes" : "No");
                    ?>
                    <tr title='<?=$au->id?>' >
                        <td><?=$au->full_name_txt?></td>
                        <td><?=$au->email_txt?></td>
                        <td><?=$role_name?></td>
                        <td><?=$activated?></td>
                        <td>
                            <?php if($au->id == $this->nws_auth->get_s('id') || $this->nws_auth->user->role_id_num == 1){ ?>
                            <a onclick="editAdmin('<?=$au->id?>'); return false;" href="#" title="Edit"><img src="/storage/admin/images/icons/pencil.png" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a onclick="deleteAdmin('<?=$au->id?>'); return false;" href="#" title="Delete"><img src="/storage/admin/images/icons/cross.png" alt="Delete" /></a><br /><br />
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                        }
                    }else{
                    
                        echo "
                        <tr>
                            <td colspan='5' >No Admin Users found</td>
                        </tr>";
                    
                    }
                    ?>
                </tbody>
                <tfoot>
                    <!-- disable pagination
                    <tr>
                        <td colspan="4">
                            <?=admin_pagination_create('admin_list', $current_page, $total_records, $records_per_page, $pager_adjacents, "/admin/admins/view" );?>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    -->
                </tfoot>
            </table>
        </div>

<script type="text/javascript">
    //<![CDATA[
        $('tbody tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows
    //]]>
</script>