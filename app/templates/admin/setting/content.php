<?php $formHelper->showErrors($data['errors']);?>
<h1>Content</h1>
<form action="<?php echo $data['base_url'];?>settings/content" method="post">

  <div class="form-group">
    <label for="comic_content_left">Comic Content Left</label>
    <textarea class="form-control" name="comic_content_left" rows="3" ><?php echo $formHelper->setValue('comic_content_left', $data['settings']['comic_content_left']);?></textarea>
  </div>

  <div class="form-group">
    <label for="comic_content_right">Comic Content Right</label>
    <textarea class="form-control" name="comic_content_right" rows="3" ><?php echo $formHelper->setValue('comic_content_right', $data['settings']['comic_content_right']);?></textarea>
  </div>

  <div class="form-group">
    <label for="comic_content_top">Comic Content Top</label>
    <textarea class="form-control" name="comic_content_top" rows="3" ><?php echo $formHelper->setValue('comic_content_top', $data['settings']['comic_content_top']);?></textarea>
  </div>

  <div class="form-group">
    <label for="comic_content_bottom">Comic Content Bottom</label>
    <textarea class="form-control" name="comic_content_bottom" rows="3" ><?php echo $formHelper->setValue('comic_content_bottom', $data['settings']['comic_content_bottom']);?></textarea>
  </div>

  <input name="upload" type="submit" class="btn btn-default" value="Save"/>
</form>
