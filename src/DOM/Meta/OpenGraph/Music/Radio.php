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
use O2System\HTML\DOM\Meta\OpenGraph\Basic;
use O2System\HTML\DOM\Meta\OpenGraph\Image;

/**
 * Class Radio
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph\Music
 */
class Radio extends Basic
{
    /**
     * Radio::__construct
     *
     * @param \O2System\HTML\Document $document
     */
    public function __construct( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'music.radio_station' );
    }

    // ------------------------------------------------------------------------

    /**
     * Radio::setSiteName
     *
     * @param string $name
     *
     * @return static
     */
    public function setSiteName( $name )
    {
        $this->setMetadata( 'site_name', $name );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Radio::setUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl( $url )
    {
        if ( strpos( $url, 'http' ) !== false ) {
            parent::setMetadata( 'url', $url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Radio::createImage
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Image
     */
    public function createImage()
    {
        return new Image( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Radio::createAudio
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Audio
     */
    public function createAudio()
    {
        return new Audio( $this->ownerDocument );
    }
}