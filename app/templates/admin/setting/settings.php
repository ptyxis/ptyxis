<?php $formHelper->showErrors($data['errors']);?>
<h1>Settings</h1>
<form action="<?php echo $data['base_url'];?>settings" method="post">

  <div class="form-group">
    <label for="comic_title">Comic Title</label>
    <input type="text" name="comic_title" class="form-control" id="comic_title" value="<?php echo $formHelper->setValue('comic_title', $data['settings']['comic_title']);?>" placeholder="My webcomic">
  </div>

  <div class="form-group">
    <label for="comic_description">Comic Description</label>
    <textarea class="form-control" name="comic_description" rows="3" ><?php echo $formHelper->setValue('comic_description', $data['settings']['comic_description']);?></textarea>
  </div>

  <div class="form-group">
    <label for="creator_name">Creator Name</label>
    <input type="text" name="creator_name" class="form-control" id="creator_name" value="<?php echo $formHelper->setValue('creator_name', $data['settings']['creator_name']);?>" placeholder="John Smith">
  </div>

  <div class="form-group">
    <label for="creator_about">About the Creator</label>
    <textarea class="form-control content-editor" name="creator_about" rows="3" ><?php echo $formHelper->setValue('creator_about', $data['settings']['creator_about']);?></textarea>
  </div>

    <div class="form-group">
      <label for="seo_urls">SEO Urls
          <span data-placement="right" data-toggle="tooltip" title="Use SEO urls comic/comic-name instead of comic/id" class="fa fa-question-circle info-hover"></span>
      </label>
      <select name="seo_urls" class="form-control">
          <option value="1" <?php echo ($data['settings']['seo_urls'] ==  1 ? "selected" : "") ?>>Enabled</option>
          <option value="0" <?php echo ($data['settings']['seo_urls'] ==  0 ? "selected" : "") ?>>Disabled</option>
      </select>
    </div>

  <div class="form-group">
    <label for="google_analytics">Google Analytics
        <span data-placement="right" data-toggle="tooltip" title="Paste your Google Analytics or other website statistics service code here" class="fa fa-question-circle info-hover"></span>
    </label>
    <textarea class="form-control" name="google_analytics" rows="3" ><?php echo $formHelper->setValue('google_analytics', $data['settings']['google_analytics']);?></textarea>
  </div>

  <div class="form-group">
    <label for="comment_code">Comment Code
        <span data-placement="right" data-toggle="tooltip" title="Paste your comment code here, eg disqus" class="fa fa-question-circle info-hover"></span>
    </label>
    <textarea class="form-control" name="comment_code" rows="3" ><?php echo $formHelper->setValue('comment_code', $data['settings']['comment_code']);?></textarea>
  </div>

  <div class="form-group">
    <label for="twitter">Twitter</label>
    <input type="text" name="twitter" class="form-control" id="twitter" value="<?php echo $formHelper->setValue('twitter', $data['settings']['twitter']);?>" placeholder="https://twitter.com/mytwitter">
  </div>

  <div class="form-group">
    <label for="facebook">Facebook</label>
    <input type="text" name="facebook" class="form-control" id="facebook" value="<?php echo $formHelper->setValue('facebook', $data['settings']['facebook']);?>" placeholder="https://facebook.com/myfacebook">
  </div>

  <div class="form-group">
    <label for="theme">Comic Theme</label>
      <select name="theme" class="form-control">
          <?php foreach($themes as $theme):?>
              <option value="<?php echo $theme;?>" <?php echo ($data['settings']['theme'] ==  $theme ? "selected" : "") ?>><?php echo $theme;?></option>
          <?php endforeach;?>
      </select>
  </div>


  <input type="submit" class="btn btn-default" value="Save"/>
</form>
