<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class ArticleException extends Exception {}

class Article {
  // 文章目錄名稱格式 yyyy.mm.dd_name
  const FORMAT = '/^(?P<createAt>\d\d\d\d\.(0?[1-9]|1[0-2])\.(0?[1-9]|[12][0-9]|3[01]))\s+\|\s+(?P<uri>.*)/';
  
  // 預設文章 md 名稱
  const MD_NAME = 'readme.md';

  // cover、icon 能接受的格式
  const IMG_FORMATS = ['jpg', 'jpeg', 'gif', 'png'];
  
  // 分頁格式
  const PAGE_URI = 'pages';
  
  // 記錄用
  private static $all = [];
  private static $imageUtility = null;

  public static function createCategoryType($dirname, $view, $dir, $uris) {
    try {
      return new self($dirname, $view, null, $dir, null, $uris);
    } catch (ArticleException $e) {
      throw new CategoryException('新增文章類型失敗！');
      return null;
    }
  }

  public static function all() {
    return array_values(self::$all);
  }

  public static function create($dirname, $view, $category) {
    try {
      if (!(preg_match_all(Article::FORMAT, $dirname, $matches) && isset($matches['createAt'][0], $matches['uri'][0])))
        return null;

      $dir = $category->dir() . $dirname . DIRECTORY_SEPARATOR;
      $uris = array_merge($category->uris(), [$matches['uri'][0]]);

      return new self($dirname, $view, $category, $dir, $matches['createAt'][0], $uris);
    } catch (ArticleException $e) {
      return null;
    }
  }

  // 藉由文章絕對位置找尋 url
  public static function existsByMarkdownPath($markdownPath = null) {
    return array_key_exists($markdownPath, self::$all) ? self::$all[$markdownPath] : null;
  }

  // 不可由外修改的變數，只能讀
  private $dirname, $mdFilepath, $dir, $htmlFilepath, $view = 'article.php';
  public function dirname() { return $this->dirname; }
  public function mdFilepath() { return $this->mdFilepath; }
  public function htmlFilepath() { return $this->htmlFilepath; }
  public function dir() { return $this->dir; }
  public function viewFilepath() { return PATH_VIEW . $this->view; }
  
  // 對外可用的變數
  public $category,
         $createAt,
         $updateAt,
         $url,
         $coverImage = DEFAULT_IMG_URL,
         $iconImage = DEFAULT_IMG_URL,
         $title = '',
         $description = '',
         $content = '',
         $tags = [];

  public function __construct($dirname, $view, $category, $dir, $createAt, $uris) {
    if (!is_dir($dir))
      throw new CategoryException('此路徑不是目錄！');

    if (!is_readable($dir))
      throw new CategoryException('目錄無法被讀取！');

    $mdFilepath = $dir . Article::MD_NAME;

    if (!is_readable($mdFilepath))
      throw new CategoryException('md 檔案無法被讀取！');

    $this->htmlFilepath = PATH . implode(DIRECTORY_SEPARATOR, $uris) . '.html';
    $this->url = BASE_URL . implode('/', array_map('rawurlencode', $uris)) . '.html';

    $this->category = $category;
    $this->dirname  = $dirname;
    $this->mdFilepath = $mdFilepath;
    $this->dir = $dir;
    $this->view = $view;

    $this->createAt = $this->updateAt = $createAt == null
      ? DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', filemtime($mdFilepath)))
      : DateTime::createFromFormat('Y.m.d', $createAt);
    
    
    self::$all[$this->dir] = $this;
  }
  
  public function toArray() {
    return [
      'category' => $this->category ? [
        'text' => $this->category->text,
        'url' => $this->category->url,
      ] : null,
      'title' => $this->title,
      'description' => $this->description,
      'content' => $this->content,
      'tags' => $this->tags,
      'createAt' => $this->createAt->format('Y-m-d H:i:s'),
      'updateAt' => $this->updateAt->format('Y-m-d H:i:s'),
      'url' => $this->url,
      'img' => [
        'cover' => $this->coverImage,
        'icon' => $this->iconImage,
      ],
    ];
  }  
  // 修飾內文
  public function modifyContent() {
    return $this->readMdContent()
                ->coverContentToHtml()
                ->coverImages()
                ->coverLinks()
                ->setUpdateAt()
                ->setContentTags()
                ->setCoverImage()
                ->setIconImage()
                ->setDescription()
                ->setTitle()
                ->removeContentLn();
  }

  // 讀取 md 內容
  private function readMdContent() {
    $this->content  = fileRead($this->mdFilepath);
    return $this;
  }

