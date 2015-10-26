<?php $formHelper->showErrors($data['errors']);?>
<h1>Edit Chapter</h1>

<form action="<?php echo $data['base_url'];?>chapter/edit" method="post">
  <input type="hidden" name="id" value="<?php echo $data['chapter']['id'];?>"/>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" value="<?php echo $formHelper->setValue('name', $data['chapter']['name']);?>" placeholder="Chapter One">
  </div>
  <input type="submit" class="btn btn-default" value="Save"/>
</form>
