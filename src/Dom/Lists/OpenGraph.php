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

namespace O2System\Html\Dom\Lists;

// ------------------------------------------------------------------------

use O2System\Html\Dom\Element;
use O2System\Html\Dom\Meta\OpenGraph\Article;
use O2System\Html\Dom\Meta\OpenGraph\Audio;
use O2System\Html\Dom\Meta\OpenGraph\Basic;
use O2System\Html\Dom\Meta\OpenGraph\Book;
use O2System\Html\Dom\Meta\OpenGraph\Image;
use O2System\Html\Dom\Meta\OpenGraph\Profile;
use O2System\Html\Dom\Meta\OpenGraph\Video;
use O2System\Html\Dom\Meta\OpenGraph\Website;

/**
 * Class Meta
 *
 * @package O2System\HTML\DOM\Lists
 */
class OpenGraph extends Meta
{
    public function createElement( $property, $content )
    {
        $meta = $this->ownerDocument->createElement( 'meta' );

        // Set Property
        $meta->setAttribute( 'property', $offset = 'og:' . $property );

        // Set Content
        $meta->setAttribute( 'content', $content );

        parent::offsetSet( $offset, $meta );

        return $meta;
    }

    // ------------------------------------------------------------------------

    public function createBasicElement()
    {
        return new Basic( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createWebsiteElement()
    {
        return new Website( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createImageElement()
    {
        return new Image( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createVideoElement()
    {
        return new Video( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createAudioElement()
    {
        return new Audio( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createBookElement()
    {
        return new Book( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createArticleElement()
    {
        return new Article( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function createProfileElement()
    {
        return new Profile( $this->ownerDocument );
    }

    // ------------------------------------------------------------------------

    public function setMetadata( $property, $content )
    {
        $meta = $this->ownerDocument->createElement( 'meta' );

        // Set Property
        $meta->setAttribute( 'property', $offset = 'og:' . $property );

        // Set Content
        $meta->setAttribute( 'content', $content );

        parent::offsetSet( $offset, $meta );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function offsetSet( $property, $content )
    {
        if ( $content instanceof Element ) {
            parent::offsetSet( $property, $content );
        } else {
            $meta = $this->ownerDocument->createElement( 'meta' );

            $meta->setAttribute( 'property', $property );

            // Set Content
            $meta->setAttribute( 'content', $content );

            parent::offsetSet( $property, $meta );
        }
    }
}