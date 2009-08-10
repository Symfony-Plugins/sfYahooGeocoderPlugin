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
 * The sfYahooGeocoderParser manages the creation of sfYahooGeocoderResponseCollection objects.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.parser
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
abstract class sfYahooGeocoderParser
{
  /**
   * The http response content
   *
   * @var string
   */
  protected $content = '';

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
   * Parses and returns the sfYahooGeocoderResponseCollection object after response parsing
   *
   * @param string $content The http response content
   *
   * @return sfYahooGeocoderResponseCollection
   * @throws sfYahooGeocoderException
   */
  public function parse($content)
  {
    $this->content = $content;

    return $this->doParse();
  }

  /**
   * Parses and returns the sfYahooGeocoderResponseCollection object
   *
   * @return sfYahooGeocoderResponseCollection
   * @throws sfYahooGeocoderException
   * @abstract
   */
  abstract protected function doParse();
}