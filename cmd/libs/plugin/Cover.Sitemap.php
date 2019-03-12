<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 - 2019, Ginkgo
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class Sitemap {
  const SCHEMA = 'http://www.sitemaps.org/schemas/sitemap/0.9';
  const SCHEMA_IMAGE = 'http://www.google.com/schemas/sitemap-image/1.1';
  const OFFSET = 200;

  private $fileName, $items = [];
  public function __construct($fileName, $items) {
    $this->fileName = $fileName;
    $this->items = $items;
  }

  public function newXml() {
    $path = PATH_SITEMAP . $this->fileName . '.xml';

    $xml = new XMLWriter();
    $xml->openURI($path);
    $xml->startDocument('1.0', 'UTF-8');
    $xml->setIndent(true);
    $xml->startElement('urlset');
    $xml->writeAttribute('xmlns', Sitemap::SCHEMA);
    return $xml;
  }

  public function endXml(XMLWriter $xml) {
    $xml->endDocument();
    return true;
  }

  public function writeArticleXml() {
    $xml = $this->newXml();
    
    foreach ($this->items as $item) {
      $xml->startElement('url');

      foreach ($item as $key => $value)
        if (in_array($key, ['loc', 'priority', 'changefreq', 'lastmod']))
          $xml->writeElement($key, $value);

      $xml->endElement();
    }

    return $this->endXml($xml);
  }

  public function writeSubXml() {
    $url = BASE_URL . 'sitemap/' . $this->fileName . '.xml';

    if (!$this->writeArticleXml())
      return false;

    return $url;
  }

  public static function create($items, $i) {
    return new static('sitemap_' . $i, $items);
  }

  private static function writeXml($sitemaps) {
    $xml = new XMLWriter();
    $xml->openURI(PATH_SITEMAP . 'sitemap_index.xml');
    $xml->startDocument('1.0', 'UTF-8');
    $xml->setIndent(true);
    $xml->startElement('sitemapindex');
    $xml->writeAttribute('xmlns', self::SCHEMA);

    $xml->startElement('sitemap');
    foreach ($sitemaps as $sitemap)
      $xml->writeElement('loc', $sitemap);

    $xml->writeElement('lastmod', date ('c'));
    $xml->endElement();

    $xml->endElement();
    $xml->endDocument();


    $xml = new XMLWriter();
    $xml->openURI(PATH . 'sitemap.xml');
    $xml->startDocument('1.0', 'UTF-8');
    $xml->setIndent(true);
    $xml->startElement('sitemapindex');
    $xml->writeAttribute('xmlns', self::SCHEMA);

    $xml->startElement('sitemap');
    $xml->writeElement('loc', BASE_URL . 'sitemap/sitemap_index.xml');

    $xml->writeElement('lastmod', date ('c'));
    $xml->endElement();

    $xml->endElement();
    $xml->endDocument();
    return true;
  }

  public static function createRobots() {
    $str = "Sitemap: " . BASE_URL . "sitemap/sitemap_index.xml";
    $str .= "\n";
    $str .= "\n";
    $str .= "User-agent: *";

    return @fileWrite(PATH . 'robots.txt', $str) ? true : false;
  }
  
  public static function write($items) {
    $items = array_chunk($items, Sitemap::OFFSET);

    self::writeXml(array_map(function($sitemap) {
      return $sitemap->writeSubXml();
    }, array_map('static::create', $items, array_keys($items))));

    return true;
  }
}