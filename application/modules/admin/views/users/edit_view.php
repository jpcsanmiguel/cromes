<?php
    $disabled = "disabled";
    if($this->nws_auth->user->role_id_num == 1) $disabled = "";
?>
    <div class="clear"></div>
    
    <div class="content-box">
        <div class="content-box-header"><h3>Edit Class</h3></div>
        <div class="content-box-content">
            <div id="error_msg" class="notification error png_bg" style="display:none;"></div>
            <div class="tab-content default-tab">
            <form>
                <fieldset>
                <div style="width:600px" >
                    <div style="float:left;width:250px;">
                        <p>
                            <label>First Name:</label>
                            <input class="text-input medium-input" type="text" id="first_name" name="first_name" value="<?=$u->first_name?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Last Name:</label>
                            <input class="text-input medium-input" type="text" id="last_name" name="last_name" value="<?=$u->last_name?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>SN Profile Pic:</label>
                            <input class="text-input medium-input" type="text" id="sn_profile_picture" name="sn_profile_picture" value="<?=$u->sn_profile_picture?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Gender:</label>
                            <input class="text-input medium-input" type="text" id="gender_txt" name="gender_txt" value="<?=$u->gender_txt?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Email:</label>
                            <input class="text-input medium-input" type="text" id="email" name="email" value="<?=$u->email?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Birthday:</label>
                            <input class="text-input medium-input" type="text" id="birthday" name="birthday" value="<?=$u->birthdate_dt?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Location:</label>
                            <input class="text-input medium-input" type="text" id="location" name="location" value="<?=json_encode($u->location)?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Timezone:</label>
                            <input class="text-input medium-input" type="text" id="timezone_num" name="timezone_num" value="<?=$u->timezone_num?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Reffered By:</label>
                            <input class="text-input medium-input" type="text" id="referred_by" name="referred_by" value="<?=$u->referred_by?>" <?=$disabled?> />
                        </p>
                        <p>
                            <label>Level:</label>
                            <input class="text-input small-input" type="text" id="level_num" name="level_num" value="<?=$u->level_num?>" />
                        </p>
                        <p>
                            <label>Exp:</label>
                            <input class="text-input small-input" type="text" id="exp_num" name="exp_num" value="<?=$u->exp_num?>" />
                        </p>
                        <p>
                            <label>Max Exp:</label>
                            <input class="text-input small-input" type="text" id="exp_max_num" name="exp_max_num" value="<?=$u->exp_max_num?>" />
                        </p>
                    </div>
                    <div style="float:right;width:250px;margin-left:50px">
                        <p>
                            <label>Username:</label>
                            <input class="text-input medium-input" type="text" id="username_txt" name="username_txt" value="<?=$u->username_txt?>" />
                        </p>
                        <p>
                            <label>Class:</label>
                            <select class="medium-input" name="class_txt" id="class_txt">
                                <?php
                                    foreach($classes as $c){
                                        $selected="";
                                        if($c->code==$u->class_txt) $selected="selected";
                                ?>
                                <option value="<?=$c->code?>" <?=$selected?> ><?=$c->name?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </p>
                        <p>
                            <label>Bookmarked:</label>
                            <select class="small-input" name="is_bookmarked" id="is_bookmarked">
                                <option value="1" <?php echo ($u->is_bookmarked==1?"selected":""); ?>>Yes</option>
                                <option value="0" <?php echo ($u->is_bookmarked==0?"selected":""); ?>>No</option>
                            </select>
                        </p>
                        <p>
                            <label>Fan:</label>
                            <select class="small-input" name="is_fan" id="is_fan">
                                <option value="1" <?php echo ($u->is_fan==1?"selected":""); ?>>Yes</option>
                                <option value="0" <?php echo ($u->is_fan==0?"selected":""); ?>>No</option>
                            </select>
                        </p>
                        <p>
                            <label>Chat Banned:</label>
                            <select class="small-input" name="is_chat_banned" id="is_chat_banned">
                                <option value="1" <?php echo ($u->is_chat_banned==1?"selected":""); ?>>Yes</option>
                                <option value="0" <?php echo ($u->is_chat_banned==0?"selected":""); ?>>No</option>
                            </select>
                        </p>
                        <p>
                            <label>Active:</label>
                            <select class="small-input" name="is_active" id="is_active">
                                <option value="1" <?php echo ($u->is_active==1?"selected":""); ?>>Yes</option>
                                <option value="0" <?php echo ($u->is_active==0?"selected":""); ?>>No</option>
                            </select>
                        </p>
                        <p>
                            <label>AP:</label>
                            <input class="text-input small-input" type="text" id="ap_num" name="ap_num" value="<?=$u->ap_num?>" />
                        </p>
                        <p>
                            <label>Max AP:</label>
                            <input class="text-input small-input" type="text" id="ap_max_num" name="ap_max_num" value="<?=$u->ap_max_num?>" />
                        </p>
                        <p>
                            <label>Cash:</label>
                            <input class="text-input small-input" type="text" id="cash_num" name="cash_num" value="<?=$u->cash_num?>" />
                        </p>
                        <p>
                            <label>Credits:</label>
                            <input class="text-input small-input" type="text" id="credits_num" name="credits_num" value="<?=$u->credits_num?>" />
                        </p>
                    </div>
                </div>
                <div class="clear"></div>
                <div>
                    <p align="right">
                        <input class="button" type="button" onclick="doEditClass(); return false;" value="Edit" />&nbsp;
                        <input class="button" type="button" onclick="jQuery(document).trigger('close.facebox')" value="Cancel" />
                    </p>
                </div>
                </fieldset>
            </form>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>

<script type="text/javascript">
//<![CDATA[   

    var doEditClass = function() {
        
        var role_id = <?=$this->nws_auth->user->role_id_num?>;
    
        var first_name = $.trim($('#first_name').val());
        var last_name = $.trim($('#last_name').val());
        var gender_txt = $.trim($('#gender_txt').val());
        var email = $.trim($('#email').val());
        var birthday = $.trim($('#birthday').val());
        var location = $.trim($('#location').val());
        var timezone_num = $.trim($('#timezone_num').val());
        var referred_by = $.trim($('#referred_by').val());
        var sn_profile_picture = $.trim($('#sn_profile_picture').val());
        
        var level_num = parseInt($('#level_num').val());
        var exp_num = parseInt($('#exp_num').val());
        var exp_max_num = parseInt($('#exp_max_num').val());
        var username_txt = $.trim($('#username_txt').val());
        var class_txt = $.trim($('#class_txt').val());
        var is_bookmarked = parseInt($('#is_bookmarked').val());
        var is_fan = parseInt($('#is_fan').val());
        var is_chat_banned = parseInt($('#is_chat_banned').val());
        var is_active = parseInt($('#is_active').val());
        var ap_num = parseInt($('#ap_num').val());
        var ap_max_num = parseInt($('#ap_max_num').val());
        var cash_num = parseInt($('#cash_num').val());
        var credits_num = parseInt($('#credits_num').val());
        
        var error = 0;
        var error_msg = '';
        
        if(role_id == 1){ // admin allowed fields
            if (first_name == '') {
                error_msg += 'First Name is required.<br />';
                error++;
            }
            if (last_name == '') {
                error_msg += 'Last Name is required.<br />';
                error++;
            }
            if (gender_txt == '') {
                error_msg += 'Gender is required.<br />';
                error++;
            }
            if (email == '') {
                error_msg += 'Email is required.<br />';
                error++;
            }else if(!isValidEmail(email)){
                error_msg += 'Invalid Email format.<br />';
                error++;
            }
            if (birthday == '') {
                error_msg += 'Birthday is required.<br />';
                error++;
            }
            if (timezone_num == '') {
                error_msg += 'Timezone is required.<br />';
                error++;
            }
        
        }
        
        if (username_txt == '') {
            error_msg += 'Username is required.<br />';
            error++;
        }
        
        if (class_txt == '') {
            error_msg += 'Class is required.<br />';
            error++;
        }
        
        if (error > 0) {
            $('#error_msg').html("<div>" + error_msg + "</div>");
            $('#error_msg').show();
            return false;
        }else{
            $('#error_msg').hide();
        }
        
        ajaxRequest({
            'url': '/admin/users/process_edit',
            'data': {
                'id': '<?=$u->id?>',
                'first_name': first_name,
                'last_name': last_name,
                'gender_txt': gender_txt,
                'email': email,
                'birthday': birthday,
                'location': location,
                'timezone_num': timezone_num,
                'referred_by': referred_by,
                'sn_profile_picture': sn_profile_picture,
                
                'level_num': level_num,
                'exp_num': exp_num,
                'exp_max_num': exp_max_num,
                'username_txt': username_txt,
                'class_txt': class_txt,
                'is_bookmarked': is_bookmarked,
                'is_fan': is_fan,
                'is_chat_banned': is_chat_banned,
                'is_active': is_active,
                'ap_num': ap_num,
                'ap_max_num': ap_max_num,
                'cash_num': cash_num,
                'credits_num': credits_num
            },
            'on_success' : function(data, status) {
                if (data.status == 'ok') {
                    jQuery(document).trigger('close.facebox');
                    alert(data.msg);
                    admin_pagination('user_list', '/admin/users/view');
                } else {
                    $('#error_msg').html("<div>" + error_msg + "</div>");
                    $('#error_msg').show();
                }
            },
            'on_error' : function(request, status, error_thrown) {
                alert(error_thrown);
            }
        });
    }

//]]>
</script>
