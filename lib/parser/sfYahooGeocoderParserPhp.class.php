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
 * The sfYahooGeocoderParserPhp parses a PHP response and creates the sfYahooGeocoderResponseCollection object to return.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.parser
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoderParserPhp extends sfYahooGeocoderParser
{
  /**
   * Returns the collection of sfYahooGeocoderResponsePhp objects
   *
   * @return sfYahooGeocoderResponseCollection
   * @throws sfYahooGeocoderException
   */
  protected function doParse()
  {
    $results = unserialize($this->content);
    
    if (!count($results) || !isset($results['ResultSet']['Result']))
    {
      throw new sfYahooGeocoderException('No result found on the Yahoo! Geocoder service');
    }

    $results = $results['ResultSet']['Result'];

    if (!isset($results[0]))
    {
      return new sfYahooGeocoderResponseCollection(array($this->createGeocodedResult($results)));
    }

    $objects = array();
    foreach ($results as $result)
    {
      $objects[] = $this->createGeocodedResult($result);
    }

    return new sfYahooGeocoderResponseCollection($objects);
  }

  /**
   * Returns a new hydrated sfYahooGeocoderResponsePhp object 
   *
   * @param array $geoResult
   *
   * @return sfYahooGeocoderResponsePhp
   */
  public function createGeocodedResult(array $geoResult)
  {
    $object = new sfYahooGeocoderResponsePhp();
    $object->fromArray($geoResult);

    return $object;
  }
}