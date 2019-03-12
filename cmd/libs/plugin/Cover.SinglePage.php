<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class SinglePage {
  public static function create($htmlName, $viewName, $data) {
    if (!is_readable($view = PATH_VIEW . $viewName))
      throw new Exception($htmlName . ' 的 View 檔案不存在，路徑：' . $view);

    $html = loadView($view, $data);

    if (!fileWrite(PATH . $htmlName, $html))
      throw new Exception('寫 ' . $viewName . ' 檔案失敗，路徑：' . PATH . $htmlName);
  }
}