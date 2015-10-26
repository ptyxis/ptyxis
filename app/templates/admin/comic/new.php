<?php $formHelper->showErrors($data['errors']);?>
<h1>New Comic</h1>

<form action="<?php echo $data['base_url'];?>comics/new" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="comic_image">Image</label>
        <input type="file" name="comic_image" id="comic_image">
    </div>

    <?php if(!empty($data['chapters'])):?>
    <div class="form-group">
      <label for="title">Chapter</label>
      <select name="chapter_id" class="form-control">
          <option value="">None</option>
          <?php foreach($data['chapters'] as $chapter):?>
          <option value="<?php echo $chapter['id'];?>">
              <?php echo $chapter['name'];?>
          </option>
          <?php endforeach;?>
      </select>
    </div>
    <?php endif;?>

  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" id="comic-title" value="<?php echo $formHelper->setValue('title');?>" placeholder="Comic One">
  </div>

  <div class="form-group">
    <label for="slug">Slug
        <span data-placement="right" data-toggle="tooltip" title="Path used for SEO optimized urls" class="fa fa-question-circle info-hover"></span>
    </label>
    <input type="text" name="slug" class="form-control" id="comic-slug" value="<?php echo $formHelper->setValue('slug');?>" placeholder="comic-one">
  </div>

  <div class="form-group">
    <label for="number">Number
        <span data-placement="right" data-toggle="tooltip" title="This is the comic number and order number." class="fa fa-question-circle info-hover"></span>
    </label>
    <input type="text" name="number" class="form-control" id="number" value="<?php echo $formHelper->setValue('number',$data['number']);?>" placeholder="1">
  </div>

  <div class="form-group">
    <label for="date">Date
        <span data-placement="right" data-toggle="tooltip" title="Date to publish the comic" class="fa fa-question-circle info-hover"></span>
    </label>
    <input type="text" name="date" class="date-picker form-control" id="date" value="<?php echo $formHelper->setValue('date',date('m/d/Y'));?>" placeholder="mm/dd/yyyy">
  </div>

  <div class="form-group">
    <label for="comment">Comment</label>
    <textarea class="form-control content-editor" name="comment" rows="10" ><?php echo $formHelper->setValue('comment');?></textarea>
  </div>

  <input type="submit" class="btn btn-default" value="Add"/>
</form>