  // 移除空白
  private function replaceContentSpace($pattern, $removeLn = true) {
    $this->content = preg_replace($pattern, '', $this->content);
    return $removeLn ? $this->removeContentLn() : $this;
  }

  // 移除換行
  private function removeContentLn() {
    return $this->replaceContentSpace('/^[\n ]*|[\n ]*$/u', false);
  }

  // 轉換 md -> html
  private function coverContentToHtml() {
    $parsedown = new Parsedown();
    $this->removeContentLn();
    $this->content = $parsedown->text($this->content);
    $this->replaceContentSpace('/<!--(.*)-->/u');
    return $this;
  }
  
  // 將圖片複製一份至 img md5，統一存放，可以節省想同圖片的輸出與空間
  private function cpImage2Md5($file) {
    
    if (!defined('PATH_IMG_MD5'))
      return BASE_URL . implode('/', array_map('rawurlencode', explode(DIRECTORY_SEPARATOR, pathReplace(PATH, $file))));

    if (self::$imageUtility === null) {
      if (!is_dir(PATH_IMG_MD5) && ($errs = mkdirDirs(PATH_IMG_MD5)))
        throw new Exception('以下其他目錄無法建立：' . implode(', ', $errs));
      
      self::$imageUtility = [
        'new' => [],
        'old' => array_flip(array_filter(@scandir(PATH_IMG_MD5) ?: [], function($file) { return !in_array($file, ['.', '..', '.gitignore']); }))
      ];
    }

    $fileName = md5_file($file) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    $dest = PATH_IMG_MD5 . $fileName;

    if (!isset(self::$imageUtility['old'][$fileName])) {
      file_exists($dest) && is_readable($dest) || @copy($file, $dest);

      if (!is_readable($dest)) {
        if (CHECK_IMAGE_EXIST)
          throw new Exception(json_encode([
            '錯誤原因' => '搬移圖片至 Asset 錯誤！',
            '檔案位置' => pathReplace(PATH, $this->mdFilepath),
            '圖片位置' => pathReplace(PATH, $dest)
          ]));

        return DEFAULT_IMG_URL;
      }
    }

    array_push(self::$imageUtility['new'], $fileName);

    return BASE_URL . implode('/', array_map('rawurlencode', explode(DIRECTORY_SEPARATOR, pathReplace(PATH, $dest))));
  }

  // 搜尋符合 img 的標籤
  private function searchImages() {
    $pattern = '/<img.*?src=(["\'])(?P<imgs>.*?)\1[^\>]*>/u';

    $images = preg_match_all($pattern, $this->content, $matches) ? array_filter(array_map(function($img) {
      // 假設 src 是 http 或 https 或 mailto 或 tel 或 sftp 或 ftp，就直接回傳
      if (preg_match('/^https?:\/\/.*/ui', $img) || preg_match('/^mailto:/ui', $img) || preg_match('/^tel:/ui', $img) || preg_match('/^s?ftp:/ui', $img)) {
        return [
          'search' => $img,
          'replace' => $img,
        ];
      }
      
      // 取得圖片絕對位置，並且確認是否存在，不存在則出錯或採用預設圖
      if (!(($file = realpath($this->dir . $img)) && is_readable($file))) {
        if (CHECK_IMAGE_EXIST)
          throw new Exception(json_encode([
            '錯誤原因' => '圖片遺失，找不到圖片！',
            '檔案位置' => pathReplace(PATH, $this->mdFilepath),
            '圖片位置' => $img
          ]));

        return [
          'search' => $img,
          'replace' => DEFAULT_IMG_URL,
        ];
      }

      // 圖片存在，搬至 img/md5 並且對檔案 md5 名稱，或者直接使用
      return [
        'search' => $img,
        'replace' => $this->cpImage2Md5($file)
      ];
    }, array_unique(array_filter($matches['imgs'], function($t) {
      return $t;
    })))) : [];

    $tmps = [];
    foreach ($images as $image)
      if (!isset($tmps[$image['search']]))
        $tmps[$image['search']] = $image['replace'];

    return $tmps;
  }

  // 轉換圖像
  private function coverImages() {
    // 找出需要調整的 img
    $images = $this->searchImages();
    $pattern = '/<img.*?src=(["\'])(.*?)\1(.*?alt=(["\'])(.*?)\1)?([^\>]*)>/u';

    $this->content = preg_replace_callback($pattern, function($matches) use ($images) {
      $attrs = [
        'src' => isset($images[$matches[2]]) ? $images[$matches[2]] : DEFAULT_IMG_URL,
        'alt' => $matches[5]
      ];
      return '<img' . attr($attrs) . '>';
    }, $this->content);

    return $this;
  }

