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

namespace O2System\HTML\DOM\Meta\OpenGraph\Video;

// ------------------------------------------------------------------------

use O2System\HTML\Document;
use O2System\HTML\DOM\Meta\OpenGraph\Video;

/**
 * Class Episode
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph\Video
 */
class Episode extends Video
{
    /**
     * Episode::__construct
     *
     * @param \O2System\HTML\Document $document
     *
     * @return Episode
     */
    public function __construct( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'video.episode' );
    }

    // ------------------------------------------------------------------------

    /**
     * Episode::createActor
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Video\Actor
     */
    public function createActor()
    {
        return new Actor( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Document::createWriter
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Video\Writer
     */
    public function createWriter()
    {
        return new Writer( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Document::createDirector
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Video\Director
     */
    public function createDirector()
    {
        return new Director( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    /**
     * Document::createTVShow
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Video\TVShow
     */
    public function createTVShow()
    {
        return new TVShow( $this->ownerDocument );
    }
}