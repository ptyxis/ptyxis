
<?php if(!empty($data['comic_settings']['comic_content_top'])):?>
    <div class="col-xs-12 comic-col-top">
        <?php echo $data['comic_settings']['comic_content_top'];?>
    </div>
<?php endif;?>

<div class="row">

    <div class="col-xs-10 col-xs-offset-1 comic-nav">

        <div class="col-xs-2 comic-nav-control">
            <a href="<?php echo $comicHelper->getComicLink($data, $data['first_comic']);?>" title="First">
                <span class="fa fa-angle-double-left fa-3x"></span>
            </a>
        </div>
        <div class="col-xs-2 comic-nav-control">
            <a href="<?php echo $comicHelper->getComicLink($data, $data['prev_comic']);?>" title="Previous">
                <span class="fa fa-angle-left fa-3x"></span>
            </a>
        </div>
        <div class="col-xs-4 comic-nav-control archive">
            <a href="<?php echo $data['base_url'];?>archive" title="Archive">
                Archive
            </a>
        </div>
        <div class="col-xs-2 comic-nav-control">
            <a href="<?php echo $comicHelper->getComicLink($data, $data['next_comic']);?>" title="Next">
                <span class="fa fa-angle-right fa-3x"></span>
            </a>
        </div>
        <div class="col-xs-2 comic-nav-control">
            <a href="<?php echo $comicHelper->getComicLink($data, $data['latest_comic']);?>" title="Latest">
                <span class="fa fa-angle-double-right fa-3x"></span>
            </a>
        </div>

    </div>

</div>


<div class="col-sm-12 comic-holder">
    <?php $comicImage = $comicHelper->getComicImage($data['comic']['id']);?>
    <?php if(!empty($comicImage)):?>
        <a href="<?php echo $comicHelper->getComicLink($data, $data['next_comic']);?>">
            <img class="img-responsive" src="<?php echo $data['base_url'];?><?php echo $comicImage;?>" alt="<?php echo $data['comic']['title'];?>"/>
        </a>
    <?php endif;?>

    <div class="col-xs-12 text-center social-share">
        <?php if(!empty($data['comic'])):?>
        <div class="col-xs-8 col-xs-offset-2">
          <a href="http://www.facebook.com/sharer.php?u=<?php echo $comicHelper->getComicLink($data, $data['comic']);?>&t=<?php echo $data['comic']['title'];?>" title="Share">
            <span class="fa fa-facebook fa-lg"></span>
          </a>
          <a href="http://twitter.com/share?url=<?php echo $comicHelper->getComicLink($data, $data['comic']);?>&text=<?php echo $data['comic']['title'];?>" title="Share">
            <span class="fa fa-twitter fa-lg"></span>
          </a>
        </div>
        <div class="clearfix"></div>
        <?php endif;?>
    </div>

</div>


<?php if(!empty($data['comic_settings']['comic_content_bottom'])):?>
    <div class="col-xs-12 comic-col-bottom">
        <?php echo $data['comic_settings']['comic_content_bottom'];?>
    </div>
<?php endif;?>

<div class="clearfix"></div>

<div class="col-sm-12 comic-details">
<div class="row">

    <?php $cols = $comicHelper->getContentColSizes($data);?>
    <?php if(!empty($cols['left'])):?>
    <div class="col-sm-<?php echo $cols['left'];?> comic-col-left">
        <div class="comic-detail-holder">
            <?php echo $data['comic_settings']['comic_content_left'];?>
        </div>
    </div>
    <?php endif;?>

    <div class="col-sm-<?php echo $cols['center'];?> comic-col-center">
    <?php if(!empty($data['comic'])):?>
        <h1><?php echo $data['comic']['title'];?> #<?php echo $data['comic']['number'];?>
            <a href="<?php echo $data['base_url'];?>comics/edit/<?php echo $comic['id'];?>" title="Edit">
                <span class="fa fa-pencil-square"></span>
            </a>
        </h1>
        <p><?php echo date('m/d/Y', strtotime($data['comic']['date']));?> </p>
        <p><?php echo $data['comic']['comment'];?> </p>

        <br />

        <?php if(!empty($data['comic_settings']['comment_code'])):?>
            <?php echo $data['comic_settings']['comment_code'];?>
        <?php endif;?>

    <?php endif;?>
    </div>

    <?php if(!empty($cols['right'])):?>
    <div class="col-sm-<?php echo $cols['right'];?> comic-col-right">
        <div class="comic-detail-holder">
            <?php echo $data['comic_settings']['comic_content_right'];?>
        </div>
    </div>
    <?php endif;?>
</div>

</div>

<div class="clearfix"></div>
