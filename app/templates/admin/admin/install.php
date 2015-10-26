<?php if(empty($data['install_success'])): ?>

<img src="<?php echo $data['base_url'];?>app/templates/admin/images/logo.png" alt="Ptyxis" />
<h1>Ptyxis Comic CMS Install</h1>
<?php $formHelper->showErrors($data['errors']);?>
<p>
    To install Ptyxis, answer the questions below.
</p>
<form action="" method="post">
<legend>Database Details</legend>

  <div class="form-group">
    <label for="db_hostname">Hostname</label>
    <input type="text" name="db_hostname" class="form-control" id="db_hostname" value="<?php echo $formHelper->setValue('db_hostname');?>" placeholder="localhost">
  </div>

  <div class="form-group">
    <label for="db_username">Username</label>
    <input type="text" name="db_username" class="form-control" id="db_username" value="<?php echo $formHelper->setValue('db_username');?>" placeholder="username">
  </div>

  <div class="form-group">
    <label for="db_password">Password</label>
    <input type="text" name="db_password" class="form-control" id="db_password" value="<?php echo $formHelper->setValue('db_password');?>" placeholder="password">
  </div>

  <div class="form-group">
    <label for="db_database">Database</label>
    <input type="text" name="db_database" class="form-control" id="db_database" value="<?php echo $formHelper->setValue('db_database');?>" placeholder="database">
  </div>

<legend>User Account</legend>

  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" name="email" class="form-control" id="email" value="<?php echo $formHelper->setValue('email');?>" placeholder="someone@example.com">
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="password" value="<?php echo $formHelper->setValue('password');?>">
  </div>

  <div class="form-group">
    <label for="passwordconf">Re-enter Password</label>
    <input type="password" name="passwordconf" class="form-control" id="passwordconf" value="<?php echo $formHelper->setValue('passwordconf');?>">
  </div>

  <input type="submit" class="btn btn-default" value="Install"/>

</form>

<?php else:?>
    <img src="<?php echo $data['base_url'];?>app/templates/admin/images/logo.png" alt="Ptyxis" />
    <h1>Ptyxis Comics Installed Successfully</h1>
    <?php if(!empty($data['configContents'])):?>
        <p>
            Unfortunately Ptyxis couldn't write your config file. Please create app/config/config.php with the following contents.
        </p>
        <pre><?php echo htmlentities($data['configContents']);?></pre>
    <p>Then you can <a href="<?php echo $data['base_url'];?>user/login" title="login">login</a>.</p>
    <?php else:?>
    <p>You can now <a href="<?php echo $data['base_url'];?>user/login" title="login">login</a>.</p>
    <?php endif;?>
<?php endif;?>
