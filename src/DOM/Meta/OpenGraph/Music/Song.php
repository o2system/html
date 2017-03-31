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

namespace O2System\HTML\DOM\Meta\OpenGraph\Music;

// ------------------------------------------------------------------------

use O2System\HTML\Document;
use O2System\HTML\DOM\Meta\OpenGraph\Audio;

/**
 * Class Song
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph\Music
 */
class Song extends Audio
{
    /**
     * Song::__construct
     *
     * @param \O2System\HTML\Document $document
     *
     * @return Song
     */
    public function __construct( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'music.song' );
    }

    // ------------------------------------------------------------------------

    /**
     * Song::setUrl
     *
     * @param $url
     *
     * @return static
     */
    public function setUrl( $url )
    {
        if ( strpos( $url, 'http' ) !== false ) {
            parent::setMetadata( 'url', $url );
            $this->ownerDocument->metaOGPNodes->offsetSet( 'music:song', $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Song::setDuration
     *
     * @param $duration
     *
     * @return static
     */
    public function setDuration( $duration )
    {
        if ( is_int( $duration ) ) {
            $this->setMetadata( 'duration', $duration );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Song::setMetadata
     *
     * @param $property
     * @param $content
     *
     * @return static
     */
    public function setMetadata( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'music:song:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Song::setMusician
     *
     * @param $musician
     *
     * @return static
     */
    public function setMusician( $musician )
    {
        $meta = $this->ownerDocument->createElement( 'meta' );

        // Set Property
        $meta->setAttribute( 'property', $offset = 'music:musician' );

        // Set Content
        $meta->setAttribute( 'content', $musician );

        $this->ownerDocument->metaOGPNodes->offsetSet( $offset . ':' . md5( $musician ), $meta );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Song::setDisc
     *
     * @param $discNumber
     *
     * @return static
     */
    public function setDisc( $discNumber )
    {
        if ( is_numeric( $discNumber ) ) {
            $this->setMetadata( 'disc', $discNumber );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Song::setTrack
     *
     * @param $trackNumber
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
     * Song::setReleaseDate
     *
     * @param $date
     *
     * @return static
     */
    public function setReleaseDate( $date )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'music:release_date', $date );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Song::createAlbum
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Music\Album
     */
    public function createAlbum()
    {
        return new Album( $this->ownerDocument );
    }
}