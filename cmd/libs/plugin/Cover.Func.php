<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

if (!function_exists('argv')) {
  function argv($argv, $keys) {
    $ks = $return = $result = [];

    if (!($argv && $keys))
      return $return;

    foreach ($keys as $key)
      if (is_array($key))
        foreach ($key as $k)
          array_push($ks, $k);
      else
        array_push($ks, $key);

    $key = null;
    
    foreach ($argv as $param)
      if (in_array($param, $ks))
        if (!isset($result[$key = $param]))
          $result[$key] = [];
        else ;
      else if (isset($result[$key]))
        array_push($result[$key], $param);
      else ;

    foreach ($keys as $key)
      if (is_array($key))
        foreach ($key as $k)
          if (isset($result[$k]))
            $return[$key[0]] = isset($return[$key[0]]) ? array_merge($return[$key[0]], $result[$k]) : $result[$k];
          else;
      else if (isset($result[$key]))
        $return[$key] = isset($return[$key]) ? array_merge($return[$key], $result[$key]) : $result[$key];
      else ;
  
    return $return;
  }
}

if (!function_exists('pathReplace')) {
  function pathReplace($search, $subject, $replace = '') {
    return preg_replace('/^(' . preg_replace('/\//', '\/', $search) . ')/', $replace, $subject);
  }
}

if (!function_exists('fileWrite')) {
  function fileWrite($path, $data, $mode = 'wb') {
    if (function_exists('file_put_contents')) {
      @file_put_contents($path, $data);
      return file_exists($path);
    }

    if (!$fp = @fopen($path, $mode))
      return false;

    flock($fp, LOCK_EX);

    for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result)
      if (($result = fwrite($fp, substr($data, $written))) === false)
        break;

    flock($fp, LOCK_UN);
    fclose($fp);

    return file_exists($path);
  }
}

if (!function_exists('fileRead')) {
  function fileRead($file) {
    if (!file_exists($file))
      return '';
    
    if (function_exists('file_get_contents'))
      return @file_get_contents($file);
    
    $fp = @fopen($file, FOPEN_READ);

    if ($fp === false)
      return '';

    flock($fp, LOCK_SH);

    $data = '';

    if (filesize($file) > 0)
      $data =& fread($fp, filesize($file));

    flock($fp, LOCK_UN);
    fclose($fp);

    return $data;
  }
}

if (!function_exists('mkdir777')) {
  function mkdir777($path) {
    $oldmask = umask(0);
    $return = @mkdir($path, 0777, true);
    umask($oldmask);
    return $return;
  }
}

if (!function_exists('mkdirDirs')) {
  function mkdirDirs($dirs) {
    return array_filter(array_map(function($dir) {
      return mkdir777($dir) && createGitignoreFile($dir) && createDirIndex($dir) ? null : pathReplace(PATH, $dir);
    }, arrayFlatten(func_get_args())));
  }
}

if (!function_exists('attr')) {
  function attr($attrs, $exclude = []) {
    $attrs = array_filter($attrs, function($attr) { return $attr !== null; });
    $attrs = array_filter(array_map(function($k, $v) use ($exclude) { if ($exclude && in_array($k, $exclude)) return ''; return is_bool($v) ? $v === true ? $k : '' : ($k . '="' . $v . '"'); }, array_keys($attrs), array_values($attrs)));
    return $attrs ? ' ' . implode(' ', $attrs) : '';
  }
}

if (!function_exists('removeHtmlTag')) {
  function removeHtmlTag($text, $space = true) {
    return preg_replace('/\s+/u', $space ? ' ' : '', preg_replace('/&#?[a-z0-9]+;/ui', '', trim(strip_tags($text))));
  }
}

if (!function_exists('arrayFlatten')) {
  function arrayFlatten($arr) {
    $new = [];

    foreach ($arr as $val)
      if (is_array($val))
        $new = array_merge($new, arrayFlatten($val));
      else
        array_push($new, $val);

    return $new;
  }
}

if (!function_exists('loadView')) {
  function loadView($___B10g___aT_GiNkg0___path___B10g___aT_GiNkg0___, $___B10g___aT_GiNkg0___pARams___B10g___aT_GiNkg0___ = []) {
    if (!is_readable($___B10g___aT_GiNkg0___path___B10g___aT_GiNkg0___))
      return '';

    extract($___B10g___aT_GiNkg0___pARams___B10g___aT_GiNkg0___);
    ob_start();

    include $___B10g___aT_GiNkg0___path___B10g___aT_GiNkg0___;
    $buffer = ob_get_contents();
    @ob_end_clean();

    return $buffer;
  }
}

if (!function_exists('createDirIndex')) {
  function createDirIndex($path) {
    return file_exists($tmp = $path . 'index.html') || (is_dir($path) && is_writable($path) && fileWrite($tmp, '<!DOCTYPE html><html lang="tw"><head><meta http-equiv="Content-type" content="text/html; charset=utf-8"><meta http-equiv="Content-Language" content="zh-tw"><title></title><meta name="robots" content="noindex,nofollow"></head><body lang="zh-tw"><script type="text/javascript">var url = "' . Article::PAGE_URI . '/index.html"; window.location.assign(url);</script> </body></html>') && file_exists($tmp));
  }
}

if (!function_exists('createGitignoreFile')) {
  function createGitignoreFile($path) {
    return file_exists($tmp = $path . '.gitignore') || (is_dir($path) && is_writable($path) && fileWrite($tmp, '*') && file_exists($tmp));
  }
}
