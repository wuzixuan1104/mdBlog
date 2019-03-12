<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class CategoryException extends Exception {}

class Categories {
  private static $categories = [];

  public static function all() {
    return self::$categories;
  }

  public static function writeArticlePagesHtml($limit, $closure) {
    foreach (self::$categories as $category) {
      if ($category->isArticle)
        continue;

      $pages = array_chunk($category->articles, $limit);
      $pages || $pages = [[]];
      $total = count($pages);

      foreach ($pages as $i => $articles) {
        $data = $closure($articles);
        is_array($data) || $data = [];
        $data['pagination'] = Pagination::create(BASE_URL . implode('/', array_map('rawurlencode', $category->uris())) . '/', $limit, $i, $total);

        if (!is_readable($view = PATH_VIEW . 'page.php'))
          throw new Exception('View 檔案不存在，路徑：' . $view);

        $html = loadView($view, $data);
        $dir = PATH . implode(DIRECTORY_SEPARATOR, array_merge($category->uris(), [Article::PAGE_URI])) . DIRECTORY_SEPARATOR;
        @mkdirDirs($dir);

        if (!fileWrite($dir . ($i ? $i + 1 : 'index') . '.html', $html))
          throw new Exception('寫 article 分頁 html 檔案失敗，路徑：' . $dir . ($i ? $i + 1 : 'index') . '.html');
      }
    }
  }

  public static function writeArticlesHtml($closure) {
    foreach (self::$categories as $category) {
      foreach ($category->articles as $article) {
        $data = $closure($article);
        is_array($data) || $data = [];
        
        if (!is_readable($view = $article->viewFilepath()))
          throw new Exception('View 檔案不存在，路徑：' . $view);

        $html = loadView($view, $data);
        @mkdirDirs(dirname($article->htmlFilepath()) . DIRECTORY_SEPARATOR);

        if (!fileWrite($article->htmlFilepath(), $html))
          throw new Exception('寫 article html 檔案失敗，路徑：' . $article->htmlFilepath());
      }
    }
  }

  public static function create() {
    return self::$categories = Category::modifyArticlesContent(
      array_values(
        array_filter(
          arrayFlatten(
            func_get_args()))));
  }
}

class Category {
  // 修改文章內容
  public static function modifyArticlesContent($categories) {
    foreach ($categories as $category)
      foreach ($category->articles as $article)
        $article->modifyContent();
    return $categories;
  }

  // 目錄名稱, 顯示的文字, 代表的 icon, 目錄網址的名稱
  // uri 若為 null，則代表是 article
  public static function create($dirname, $uri, $text, $className = null, $view = 'article.php', $isArticle = false) {
    try {
      return new self($dirname, $uri, $text, $className, $view, $isArticle);
    } catch (CategoryException $e) {
      return null;
    }
  }

  // 不可由外修改的變數，只能讀
  private $dir, $uris;
  public function dir() { return $this->dir; }
  public function uris() { return $this->uris; }
  

  // 對外可用變數
  public $text,
         $className,
         $url,
         $articles = [],
         $isArticle = false;

  public function __construct($dirname, $uri, $text, $className = null, $view = 'article.php', $isArticle = false) {
    $dir = PATH_MD . trim($dirname, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $text = trim($text);
    $uris = array_values(array_filter(explode('/', trim($uri, '/')), function($t) { return $t !== ''; }));
    
    if (!is_dir($dir))
      throw new CategoryException('此路徑不是目錄！');

    if (!is_readable($dir))
      throw new CategoryException('目錄無法被讀取！');

    if ($text === '')
      throw new CategoryException('請給予類別顯示的文字！');

    if (!$uris)
      throw new CategoryException('請給予類別網址的名稱！');

    $this->dir = $dir;
    $this->text = $text;
    $this->className = $className;
    $this->uris = $uris;
    
    $this->isArticle = $isArticle;

    if ($this->isArticle) {
      $article = Article::createCategoryType($dirname, $view, $this->dir, $this->uris);
      $this->url = $article->url;
      $this->articles = [$article];
    } else {
      $this->url = BASE_URL . implode('/', array_map('rawurlencode', array_merge($uris, [Article::PAGE_URI]))) . '/index.html';

      $this->articles = array_values(array_filter(array_map(function($dirname) use ($view) {
        return Article::create($dirname, $view, $this);
      }, @scandir($this->dir) ?: [])));

      // 不可取代的目錄
      $dirs = ['cmd', 'css', 'font', 'img', 'js', 'markdowns', 'scss', 'views', 'sitemap'];

      if (in_array($this->uris[0], $dirs))
        throw new CategoryException('請給予類別網址的名稱！');
    }
  }
  
}