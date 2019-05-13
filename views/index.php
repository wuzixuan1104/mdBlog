<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title>吳姿萱 - Shari Wu's Blog</title>

    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/icon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/public.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/index.css">

    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL;?>js/jquery-1.12.4.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL;?>js/imgLiquid-min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL;?>js/public.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL;?>js/layout.js"></script>
    
  </head>
  <body lang="zh-tw">
    <header id="header"></header>
    <input id="chb-menu" type="checkbox">
    <div id="menu">
      <label id="back" for="chb-menu" class="icon-r"></label>
      <header>
        <label for="chb-menu" class="icon-l">Shari's Blog</label>
        <div><img src="<?php echo BASE_URL;?>/img/ori_76fdb17fdf6abf1943a73dc2361d4a8c.png"</div>
      </header>
      <a href="https://github.com/wuzixuan1104" class="icon-gi yellow-btn">GitHub</a>

      <div class="links">
        <?php foreach (Categories::all() as $category) { ?>
                <a href="<?php echo $category->url;?>" class='<?php echo $category->className;?>'><?php echo $category->text;?></a>
        <?php }?>
      </div>
    </div>
    
    <input id="chb-mobmenu" type="checkbox">
    <div id="mobMenu">
      <div class="block">
        <label class="l icon-list" for="chb-mobmenu"></label>
        <span>
          <svg height="60px" width="100px" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M0 0 L 15 0 A 35 35 0 0 0 50 35 A 35 35 0 0 0 85 0 L 100 0 L 100 60 L 0 60" fill="#384854"/></svg>
          <a href="https://github.com/wuzixuan1104" class="icon-gi"></a>
        </span>
        <label class="r"></label>
      </div>
      <div class="pop">
        <label class="avatar"><img src="#"></label>
        <div class="svg">
          <label class="l"></label>
          <svg class="btn" height="50px" width="100px" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M0 0 L 25 0 A 25 25 0 0 0 50 25 A 25 25 0 0 0 75 0 L 100 0 L 100 50 L 0 50" fill="#35444e"/></svg>
          <label class="r"></label>
        </div>
        <div class="links">
          <?php foreach (Categories::all() as $category) { ?>
                <a href="<?php echo $category->url;?>" class='<?php echo $category->className;?> active'><?php echo $category->text;?></a>
          <?php }?>
        </div>
      </div>
    </div>
    <label id="cover" for="chb-mobmenu"></label>

    <main id="main">
      <h1>Shari</h1>
      <header>
        <figure class="bg"><img src="<?php echo BASE_URL;?>/img/ori_5249f7cd6c31558c5aba16b32916cec2.jpg"></figure>
        <span class="bottom">我不厲害，我只是個小小菜鳥工程師__</span>
      </header>

      <artical class="m">
        <span class="title">關於Hsuan</span>
        <div class="about">叫我姿萱吧！我是個喜愛寫程式又愛到處玩耍的工程師，也是淡水在地人喔，這是我的第一個部落格，在這裡我會放上我的學習記錄、成就解鎖、心情耍廢文，希望能將人生中很多重要的事記錄在這邊，我不厲害還只是個小小菜鳥工程師，但是我很喜歡我的工作，未來也會有更多自己的作品，再放上來和大家分享！有任何問題也歡迎跟我討論喔:)</div>
        <span class="title">更新記錄</span>
        <div class="calendar">
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="1"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="2"><span>2019-05-13 操作了 0 次</span></a></div>
          <div><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a><a href="#" data-cnt="0"><span>2019-05-13 操作了 0 次</span></a></div>
        </div>

        <span class="title">熱門文章</span>
        <div class="hot">
          <a href="<?php echo BASE_URL;?>">
            <figure class="bg"><img src=""></figure>
            <b data-tip="">部落格出爐摟！</b>
            <span>test</span>
          </a>
        </div>
      </artical>

    </main>

  </body>
</html>
