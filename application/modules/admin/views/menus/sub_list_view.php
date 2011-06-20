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
        <?php
            if(count($menus) > 0){
                foreach($menus as $m){
        ?>
        <tr>
            <td><?=$m->title_txt?></td>
            <td><?=$m->elem_id?></td>
            <td><?=$m->url_txt?></td>
            <td>
                <a onclick="editMenu('<?=$m->id?>'); return false;" href="#" title="Edit"><img src="/storage/admin/images/icons/pencil.png" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a onclick="deleteMenu('<?=$m->id?>'); return false;" href="#" title="Delete"><img src="/storage/admin/images/icons/cross.png" alt="Delete" /></a><br /><br />
            </td>
        </tr>
        <?php
                }
            }else{
                echo "<tr><td colspan=4 >No Sub-Menus found</td></tr>";
            }
        ?>
    </tbody>
</table>
