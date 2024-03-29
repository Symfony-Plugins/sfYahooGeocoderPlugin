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
 * The sfYahooAdapterHttp class provides the base mechanisms to manage how the Yahoo! Geocoder webservice
 * has to be called.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.adapter
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
abstract class sfYahooAdapterHttp
{
  /**
   * Yahoo! Geocoder webservice base uri
   *
   * @var string
   */
  const YAHOO_API_URI = 'http://local.yahooapis.com/MapsService/V1/geocode';

  /**
   * Query string parameters
   *
   * @var array
   */
  protected $parameters = array();

  /**
   * The HTTP response content
   *
   * @return string
   */
  protected $content = '';

  /**
   * Sets the query string parameters
   *
   * @var array $parameters The array of query string parameters
   */
  public function setParameters(array $parameters)
  {
    $this->parameters = $parameters;
  }

  /**
   * Returns the array of query string parameters
   *
   * @return array
   */
  public function getParameters()
  {
    return $this->parameters;
  }

  /**
   * Returns a parameter's value
   *
   * @param string $name The parameter's name
   * @param string $default The default value to return
   *
   * @return string The value
   */
  public function getParameter($name, $default = null)
  {
    if (array_key_exists($name, $this->parameters))
    {
      return $this->parameters[$name];
    }

    return $default;
  }

  /**
   * Returns the query string of parameters
   *
   * @return string The URL encoded query string
   */
  public function getQueryString()
  {
    return http_build_query($this->getParameters());
  }

  /**
   * Returns the full absolute API Uri
   *
   * @return string
   */
  public function getUri()
  {
    return sprintf('%s?%s', self::YAHOO_API_URI, $this->getQueryString());
  }

  /**
   * Handles the http transport process
   *
   * @return string
   * @throws sfYahooGeocoderException
   */
  public function handle()
  {
    try
    {
      $this->content = $this->doSend();
    }
    catch (Exception $e)
    {
      throw $e;
    }

    return $this->getContent();
  }

  /**
   * Returns the HTTP response content
   *
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Calls the webservice and returns the HTTP response content
   *
   * @abstract
   */
  abstract protected function doSend();
}