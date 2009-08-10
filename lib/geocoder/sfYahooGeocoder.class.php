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
 * The sfYahooGeocoder class is the main component of the plugin. It delivers a simple and lightweight API 
 * to call the Yahoo! Geocoding webservice.
 *
 * The geocode() method will return a sfYahooGeocoderResponse instance if everything went fine or throw an 
 * exception otherwise.
 *
 * All setter methods returns $this, so method calls can be chained in order to make the API more readable and 
 * less verbose.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.geocoder
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 * @version 1.0 (stable)
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoder
{
  const YAHOO_OUTPUT_PHP = 'php';
  const YAHOO_OUTPUT_XML = 'xml';

  protected $outputs = array(
    self::YAHOO_OUTPUT_PHP,
    self::YAHOO_OUTPUT_XML
  );

  /**
   * Returns the raw http response as a string
   *
   * @var string
   */
  protected $rawResponse = '';

  /**
   * Array of query string parameters to send to the webservice
   *
   * @var array
   */
  protected $parameters = array();

  /**
   * Http adapter to support the HTTP transport
   *
   * @var sfYahooAdapterHttp
   */
  protected $httpAdapter = null;

  /**
   * Constructor
   *
   * @param string $yahooApiKey The Yahoo! API key
   * @param string $output      The output response format (php or xml)
   */
  public function __construct($yahooApiKey, $output = self::YAHOO_OUTPUT_PHP)
  {
    $this->setParameter('appid', $yahooApiKey);
    $this->setOutput($output);
  }

  /**
   * Bounds a query string parameter
   *
   * @param string $name The parameter's name
   * @param string $value The parameter's value
   *
   * @access protected
   */
  protected function setParameter($name, $value)
  {
    $this->parameters[$name] = $value;
  }

  /**
   * Returns a bound parameter
   *
   * @param string $name The parameter's name
   * @param string $default The default value to return
   *
   * @access protected
   */
  protected function getParameter($name, $default = null)
  {
    if (array_key_exists($name, $this->parameters))
    {
      return $this->parameters[$name];
    }

    return $default;
  }

  /**
   * Returns the raw response
   *
   * @return string
   */
  public function getRawResponse()
  {
    return $this->rawResponse;
  }

  /**
   * Returns the API key
   *
   * @return string
   */
  public function getApiKey()
  {
    return $this->getParameter('appid');
  }

  /**
   * Sets the street parameter
   *
   * @param string $street The street
   * @return $this sfYahooGeocoder
   */
  public function setStreet($street)
  {
    $this->setParameter('street', $street);

    return $this;
  }

  /**
   * Returns the street parameter
   *
   * @return string
   */
  public function getStreet()
  {
    return $this->getParameter('street');
  }

  /**
   * Sets the city parameter
   *
   * @param string $city The city
   * @return $this sfYahooGeocoder
   */
  public function setCity($city)
  {
    $this->setParameter('city', $city);

    return $this;
  }

  /**
   * Returns the city parameter
   *
   * @return string
   */
  public function getCity()
  {
    return $this->getParameter('city');
  }

  /**
   * Sets the state parameter
   *
   * @param string $state The state
   * @return $this sfYahooGeocoder
   */
  public function setState($state)
  {
    $this->setParameter('state', $state);

    return $this;
  }

  /**
   * Returns the state parameter
   *
   * @return string
   */
  public function getState()
  {
    return $this->getParameter('state');
  }

  /**
   * Sets the zip code parameter
   *
   * @param string $zipCode The zip code
   * @return $this sfYahooGeocoder
   */
  public function setZipCode($zipCode)
  {
    if (!preg_match('/^\d{5}(\-\d{4})?$/', $zipCode))
    {
      throw new Exception(sprintf('The given zip code "%s"does not match "ddddd" or "ddddd-dddd" pattern', $zipCode));
    }

    $this->setParameter('zip', $zipCode);

    return $this;
  }

  /**
   * Returns the zip code parameter
   *
   * @return string
   */
  public function getZipCode()
  {
    return $this->getParameter('zip');
  }

  /**
   * Sets the location parameter
   *
   * @param string $location The location parameter
   * @return $this sfYahooGeocoder
   */
  public function setLocation($location)
  {
    $this->setParameter('location', $location);

    return $this;
  }

  /**
   * Returns the location parameter
   *
   * @return string
   */
  public function getLocation()
  {
    return $this->getParameter('location');
  }

  /**
   * Sets the output parameter
   *
   * @param string $output The output format (xml or php)
   * @return $this sfYahooGeocoder
   * @throws sfYahooGeocoderException
   */
  public function setOutput($output)
  {
    $output = strtolower($output);

    if (!in_array($output, $this->outputs))
    {
      throw new sfYahooGeocoderException(sprintf('"%s" is not an expected outputs among "%s"', $output, implode(', ', $this->outputs)));
    }

    $this->setParameter('output', $output);

    return $this;
  }

  /**
   * Returns the output format
   *
   * @return string
   */
  public function getOutput()
  {
    return $this->getParameter('output');
  }

  /**
   * Sets the http adapter
   *
   * @param sfYahooAdapterHttp $httpAdapter A derived instance of class sfYahooAdapterHttp
   * @return $this sfYahooGeocoder
   */
  public function setHttpAdapter(sfYahooAdapterHttp $httpAdapter)
  {
    $this->httpAdapter = $httpAdapter;

    return $this;
  }

  /**
   * Returns the http adapter
   *
   * @return sfYahooAdapterHttp
   */
  public function getHttpAdapter()
  {
    return $this->httpAdapter;
  }

  /**
   * Processes the geocode process
   *
   * @return sfYahooGeocoderResponse A derived object of class sfYahooGeocoderResponse
   * @throws sfYahooGeocderException
   */
  public function geocode()
  {
    try
    {
      if (is_null($this->httpAdapter))
      {
        $this->httpAdapter = new sfYahooAdapterHttpStream();
      }

      $this->httpAdapter->setParameters($this->parameters);

      $collection = $this->httpAdapter->handle();
      
      $this->rawResponse = $this->httpAdapter->getContent();

      return $collection;
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }
}