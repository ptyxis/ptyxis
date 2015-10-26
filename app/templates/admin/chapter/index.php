
<!-- Modal -->
<div class="modal fade" id="delmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Chapter</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this chapter?
      </div>
      <div class="modal-footer">
        <form action="<?php echo $data['base_url'];?>chapter/delete" method="post">
          <input type="hidden" name="id" id="delid" value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
      </form>
      </div>
    </div>
  </div>
</div>

<h1>Chapters
    <a href="<?php echo $data['base_url'];?>chapter/new" title="New">
        <span class="pull-right add-new fa fa-plus-circle fa-2x"></span>
    </a>
    <?php if(empty($data['chapters'])):?>
    <span class="pull-right help-tip">Click to add a chapter <span class="fa fa-arrow-right"></span></span>
    <?php endif;?>
</h1>
<?php if(!empty($data['chapters'])):?>
<table class="table">
  <thead>
    <tr>
      <th>Name</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
        <?php foreach($data['chapters'] as $chapter):?>
            <tr>
              <td><?php echo $chapter['name'];?></td>
              <td class="col-xs-1">
                  <a href="<?php echo $data['base_url'];?>chapter/edit/<?php echo $chapter['id'];?>" title="Edit">
                      <span class="fa fa-pencil-square fa-2x"></span>
                  </a>
              </td>
              <td class="col-xs-1">
                  <a href="#" class="del" id="<?php echo $chapter['id'];?>" title="Delete">
                      <span class="fa fa-trash fa-2x"></span>
                  </a>
              </td>
            </tr>
        <?php endforeach;?>
  </tbody>
</table>

<?php endif;?>
