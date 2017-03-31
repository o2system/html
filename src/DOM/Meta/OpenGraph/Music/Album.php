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

namespace O2System\Html\Dom\Meta\OpenGraph\Music;

// ------------------------------------------------------------------------

use O2System\Html\Document;
use O2System\Html\Dom\Meta\OpenGraph\Basic;

/**
 * Class Album
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph\Music
 */
class Album extends Basic
{
    /**
     * Album::__construct
     *
     * @param \O2System\Html\Document $document
     */
    public function __construct( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'music.album' );
    }

    // ------------------------------------------------------------------------

    /**
     * Album::setUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl( $url )
    {
        if ( strpos( $url, 'http' ) !== false ) {
            parent::setMetadata( 'url', $url );
            $this->ownerDocument->metaOGPNodes->offsetSet( 'music:album', $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Album::setTrack
     *
     * @param int $trackNumber
     *
     * @return static
     */
    public function setTrack( $trackNumber )
    {
        if ( is_numeric( $trackNumber ) ) {
            $this->setMetadata( 'track', $trackNumber );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Album::setMetadata
     *
     * @param string $property
     * @param string $content
     *
     * @return static
     */
    public function setMetadata( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'music:album:' . $property, $content );

        return $this;
    }
}