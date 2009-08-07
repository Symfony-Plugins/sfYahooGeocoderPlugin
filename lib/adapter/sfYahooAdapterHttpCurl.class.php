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
 * The sfYahooAdapterHttpCurl calls the Yahoo! Geocoding webservice thanks to the CURL library.
 *
 * @package sfYahooAdapterHttpCurl
 * @subpackage lib.adapter
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see sfYahooAdapterHttp
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooAdapterHttpCurl extends sfYahooAdapterHttp
{
  /**
   * Constructor
   *
   * Checks if the curl library is loaded
   *
   * @throws sfYahooGeocoderException
   */
  public function __construct()
  {
    if (!extension_loaded('curl'))
    {
      throw new sfYahooGeocoderException('Curl extension must be loaded on the web server');
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
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->getUri());
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $content = curl_exec($curl);
    
    if (!$content || curl_error($curl))
    {
      throw new sfYahooGeocoderException('An error occured while sending the Curl request');
    }

    if (200 !== (int) curl_getinfo($curl, CURLINFO_HTTP_CODE))
    {
      throw new sfYahooGeocoderException(sprintf('The Yahoo! Geocoder Service did not return a 200 status code : %s', curl_error($curl)));
    }

    curl_close($curl);

    return $content;
  }
}