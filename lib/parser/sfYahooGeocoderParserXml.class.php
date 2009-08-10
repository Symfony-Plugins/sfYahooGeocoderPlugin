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
 * The sfYahooGeocoderParserPhp parses a XML response and creates the sfYahooGeocoderResponseCollection object to return.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.parser
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoderParserXml extends sfYahooGeocoderParser
{
  /**
   * Returns the collection of sfYahooGeocoderResponseXml objects
   *
   * @return sfYahooGeocoderResponseCollection
   * @throws sfYahooGeocoderException
   */
  protected function doParse()
  {
    try
    {
      $xml = new SimpleXMLElement($this->content);

      if (!isset($xml->Result))
      {
        throw new sfYahooGeocoderException('No result found on the Yahoo! Geocoder service');
      }

      $objects = array();
      foreach ($xml->Result as $result)
      {
        $object = new sfYahooGeocoderResponseXml();
        $object->hydrateFromSimpleXmlElement($result);
        
        $objects[] = $object;
      }

      return new sfYahooGeocoderResponseCollection($objects);
    }
    catch (Exception $e)
    {
      throw new sfYahooGeocoderException(sprintf('Unable to get results from the Yahoo! Geocoding web service : %s', $e->getMessage()));
    }
  }
}