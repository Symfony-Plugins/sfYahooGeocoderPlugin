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
   * Hydrates the object from a SimpleXmlElement object
   *
   * @throws sfYahooGeocoderException
   */
  public function hydrateFromSimpleXmlElement(SimpleXmlElement $xml)
  {
    if (isset($xml['precision']))
    {
      $this->setPrecisionLevel($xml['precision']);  
    }

    if (isset($xml->Latitude))
    {
      $this->setLatitude($xml->Latitude);
    }

    if (isset($xml->Longitude))
    {
      $this->setLongitude($xml->Longitude);
    }

    if (isset($xml->Address))
    {
      $this->setAddress($xml->Address);
    }

    if (isset($xml->City))
    {
      $this->setCity($xml->City);
    }

    if (isset($xml->State))
    {
      $this->setState($xml->State);
    }

    if (isset($xml->Zip))
    {
      $this->setZip($xml->Zip);
    }

    if (isset($xml->Country))
    {
      $this->setCountry($xml->Country); 
    }
  }
}