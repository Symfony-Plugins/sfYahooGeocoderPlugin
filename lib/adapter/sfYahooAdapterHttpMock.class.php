<?php

/**
 * This file is part of the sfYahooGeocoderPlugin package.
 *
 * (c) 2009 Hugo Hamon <hugo.hamon@sensio.com> - sfYahooGeocoderPlugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * The sfYahooAdapterHttpMock mocks an http request
 *
 * @package sfYahooAdapterHttpCurl
 * @subpackage lib.adapter
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see sfYahooAdapterHttp
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooAdapterHttpMock extends sfYahooAdapterHttp
{
  const XML_SINGLE  = 'xml_single';
  const XML_RS      = 'xml_rs';
  const PHP_SINGLE  = 'php_single';
  const PHP_RS      = 'php_rs';

  protected $render = null;

  public function __construct($render = 'php_rs')
  {
    $this->render = $render;
  }

  protected function doSend()
  {
    switch($this->render)
    {
      case self::XML_SINGLE:
        return file_get_contents(dirname(__FILE__).'/../../test/fixtures/sfYahooGeocoderResponseXml.xml');
        break;
      case self::XML_RS:
        return file_get_contents(dirname(__FILE__).'/../../test/fixtures/sfYahooGeocoderResponseCollectionXml.xml');
        break;
      case self::PHP_SINGLE:
        return file_get_contents(dirname(__FILE__).'/../../test/fixtures/sfYahooGeocoderResponsePhp.txt');
        break;
      case self::PHP_RS:
        return file_get_contents(dirname(__FILE__).'/../../test/fixtures/sfYahooGeocoderResponseCollectionPhp.txt');
        break;
      default:
        throw new sfYahooGeocoderException('HTTP exception');
        break;
    }
  }
}