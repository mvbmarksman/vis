<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
    <meta name="description" content="Inventory system for Vieva Auto Parts." />
    <title>Vieva Auto Parts Inventory System</title><link href="/public/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="/public/css/reset.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/public/css/vis.css" rel="stylesheet" type="text/css" media="screen"/>
  </head>
  
  <body>
    <div id="wrapper">
      
      <div id="header">
      	<h1>Vieva Auto Parts Inventory System</h1>
      </div>
      
      <div id="sidebar">
		<?php $menu->render() ?>
      </div>
      
      <div id="content">
		<?php $content->render() ?>
      </div>
      
      <div id="footer" class="clear">
      	Footer
      </div>
      
    </div>  
  </body>
</html>      