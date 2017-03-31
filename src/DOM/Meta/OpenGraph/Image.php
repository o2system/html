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
 * Class Image
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Image extends Basic
{
    /**
     * Image::setUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl( $url )
    {
        if ( strpos( $url, 'http://' ) !== false ) {
            parent::setMetadata( 'image', $url );
        } elseif ( strpos( $url, 'https://' ) !== false ) {
            parent::setMetadata( 'image', str_replace( 'https://', 'http://', $url ) );
            $this->setSecureUrl( $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Image::setSecureUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setSecureUrl( $url )
    {
        if ( strpos( $url, 'https://' ) !== false ) {
            $this->setMetadata( 'secure_url', $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Image::setMetadata
     *
     * @param string $property
     * @param string $content
     *
     * @return static
     */
    public function setMetadata( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'og:image:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Image::setMime
     *
     * @param string $mime Image mime type.
     *
     * @return static
     */
    public function setMime( $mime )
    {
        if ( strpos( $mime, 'image/' ) !== false ) {
            $this->setMetadata( 'type', $mime );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Image::setSize
     *
     * @param int $width  Image width
     * @param int $height Image Height
     *
     * @return static
     */
    public function setSize( $width, $height )
    {
        if ( is_numeric( $width ) AND is_numeric( $height ) ) {
            $this->setMetadata( 'width', $width );
            $this->setMetadata( 'height', $height );
        }

        return $this;
    }
}