  // 搜尋符合 a 的標籤
  private function searchLinks() {
    $pattern = '/<a.*?href=(["\'])(?P<hrefs>.*?)\1[^\>]*>/u';
    
    $links = preg_match_all($pattern, $this->content, $matches) ? array_filter(array_map(function($href) {
      // 假設 src 是 http 或 https 或 mailto 或 tel 或 sftp 或 ftp，就直接回傳
      if (preg_match('/^https?:\/\/.*/ui', $href) || preg_match('/^mailto:/ui', $href) || preg_match('/^tel:/ui', $href) || preg_match('/^s?ftp:/ui', $href))
        return [
          'search' => $href,
          'replace' => $href,
        ];

      if (!(($search = realpath($this->dir . $href)) && is_readable($search))) {
        if (CHECK_LINK_EXIST)
          throw new Exception(json_encode([
            '錯誤原因' => '鏈結遺失，找不到鏈結！',
            '檔案位置' => pathReplace(PATH, $this->mdFilepath),
            '鏈結字串' => $href
          ]));

        return [
          'search' => $href,
          'replace' => PAGE_404_URL
        ];
      }

      $search = (is_dir($search) ? $search : dirname($search)) . DIRECTORY_SEPARATOR;

      if (($tmp = Article::existsByMarkdownPath($search)) !== null)
        return [
          'search' => $href,
          'replace' => $tmp->url
        ];
      
      if (CHECK_LINK_EXIST)
        throw new Exception(json_encode([
          '錯誤原因' => '鏈結遺失，找不到鏈結！',
          '檔案位置' => pathReplace(PATH, $this->mdFilepath),
          '鏈結字串' => $href
        ]));

      return [
        'search' => $href,
        'replace' => PAGE_404_URL
      ];
    }, array_unique(array_filter($matches['hrefs'], function($t) {
      return $t;
    })))) : [];

    $tmps = [];
    foreach ($links as $link)
      if (!isset($tmps[$link['search']]))
        $tmps[$link['search']] = $link['replace'];
   
    return $tmps;
  }

  // 轉換鏈結
  private function coverLinks() {
    $links = $this->searchLinks();

    $pattern = '/<a.*?href=(["\'])(?P<hrefs>.*?)\1[^\>]*>/u';
    
    $this->content = preg_replace_callback($pattern, function($matches) use ($links) {
      return '<a href=' . $matches[1] . (isset($links[$matches[2]]) ? $links[$matches[2]] : $matches[2]) . $matches[1] . '>';
    }, $this->content);

    return $this;
  }

  // 取得上次修改時間
  private function setUpdateAt() {
    if ($updateAt = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', filemtime($this->mdFilepath))))
      $this->updateAt = $updateAt;

    return $this;
  }
  
  // 解析出標籤
  private function setContentTags() {
    $pattern = '/<p.*?>\s*(?P<tags><code.*?>.+?<\/code>)\s*<\/p>$/u';
    if (!$tags = preg_match_all($pattern, $this->content, $matches) && isset($matches['tags'][0]) ? $matches['tags'][0] : [])
      return $this;

    $tags = implode('</code><code>', (explode('``', $tags)));

    if (!$tags = preg_match_all('/<code.*?>#(?P<tags>.+?)<\/code>/u', $tags, $matches) ? $matches['tags'] : [])
      return $this;

    $this->tags = array_filter(array_map(function($tag) { return trim($tag); }, $tags));
    $this->replaceContentSpace($pattern);

    return $this;
  }

  // 取得 cover 圖片
  private function setCoverImage() {
    foreach (Article::IMG_FORMATS as $format)
      if (file_exists($file = $this->dir . 'cover.' . $format) && is_readable($file))
        $this->coverImage = $this->cpImage2Md5($file);

    return $this;
  }

  // 取得 icon 圖片
  private function setIconImage() {
    $this->iconImage = DEFAULT_IMG_URL;

    foreach (Article::IMG_FORMATS as $format)
      if (file_exists($file = $this->dir . 'icon.' . $format) && is_readable($file))
        $this->iconImage = $this->cpImage2Md5($file);

    return $this;
  }
  
  // 取得 Description 字串
  private function setDescription() {
    $this->description = mb_strimwidth(removeHtmlTag($this->description), 0, 300, '…','UTF-8');
    return $this;
  }
 
  // 取得 H1 當 Title 字串
  private function setTitle() {
    $pattern = '/^<h1[^>]*?>(?P<title>.*)<\/h1>/u';
    if ($this->title = preg_match_all($pattern, $this->content, $matches) && isset($matches['title'][0]) ? $matches['title'][0] : '')
      $this->replaceContentSpace($pattern);

    return $this;
  }
}