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
  protected function doSend()
  {
    return file_get_contents(dirname(__FILE__).'/../../test/fixtures/sfYahooGeocoderResponseCollectionPhp.txt');
  }
}