        <div class="tab-content default-tab" >
            <table>
                <thead>
                    <!-- disable pagination
                    <tr>
                        <td colspan="2">
                            <?=admin_pagination_create('user_list', $current_page, $total_records, $records_per_page, $pager_adjacents, "/admin/admins/view" );?>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    -->
                </thead>
                <tbody>
                    <?php
                    if(count($users) > 0){
                        foreach($users as $u){
                    ?>
                    <tr title='<?=$u->id?>' style="height:100px;">
                        <td>
                            <p>
                            <div style="float:left;">
                                <img src="<?=$u->sn_profile_picture?>" />
                            </div>
                            <div style="margin-left:70px;">
                                <strong>UserID:</strong> <?=$u->id?><br />
                                <strong>Name:</strong> <?=$u->first_name?> <?=$u->last_name?><br />
                                <strong>Username:</strong> <?=$u->username_txt?><br />
                                <strong>Class:</strong> <?=$u->class_txt?><br />
                            </div>
                            </p>
                        </td>
                        <td>
                            <a onclick="editUser('<?=$u->id?>'); return false;" href="#" title="Edit"><img src="/storage/admin/images/icons/pencil.png" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a onclick="deleteUser('<?=$u->id?>'); return false;" href="#" title="Delete"><img src="/storage/admin/images/icons/cross.png" alt="Delete" /></a><br /><br />
                        </td>
                    </tr>
                    <?php
                        }
                    }else{
                    
                        echo "
                        <tr>
                            <td colspan='3' >No Users found</td>
                        </tr>";
                    
                    }
                    ?>
                </tbody>
                <tfoot>
                    <!-- disable pagination
                    <tr>
                        <td colspan="2">
                            <?=admin_pagination_create('class_list', $current_page, $total_records, $records_per_page, $pager_adjacents, "/admin/admins/view" );?>
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