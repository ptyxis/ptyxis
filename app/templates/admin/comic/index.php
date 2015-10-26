
<!-- Modal -->
<div class="modal fade" id="delmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Comic Page</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this comic?
      </div>
      <div class="modal-footer">
        <form action="<?php echo $data['base_url'];?>comics/delete" method="post">
          <input type="hidden" name="id" id="delid" value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
      </form>
      </div>
    </div>
  </div>
</div>

<h1>Comics
    <a href="<?php echo $data['base_url'];?>comics/new" title="New">
        <span class="pull-right add-new fa fa-plus-circle fa-2x"></span>
    </a>
    <?php if(empty($data['comics'])):?>
    <span class="pull-right help-tip">Click to add a comic <span class="fa fa-arrow-right"></span></span>
    <?php endif;?>
</h1>
<?php if(!empty($data['comics'])):?>
<table class="table">
  <thead>
    <tr>
      <th>Number</th>
      <th>Title</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
        <?php foreach($data['comics'] as $comic):?>
            <tr>
              <td class="col-xs-1"><?php echo $comic['number'];?></td>
              <td>
                  <a href="<?php echo $data['base_url'];?>comics/edit/<?php echo $comic['id'];?>" title="Edit">
                      <?php echo $comic['title'];?>
                  </a>
              </td>
              <td class="col-xs-1">
                  <a href="<?php echo $data['base_url'];?>comics/edit/<?php echo $comic['id'];?>" title="Edit">
                      <span class="fa fa-pencil-square fa-2x"></span>
                  </a>
              </td>
              <td class="col-xs-1">
                  <a href="#" class="del" id="<?php echo $comic['id'];?>" title="Delete">
                      <span class="fa fa-trash fa-2x"></span>
                  </a>
              </td>
            </tr>
        <?php endforeach;?>
  </tbody>
</table>
<?php endif;?>
