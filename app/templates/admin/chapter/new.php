<?php $formHelper->showErrors($data['errors']);?>
<h1>New Chapter</h1>

<form action="<?php echo $data['base_url'];?>chapter/new" method="post">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" value="<?php echo $formHelper->setValue('name');?>" placeholder="Chapter One">
  </div>
  <input type="submit" class="btn btn-default" value="Add"/>
</form>
