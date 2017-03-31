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

namespace O2System\Html\Dom\Meta\OpenGraph;

// ------------------------------------------------------------------------

/**
 * Class Audio
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Audio extends Basic
{
    /**
     * Audio::setUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl( $url )
    {
        if ( strpos( $url, 'http://' ) !== false ) {
            parent::setMetadata( 'audio', $url );
        } elseif ( strpos( $url, 'https://' ) !== false ) {
            parent::setMetadata( 'audio', str_replace( 'https://', 'http://', $url ) );
            $this->setSecureUrl( $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Audio::setSecureUrl
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
     * Audio::setMetadata
     *
     * @param string $property
     * @param string $content
     *
     * @return static
     */
    public function setMetadata( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'audio:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Audio::setMime
     *
     * @param string $mime
     *
     * @return static
     */
    public function setMime( $mime )
    {
        if ( strpos( $mime, 'audio/' ) !== false ) {
            $this->setMetadata( 'type', $mime );
        }

        return $this;
    }
}