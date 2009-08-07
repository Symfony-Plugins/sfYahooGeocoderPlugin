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
 * The sfYahooGeocoderResponse provides method to get data returned by the webservice
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.response
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 * @abstract
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
abstract class sfYahooGeocoderResponse implements ArrayAccess
{
  protected 
    $content,
    $latitude,
    $longitude,
    $address,
    $city,
    $state,
    $zip,
    $country,
    $precisionLevel;

  /**
   * Hydrates the object by parsing the HTTP response content
   *
   * @abstract
   */
  abstract protected function hydrate();

  /**
   * Checks if the offset exists in the array representation
   *
   * @see ArrayAccess
   * @return boolean
   */
  public function offsetExists($offset)
  {
    return array_key_exists($offset, $this->_toArray());
  }

  /**
   * Returns a value if it exists in the array representation
   *
   * @see ArrayAccess
   * @return mixed
   * @throws sfYahooGeocoderException
   */
  public function offsetGet($offset)
  {
    if (!$this->getoffsetExists($offset))
    {
      throw new sfYahooGeocoderException(sprintf('Offset "%s" does not exist', $offset));
    }

    $infos = $this->_toArray();

    return $infos[$offset];
  }

  /**
   * Sets a key / value pair in the array representation, throws an exception
   *
   * @param string $offset
   * @param mixed $value
   * @throws sfYahooGeocoderException
   */
  public function offsetSet($offset, $value)
  {
    throw new sfYahooGeocoderException('Setting values via ArrayAccess is not authorized');
  }

  /**
   * Removes a value from the array representation, throws an exception
   *
   * @param string $offset
   * @throws sfYahooGeocoderException
   */
  public function offsetUnset($offset)
  {
    throw new sfYahooGeocoderException('Removing values via ArrayAccess is not authorized');
  }

  /**
   * Sets the HTTP response content
   *
   * @param string $content The HTTP response content
   */
  public function setContent($content)
  {
    $this->content = $content;

    $this->hydrate();
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
   * Sets the latitude
   *
   * @param double $latitude The latitude
   */
  public function setLatitude($latitude)
  {
    $this->latitude = (double) $latitude;
  }

  /**
   * Returns the latitude
   *
   * @return double
   */
  public function getLatitude()
  {
    return $this->latitude;
  }

  /**
   * Sets the longitude
   *
   * @param double $longitude
   */
  public function setLongitude($longitude)
  {
    $this->longitude = (double) $longitude;
  }

  /**
   * Returns the longitude
   *
   * @return double
   */
  public function getLongitude()
  {
    return $this->longitude;
  }

  /**
   * Sets the postal address
   *
   * @param string $address
   */
  public function setAddress($address)
  {
    $this->address = trim((string) $address);
  }

  /**
   * Returns the postal address
   *
   * @return string
   */
  public function getAddress()
  {
    return $this->address;
  }

  /**
   * Sets the country code
   *
   * @param string $country
   */
  public function setCountry($country)
  {
    $this->country = trim((string) $country);
  }

  /**
   * Returns the country code
   *
   * @return string
   */
  public function getCountry()
  {
    return $this->country;
  }

  /**
   * Sets the city
   *
   * @param string $city
   */
  public function setCity($city)
  {
    $this->city = trim((string) $city);
  }

  /**
   * Returns the city
   *
   * @return string
   */
  public function getCity()
  {
    return $this->city;
  }

  /**
   * Sets the state
   *
   * @param string $state
   */
  public function setState($state)
  {
    $this->state = trim((string) $state);
  }

  /**
   * Returns the state
   *
   * @return string
   */
  public function getState()
  {
    return $this->state;
  }

  /**
   * Sets the zip code
   *
   * @param string $zip
   */
  public function setZip($zip)
  {
    $this->zip = trim((string) $zip);
  }

  /**
   * Returns the zip code
   *
   * @return string
   */
  public function getZip()
  {
    return $this->zip;
  }

  /**
   * Sets the precision level
   *
   * @param string $precision
   */
  public function setPrecisionLevel($precision)
  {
    $this->precisionLevel = trim((string) $precision);
  }

  /**
   * Returns the precision level
   *
   * @return string
   */
  public function getPrecisionLevel()
  {
    return $this->precisionLevel;
  }

  /**
   * Returns the array representation of the object
   *
   * @return array
   */
  public function toArray()
  {
    return $this->_toArray();
    
  }

  /**
   * Returns the array representation of the object
   *
   * @return array
   * @final
   * @access protected
   */
  protected final function _toArray()
  {
    return array(
      'PrecisionLevel' => $this->getPrecisionLevel(),
      'Latitude'       => $this->getLatitude(),
      'Longitude'      => $this->getLongitude(),
      'Address'        => $this->getAddress(),
      'City'           => $this->getCity(),
      'State'          => $this->getState(),
      'Zip'            => $this->getZip(),
      'Country'        => $this->getCountry()
    );
  }
}