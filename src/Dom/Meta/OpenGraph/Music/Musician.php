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

use O2System\Html\Dom\Meta\OpenGraph\Audio;
use O2System\Html\Dom\Meta\OpenGraph\Image;
use O2System\Html\Dom\Meta\OpenGraph\Profile;

/**
 * Class Musician
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph\Music
 */
class Musician extends Profile
{
    /**
     * Musician::createImage
     *
     * @return \O2System\Html\Dom\Meta\OpenGraph\Image
     */
    public function createImage()
    {
        return new Image( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Musician::createAudio
     *
     * @return \O2System\Html\Dom\Meta\OpenGraph\Audio
     */
    public function createAudio()
    {
        return new Audio( $this->ownerDocument );
    }
}