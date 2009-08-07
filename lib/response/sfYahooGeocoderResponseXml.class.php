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
 * The sfYahooGeocoderResponseXml parses the XML response and hydrates its properties defined 
 * in abstract sfYahooGeocoderResponse class.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.response
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoderResponseXml extends sfYahooGeocoderResponse
{
  /**
   * Constructor
   *
   * Checks if the SimpleXML extension is loaded
   *
   * @throws sfYahooGeocoderException
   */
  public function __construct()
  {
    if (!extension_loaded('SimpleXML'))
    {
      throw new sfYahooGeocoderException('The current PHP configuration does not support the SimpleXML extension');
    }
  }

  /**
   * Hydrates the object from the http response content
   *
   * @throws sfYahooGeocoderException
   */
  protected function hydrate()
  {
    try
    {
      $xml = new SimpleXMLElement($this->getContent());

      if (!isset($xml->Result))
      {
        throw new sfYahooGeocoderException('No result found on the Yahoo! Geocoder service');
      }

      $this->setPrecisionLevel((string) $xml->Result['precision']);
      $this->setLatitude((double) $xml->Result->Latitude);
      $this->setLongitude((double) $xml->Result->Longitude);
      $this->setAddress((string) $xml->Result->Address);
      $this->setCity((string) $xml->Result->City);
      $this->setState((string) $xml->Result->State);
      $this->setZip((string) $xml->Result->Zip);
      $this->setCountry((string) $xml->Result->Country);
    }
    catch (Exception $e)
    {
      throw new sfYahooGeocoderException('Invalid XML response');
    }
  }
}