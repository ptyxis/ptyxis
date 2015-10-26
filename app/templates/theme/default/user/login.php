<div class="row">

    <div class="col-sm-8 col-sm-offset-2 col-content">

    <?php $formHelper->showErrors($data['errors']);?>

    <h1>Logon</h1>

    <form action="<?php echo $data['base_url'];?>user/login" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $formHelper->setValue('email');?>" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
      </div>
      <input type="submit" class="btn btn-default" value="Logon"/>
    </form>

    <br />

    <p>
        <a href="<?php echo $data['base_url'];?>user/forgotpassword" title="">Forgot Password</a>
    </p>

    </div>
</div>
