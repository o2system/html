<?php
/**
 * This file is part of the O2System PHP Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */
// ------------------------------------------------------------------------

namespace O2System\HTML\DOM\Meta\OpenGraph;

// ------------------------------------------------------------------------

use O2System\HTML\Document;

/**
 * Class Basic
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Basic
{
    /**
     * Meta Open Graph Owner Document
     *
     * @var \O2System\HTML\Document
     */
    public $ownerDocument;

    // ------------------------------------------------------------------------

    /**
     * Basic::__construct
     *
     * @param \O2System\HTML\Document $document
     *
     * @return Basic
     */
    public function __construct ( Document $document )
    {
        $htmlElement = $document->getElementsByTagName( 'html' )->item( 0 );
        $htmlElement->setAttribute( 'prefix', 'og: http://ogp.me/ns#' );

        $this->ownerDocument =& $document;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setAppId
     *
     * @param string $appID
     *
     * @return static
     */
    public function setAppId ( $appID )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'fb:app_id', $appID );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setMetadata
     *
     * @param string $property
     * @param string $content
     *
     * @return static
     */
    public function setMetadata ( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'og:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setType
     *
     * @param string $type
     *
     * @return static
     */
    public function setType ( $type )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'og:type', $type );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setTitle
     *
     * @param string $title
     *
     * @return static
     */
    public function setTitle ( $title )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'og:title', $title );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setDescription
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription ( $description )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'og:description', $description );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setDeterminer
     *
     * @param $determiner
     *
     * @return static
     */
    public function setDeterminer ( $determiner )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'og:determiner', $determiner );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setLocale
     *
     * @param string      $lang
     * @param string|null $territory
     *
     * @return static
     */
    public function setLocale ( $lang, $territory = null )
    {
        $lang = strtolower( $lang );

        $this->ownerDocument->metaOGPNodes->offsetSet(
            'og:locale',
            ( isset( $territory ) ? $lang . '_' . strtoupper( $territory ) : $lang )
        );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Basic::setLocaleAlternate
     *
     * @param string      $lang
     * @param string|null $territory
     *
     * @return static
     */
    public function setLocaleAlternate ( $lang, $territory = null )
    {
        $lang = strtolower( $lang );

        $this->ownerDocument->metaOGPNodes->offsetSet(
            'og:locale:alternate',
            ( isset( $territory ) ? $lang . '_' . strtoupper( $territory ) : $lang )
        );

        return $this;
    }
}