<?php

	session_start();
	if( isset($_SESSION['user']) )
	{
		$user = $_SESSION['user'];
	}
	else
	{
		$user = '';
	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Hacker Helpline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Kyle J. Summers">

    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/chosen.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Hacker Helpline</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
            </ul>
          </div><!--/.nav-collapse -->
          <?php if (!empty($user)) { ?>
          <ul class="nav pull-right">
	          <li id="fat-menu" class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user; ?><b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <li><a href="#">Sign Out</a></li>
	            </ul>
	          </li>
	        </ul>
	      <?php } ?>
        </div>
      </div>
    </div>

    <div class="container">