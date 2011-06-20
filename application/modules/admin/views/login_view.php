    <?= form_open('/admin/auth/login', array('id' => 'user-login', 'name' => 'user-login', 'method' => 'post')); ?>
				
<?php
      if (isset($result_message)) {

        echo "
        <div class='notification information png_bg'>
          <div>
            {$result_message}
          </div>
        </div>";

      }

?>
        
        <p>
            <label>Email</label>
            <input class="text-input" type="text" name="username"  id="username" />
        </p>
        <div class="clear"></div>
        <p>
            <label>Password</label>
            <input class="text-input" type="password" name="passwrd" id="passwrd" />
        </p>
        <div class="clear"></div>
        <p id="remember-password">
            <input type="checkbox"  id='remember-me' name='remember-me' />Remember me
        </p>
        <div class="clear"></div>
        <p>
            <input class="button" type="submit" value="Sign In" />
        </p>
        
    <?= form_close(); ?>


