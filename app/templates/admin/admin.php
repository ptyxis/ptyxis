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
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Ptyxis Comic</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $data['base_url'];?>app/templates/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $data['base_url'];?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $data['base_url'];?>css/bootstrap-datepicker3.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo $data['base_url'];?>app/templates/admin/css/style.css" rel="stylesheet">

  </head>

  <body>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="<?php echo $data['base_url'];?>dashboard" title="Dashboard"><span class="fa fa-home fa-2x"></span></a></li>
            <li role="presentation" class="active"><a href="<?php echo $data['base_url'];?>user/logout" title="Logout"><span class="fa fa-power-off fa-2x"></span></a></li>
          </ul>
        </nav>
        <h3 class="text-muted"><img src="<?php echo $data['base_url'];?>app/templates/admin/images/logo.png" alt="Ptyxis" /></h3>
      </div>

      <?php if (!empty( $data['flash_message'])):?>

      <div class="alert alert-<?php echo $data['flash_type'];?>" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $data['flash_message'];?>
      </div>

      <?php endif;?>

      <?php include($template.'.php');?>

      <br />

      <footer class="footer">
        <p>&copy; <?php echo date('Y');?> ptyxis.cthonic.com  db-ver: <?php echo $data['comic_settings']['version'];?> </p>
      </footer>

    </div> <!-- /container -->

    <script src="<?php echo $data['base_url'];?>js/jquery.min.js"></script>
    <script src="<?php echo $data['base_url'];?>js/bootstrap.min.js"></script>
    <script src="<?php echo $data['base_url'];?>js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo $data['base_url'];?>js/tinymce/tinymce.min.js"></script>
    <script src="<?php echo $data['base_url'];?>app/templates/admin/js/util.js"></script>
  </body>
</html>
