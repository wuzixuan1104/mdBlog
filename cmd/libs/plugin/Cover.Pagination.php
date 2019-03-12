<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class Pagination {
  const LR_COUNT = 2;
  const FIRST_CLASS  = 'first';
  const PREV_CLASS   = 'prev';
  const ACTIVE_CLASS = 'now';
  const NEXT_CLASS   = 'next';
  const LAST_CLASS   = 'last';

  public static function create($baseUrl, $limit, $index, $total) {
    if ($total < 2)
      return '';

    $links = $prev = $first = $next = $last = [];

    for ($i = 0; $i < $total; $i++)
      if ($i == $index) {
        
        for ($j = $i - 1, $k = Pagination::LR_COUNT; $j >= 0 && $k > 0 && ($tmp = ['href' => $baseUrl . Article::PAGE_URI . '/' . ($j ? $j + 1 : 'index') . '.html', 'text' => $j + 1, 'class' => null]); $j--, $k--)
          array_unshift($links, !$prev ? $prev = $tmp : $tmp);
        
        array_push($links, ['href' => $baseUrl . Article::PAGE_URI . '/' . ($i ? $i + 1 : 'index') . '.html', 'text' => $i + 1, 'class' => Pagination::ACTIVE_CLASS]);
        
        for(++$i, $k = Pagination::LR_COUNT; $i < $total && $k > 0 && ($tmp = ['href' => $baseUrl . Article::PAGE_URI . '/' . ($i ? $i + 1 : 'index') . '.html', 'text' => $i + 1, 'class' => null]); $i++, $k--)
          array_push($links, !$next ? $next = $tmp : $tmp);

        break;
      }


    $links
      && $total
      && $links[0]['href'] != $baseUrl . Article::PAGE_URI . '/' . 'index.html'
      && $first = ['href' => $baseUrl . Article::PAGE_URI . '/' . 'index.html', 'text' => '', 'class' => Pagination::FIRST_CLASS];
    
    $links
      && $total
      && $links[count($links) - 1]['href'] != $baseUrl . Article::PAGE_URI . '/' . (($total - 1) + 1) . '.html'
      && $last = ['href' => $baseUrl . Article::PAGE_URI . '/' . (($total - 1) + 1) . '.html', 'text' => '', 'class' => Pagination::LAST_CLASS];

    $prev 
      && ($prev['class'] = Pagination::PREV_CLASS)
      && !($prev['text'] = '')
      && array_unshift($links, $prev);
    
    $first
      && array_unshift($links, $first);
    
    $next
      && ($next['class'] = Pagination::NEXT_CLASS)
      && !($next['text'] = '') && array_push($links, $next);
    
    $last
      && array_push($links, $last);

    return implode('', array_map(function($link) {
      return '<a' . attr($link, ['text']) . '>' . $link['text'] . '</a>';
    }, $links));
  }
}