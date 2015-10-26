<?php $formHelper->showErrors($data['errors']);?>
<h1>Theme options</h1>

<form action="<?php echo $data['base_url'];?>settings/theme" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="logo">Logo
        <span data-placement="right" data-toggle="tooltip" title="Logo must be in PNG format" class="fa fa-question-circle info-hover"></span>
        </label>
        <input type="file" name="logo" id="logo">
    </div>

    <div class="form-group">
        <label for="background">Background
        <span data-placement="right" data-toggle="tooltip" title="Comic background image must be JPG" class="fa fa-question-circle info-hover"></span>
        </label>
        <input type="file" name="background" id="background">
    </div>
    <input name="upload" type="submit" class="btn btn-default" value="Upload"/>
</form>
