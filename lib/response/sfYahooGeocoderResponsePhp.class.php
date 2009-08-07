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
 * The sfYahooGeocoderResponsePhp unserialises the response php array and hydrates its properties defined 
 * in abstract sfYahooGeocoderResponse class.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.response
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoderResponsePhp extends sfYahooGeocoderResponse
{
  /**
   * Hydrates the object from the http response content
   *
   * @throws sfYahooGeocoderException
   */
  protected function hydrate()
  {
    $result = unserialize($this->getContent());

    if (!count($result) || !isset($result['ResultSet']['Result']))
    {
      throw new sfYahooGeocoderException('No result found on the Yahoo! Geocoder service');
    }

    $result = $result['ResultSet']['Result'];

    $this->setPrecisionLevel((string) $result['precision']);
    $this->setLatitude((double) $result['Latitude']);
    $this->setLongitude((double) $result['Longitude']);
    $this->setAddress((string) $result['Address']);
    $this->setCity((string) $result['City']);
    $this->setState((string) $result['State']);
    $this->setZip((string) $result['Zip']);
    $this->setCountry((string) $result['Country']);
  }
}