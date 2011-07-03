<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="description" content="Inventory system for Vieva Auto Parts." />
    <title>Vieva Auto Parts Inventory System</title><link href="/public/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="/public/css/reset.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/public/css/vis.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/public/css/form.css" rel="stylesheet" type="text/css" media="screen"/>

    <script type="text/javascript" src="/public/js/jquery-1.6.1.min.js"></script>
    
    <script type="text/javascript" src="/public/js/jquery-ui-1.8.14.redmond/js/jquery-ui-1.8.14.custom.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/js/jquery-ui-1.8.14.redmond/css/redmond/jquery-ui-1.8.14.custom.css" />
    
    <script type="text/javascript" src="/public/js/flexigrid/js/flexigrid.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/js/flexigrid/css/flexigrid.css" />
	
	<script type="text/javascript" src="/public/js/utils.js"></script>
  </head>

  <body>
    <div id="wrapper">

      <div id="header">
      	<h1>Vieva Auto Parts Inventory System</h1>
      </div>
      
      <div id="accountBar">
      	Logged in as Mark [ <a href="#">Logout</a> ]
      </div>

      <div id="sidebar">
		<?php $search->render() ?>
		<?php $menu->render() ?>
      </div>

      <div id="content">
		<?php $content->render() ?>
      </div>

<!--      <div id="footer" class="clear">-->
<!--      	Footer-->
<!--      </div>-->

    </div>
  </body>
</html>