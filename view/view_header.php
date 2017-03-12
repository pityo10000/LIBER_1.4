<!DOCTYPE html>
<html>
  <head>
    <title>
      <?php
        echo $title;
      ?>
    </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!--TODO Letöltött verziót használni!-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script><?php if (isset($script)) { echo $script; } ?></script>

    <style><?php if (isset($style)) { echo $style; } ?>

      body {
      	text-align: center;
      	background-color: #c0dce2;
      }

      #logo {
      	height: 150px;
        padding: 20px;
      }

      #headerPanel {
        background-color: #FFF;
      }

      .itemBox {
      	height: auto;
      }

      .menubtn {
      	height: 50px;
      }
    </style>

  </head>
  <body>
    <div id="sitePanel" class="panel panel-default">
    <div id="headerPanel" class="panel-heading">
      <a href='index.php?nav=mainPage'><img id='logo' src="img\logo.jpg"></a>
      </br>
    </div>
    <div id="bodyPanel" class="panel-body">

      <?php
      include 'view_menu.php';

      if (isset($_SESSION['alertType']) && isset($_SESSION['alertText'])) {
        echo '<div class="alert alert-' . $_SESSION['alertType'] . '">
          ' . $_SESSION['alertText'] . '
        </div>';
        $_SESSION['alertType'] = null;
        $_SESSION['alertText'] = null;
      }
       ?>
