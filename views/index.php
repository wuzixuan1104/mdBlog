<!DOCTYPE html>
<html lang="zh-Hant">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
    <meta name="robots" content="index,follow" />
    
    <title>首頁</title>

    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/icon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/public.css">

    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL;?>js/jquery-1.12.4.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL;?>js/public.js"></script>
  </head>
  <body>
    <div id='menu'>
<?php foreach (Categories::all() as $category) { ?>
        <a href="<?php echo $category->url;?>" class='<?php echo $category->className;?>'><?php echo $category->text;?></a>
<?php }?>
    </div>

    <div id='article'>
<?php echo $article->content;?>
    </div>
  </body>
</html>