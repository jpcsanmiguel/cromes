        <div class="tab-content default-tab" >
            <table>
                <thead>
                    <!-- disable pagination
                    <tr>
                        <td colspan="4">
                            <?=admin_pagination_create('class_list', $current_page, $total_records, $records_per_page, $pager_adjacents, "/admin/admins/view" );?>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    -->
                    <tr>
                       <th>Code</th>
                       <th>Name</th>
                       <th>Description</th>
                       <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($classes) > 0){
                        foreach($classes as $c){
                    ?>
                    <tr title='<?=$c->id?>' >
                        <td><?=$c->code?></td>
                        <td><?=$c->name?></td>
                        <td><p><?=$c->description?></p></td>
                        <td>
                            <a onclick="editClass('<?=$c->id?>'); return false;" href="#" title="Edit"><img src="/storage/admin/images/icons/pencil.png" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a onclick="deleteClass('<?=$c->id?>'); return false;" href="#" title="Delete"><img src="/storage/admin/images/icons/cross.png" alt="Delete" /></a><br /><br />
                        </td>
                    </tr>
                    <?php
                        }
                    }else{
                    
                        echo "
                        <tr>
                            <td colspan='5' >No Class found</td>
                        </tr>";
                    
                    }
                    ?>
                </tbody>
                <tfoot>
                    <!-- disable pagination
                    <tr>
                        <td colspan="4">
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