<div class="row">

    <div class="col-sm-12 col-content">

        <h1>Archive</h1>
        <?php if(!empty($data['comics'])):?>
        <table class="table archive-list">
          <tbody>
                <?php foreach($data['comics'] as $comic):?>
                    <tr>
                      <td class="col-xs-1">#<?php echo $comic['number'];?></td>
                      <td class="col-xs-3"><?php echo $comic['chapter_name'];?></td>
                      <td><a href="<?php echo $comicHelper->getComicLink($data, $comic);?>" title="<?php echo $comic['title'];?>"><?php echo $comic['title'];?></a></td>
                    </tr>
                <?php endforeach;?>
          </tbody>
        </table>
        <?php endif;?>

    </div>
</div>
