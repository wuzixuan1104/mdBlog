<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

// 設定編碼
mb_regex_encoding('UTF-8');
mb_internal_encoding('UTF-8');
date_default_timezone_set('Asia/Taipei');

// 定義路徑
define('PATH_PLUGIN', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PATH_LIBS', dirname(PATH_PLUGIN) . DIRECTORY_SEPARATOR);
define('PATH_CMD', dirname(PATH_LIBS) . DIRECTORY_SEPARATOR);
define('PATH', dirname(PATH_CMD) . DIRECTORY_SEPARATOR);
define('PATH_MD', PATH . 'markdowns' . DIRECTORY_SEPARATOR);
define('PATH_VIEW', PATH . 'views' . DIRECTORY_SEPARATOR);
define('PATH_SITEMAP', PATH . 'sitemap' . DIRECTORY_SEPARATOR);

try {
  // // 錯誤範例
  // throw new Exception('錯誤原因 1');
  // throw new Exception(json_encode(['錯誤原因 2', '錯誤原因 3']));
  // throw new Exception(json_encode(['錯誤原因' => '4', '錯誤原因' => '5']));

  // 載入資源
  include_once PATH_PLUGIN . 'Cover.Func.php';        // 載入 Func
  include_once PATH_PLUGIN . 'Cover.SinglePage.php';  // 載入 SinglePage
  include_once PATH_PLUGIN . 'Cover.Category.php';    // 載入 Category
  include_once PATH_PLUGIN . 'Cover.Article.php';     // 載入 Article
  include_once PATH_PLUGIN . 'Cover.Parsedown.php';   // 載入 Parsedown
  include_once PATH_PLUGIN . 'Cover.Pagination.php';  // 載入 Pagination
  include_once PATH_PLUGIN . 'Cover.Sitemap.php';     // 載入 Sitemap

  // 取得參數
  $argv = argv(array_slice($argv, 1), [['--base-url']]);

  if (!isset($argv['--base-url'][0]))
    throw new Exception('沒有給定「--base-url」參數！');

  // 定義 base url
  define('BASE_URL', rtrim($argv['--base-url'][0], '/') . '/');

  // 預設圖的網址
  define('DEFAULT_IMG_URL', BASE_URL . 'img/default.png');

  // 檢查文章中圖片是否遺失，true -> 要檢查，遺失則報錯，false -> 不檢查，遺失則補 default image url(DEFAULT_IMG_URL)
  define('CHECK_IMAGE_EXIST', true);

  // 是否將文章中的圖片集中到 img/md5 並且將檔案名稱 md5 編碼，此方法可以減少相同圖片的流量與 cache，不要的話就不要 define 即可
  define('PATH_IMG_MD5', PATH . 'img' . DIRECTORY_SEPARATOR . 'md5' . DIRECTORY_SEPARATOR);

  // 404 page url
  define('PAGE_404_URL', BASE_URL . '404.html');

  // 檢查文章中鏈結是否遺失，true -> 要檢查，遺失則報錯，false -> 不檢查，遺失則補 404 page url(PAGE_404_URL)
  define('CHECK_LINK_EXIST', true);



/* ------------------------------------------------------
 *  文章
 * ------------------------------------------------------ */

  // 分類
  Categories::create([
    Category::create('001_首頁', 'index', '首頁', 'icon-01', 'index.php', true),
    Category::create('002_開發', 'Dev',   '開發', 'icon-02'),
    Category::create('003_美食', 'Food',  '美食', 'icon-03'),
  ]);

  // 寫 article html 檔案
  Categories::writeArticlesHtml(function($article) {
    return [
      'article' => $article
    ];
  });

  // 寫 article 分頁 html 檔案
  Categories::writeArticlePagesHtml(2, function($articles) { // 一個分頁會有的 articles
    return [
      'title' => '文章列表',
      'articles' => $articles
    ];
  });
  


/* ------------------------------------------------------
 *  單一頁面
 * ------------------------------------------------------ */

  // Create 404 page
  SinglePage::create('404.html', '404.php', [
    'message' => '你迷路了嗎？'
  ]);

  // Create 404 page
  SinglePage::create('search.html', 'search.php', [
    'articles' => array_map(function($article) {
      return $article->toArray();
    }, Article::all())
  ]);



/* ------------------------------------------------------
 *  SEO
 * ------------------------------------------------------ */
  
  // Create Sitemaps
  Sitemap::write(array_map(function($article) {
    return [
      'loc' => $article->url,
      'priority' => $article->category ? 1 : 0.5,
      'changefreq' => 'hourly',
      'lastmod' => $article->createAt->format('c'),
    ];
  }, Article::all()));

  // Create robots.txt
  Sitemap::createRobots();

} catch (Exception $e) {
  echo $e->getMessage();
  exit(1);
}

exit(0);
