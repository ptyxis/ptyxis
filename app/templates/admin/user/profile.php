<?php $formHelper->showErrors($data['errors']);?>

<h1>Profile</h1>

<form action="<?php echo $data['base_url'];?>user/profile" method="post">
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" id="email" value="<?php echo $formHelper->setValue('email', $data['user']['email']);?>" placeholder="Email">
  </div>
  <input type="submit" class="btn btn-default" value="Save"/>
</form>

<h2>Change Password</h2>
<form action="<?php echo $data['base_url'];?>user/changepassword" method="post">
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="passwordconf">Confirm Password</label>
    <input type="password" name="passwordconf" class="form-control" id="password" placeholder="Password">
  </div>
  <input type="submit" class="btn btn-default" value="Save"/>
</form>
