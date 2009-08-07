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
 * The sfYahooAdapterHttpStream calls the Yahoo! Geocoding webservice thanks to the stream_* functions.
 *
 * @package sfYahooAdapterHttpCurl
 * @subpackage lib.adapter
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see sfYahooAdapterHttp
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooAdapterHttpStream extends sfYahooAdapterHttp
{
  /**
   * Constructor
   *
   * Checks if stream_* functions are loaded
   *
   * @throws sfYahooGeocoderException
   */
  public function __construct()
  {
    if (!function_exists('stream_context_create'))
    {
      throw new sfYahooGeocoderException('The current PHP configuration does not support stream contexts');
    }
  }

  /**
   * Calls the webservice and returns the response
   *
   * @return string $content The HTTP response content (xml or serialised php array)
   * @throws sfYahooGeocoderException
   */
  protected function doSend()
  {
    $context = stream_context_create(array(
      'http' => array(
        'method'  => 'GET',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'timeout' => 5,
      ),
    ));

    $content = file_get_contents($this->getUri(), false, $context);

    if (!$content)
    {
      throw new sfYahooGeocoderException('An error occured while trying to obtain the response from the Yahoo! Geocoding service');
    }

    return $content;    
  }
}