<div class="row">

    <div class="col-sm-8 col-sm-offset-2 col-content">

    <?php $formHelper->showErrors($data['errors']);?>

    <h1>Forgot Password</h1>
    <p>
        Reset your password using the form below.
    </p>
    <form action="<?php echo $data['base_url'];?>user/forgotpassword" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $formHelper->setValue('email');?>" placeholder="Email">
      </div>
      <input type="submit" class="btn btn-default" value="Reset Password"/>
    </form>

    </div>
</div>
