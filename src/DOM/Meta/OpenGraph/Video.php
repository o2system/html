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

/**
 * Class Video
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Video extends Basic
{
    public function setUrl ( $url )
    {
        if ( strpos( $url, 'http://' ) !== false ) {
            parent::setMetadata( 'video', $url );
        } elseif ( strpos( $url, 'https://' ) !== false ) {
            parent::setMetadata( 'video', str_replace( 'https://', 'http://', $url ) );
            $this->setSecureUrl( $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setSecureUrl ( $url )
    {
        if ( strpos( $url, 'https://' ) !== false ) {
            $this->setMetadata( 'secure_url', $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setMetadata ( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'video:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setMime ( $mime )
    {
        $this->setMetadata( 'type', $mime );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setSize ( $width, $height )
    {
        if ( is_numeric( $width ) AND is_numeric( $height ) ) {
            $this->setMetadata( 'width', $width );
            $this->setMetadata( 'height', $height );
        }
    }

    // ------------------------------------------------------------------------

    public function setDuration ( $duration )
    {
        if ( is_int( $duration ) ) {
            $this->setMetadata( 'duration', $duration );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setReleaseDate ( $date )
    {
        $this->setMetadata( 'release_date', $date );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setTag ( $tag )
    {
        $meta = $this->ownerDocument->createElement( 'meta' );

        // Set Property
        $meta->setAttribute( 'property', $offset = 'video:tag' );

        // Set Content
        $meta->setAttribute( 'content', $tag );

        $this->ownerDocument->metaOGPNodes->offsetSet( $offset . ':' . md5( $tag ), $meta );

        return $this;
    }
}