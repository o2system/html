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

namespace O2System\Html\Dom\Meta\OpenGraph\Video;

// ------------------------------------------------------------------------

use O2System\Html\Document;
use O2System\Html\Dom\Meta\OpenGraph\Video;

/**
 * Class Movie
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph\Video
 */
class Movie extends Video
{
    /**
     * Movie::__construct
     *
     * @param \O2System\Html\Document $document
     *
     * @return Movie
     */
    public function __construct( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'video.movie' );
    }

    // ------------------------------------------------------------------------

    /**
     * Movie::createActor
     *
     * @return \O2System\Html\Dom\Meta\OpenGraph\Video\Actor
     */
    public function createActor()
    {
        return new Actor( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Movie::createWriter
     *
     * @return \O2System\Html\Dom\Meta\OpenGraph\Video\Writer
     */
    public function createWriter()
    {
        return new Writer( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Movie::createDirector
     *
     * @return \O2System\Html\Dom\Meta\OpenGraph\Video\Director
     */
    public function createDirector()
    {
        return new Director( $this->ownerDocument );
    }
}