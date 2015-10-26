<?php if ( empty($data['base_url'])) exit('No direct script access allowed');?>
<?php include('app/helpers/FormHelper.php');?>
<?php include('app/helpers/ComicHelper.php');?>
<?php $formHelper = new FormHelper();?>
<?php $comicHelper = new ComicHelper();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $data['meta']['description'];?>">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $data['meta']['title'];?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $data['base_url'];?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $data['base_url'];?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo $data['base_url'];?>app/templates/theme/<?php echo $data['comic_settings']['theme'];?>/css/style.css" rel="stylesheet">

  </head>

  <body>
    <div class="container container-content">

        <nav class="navbar navbar-default navbar-static-top">
              <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="<?php echo $data['base_url'];?>">
                      <?php if ($comicHelper->getLogo()):?>
                          <img src="<?php echo $data['base_url'];?><?php echo $comicHelper->getLogo();?>" class="img-responsive" alt="<?php echo $data['comic_settings']['comic_title'];?>"/>
                      <?php else:?>
                        <?php echo $data['comic_settings']['comic_title'];?>
                      <?php endif;?>

                  </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="<?php echo $data['base_url'];?>">Comic</a></li>
                      <li><a href="<?php echo $data['base_url'];?>about">About</a></li>
                      <?php if ($data['logged_in']):?>
                          <li><a href="<?php echo $data['base_url'];?>dashboard">Dash</a></li>
                      <?php else:?>
                          <li><a href="<?php echo $data['base_url'];?>user/login">Login</a></li>
                      <?php endif;?>
                      <?php if (!empty($data['comic_settings']['twitter'])):?>
                      <li>
                          <a href="<?php echo $data['comic_settings']['twitter'];?>" title="Twitter"><span class="fa fa-twitter fa-lg"></span></a>
                      </li>
                      <?php endif;?>
                      <?php if (!empty($data['comic_settings']['facebook'])):?>
                      <li>
                          <a href="<?php echo $data['comic_settings']['facebook'];?>" title="Facebook"><span class="fa fa-facebook fa-lg"></span></a>
                      </li>
                      <?php endif;?>
                      <li>
                          <a href="<?php echo $data['base_url'];?>feed" title="RSS"><span class="fa fa-rss fa-lg"></span></a>
                      </li>
                  </ul>

                </div><!--/.nav-collapse -->
              </div>
            </nav>

        <div class="container">
          <?php if (!empty($data['flash_message'])):?>

          <div class="alert alert-<?php echo $data['flash_type'];?>" role="alert">
            <?php echo $data['flash_message'];?>
          </div>

          <?php endif;?>

          <?php include($template.'.php');?>

          <footer class="footer">
            <p class="text-center">&copy; <?php echo date('Y');?> <?php echo $data['comic_settings']['creator_name'];?></p>
          </footer>

        </div>


    </div> <!-- /container -->

    <script src="<?php echo $data['base_url'];?>js/jquery.min.js"></script>
    <script src="<?php echo $data['base_url'];?>js/bootstrap.min.js"></script>
    <?php if (!empty($data['comic_settings']['google_analytics'])):?>
        <?php echo $data['comic_settings']['google_analytics'];?>\
    <?php endif;?>
  </body>
</html>
