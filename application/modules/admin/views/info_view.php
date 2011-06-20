<?php
    /*
        info_types
            attention
            information
            success
            error
    */
?>
<div class="clear"></div> <!-- End .clear -->
<div class="notification <?=$info_type?> png_bg">
    <div><?=$info_message?></div>
</div>
<p><a href="<?=$return_url?>" class="button" >Back</a></p>
<div class="clear"></div>