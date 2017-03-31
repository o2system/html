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
 * Class Article
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Article extends Website
{
    /**
     * Article::setUrl
     *
     * @param $url
     *
     * @return static
     */
    public function setUrl( $url )
    {
        $this->url = rtrim( $url, '/' ) . '/ns/article#';

        if ( isset( $this->namespace ) ) {
            $headElement = $this->ownerDocument->getElementsByTagName( 'head' )->item( 0 );
            $headElement->setAttribute( 'prefix', $this->namespace . ': ' . $this->url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Article::setPublishedTime
     *
     * @param $datetime
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Article
     */
    public function setPublishedTime( $datetime )
    {
        return $this->setMetadata( 'published_time', $datetime );
    }

    // ------------------------------------------------------------------------

    /**
     * Article::setMetadata
     *
     * @param string $property Open graph meta property.
     * @param string $content  Open graph meta content.
     *
     * @return static
     */
    public function setMetadata( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'article:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Article::setModifiedTime
     *
     * @param $datetime
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Article
     */
    public function setModifiedTime( $datetime )
    {
        return $this->setMetadata( 'modified_time', $datetime );
    }

    // ------------------------------------------------------------------------

    /**
     * Article::setExpirationTime
     *
     * @param $datetime
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Article
     */
    public function setExpirationTime( $datetime )
    {
        return $this->setMetadata( 'expiration_time', $datetime );
    }

    // ------------------------------------------------------------------------

    /**
     * Article::section
     *
     * @param $section
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Article
     */
    public function section( $section )
    {
        return $this->setMetadata( 'section', $section );
    }

    // ------------------------------------------------------------------------

    /**
     * Article::setTag
     *
     * @param $tag
     *
     * @return $this
     */
    public function setTag( $tag )
    {
        $meta = $this->ownerDocument->createElement( 'meta' );

        // Set Property
        $meta->setAttribute( 'property', $offset = 'article:tag' );

        // Set Content
        $meta->setAttribute( 'content', $tag );

        $this->ownerDocument->metaOGPNodes->offsetSet( $offset . ':' . md5( $tag ), $meta );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Article::createAuthor
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Profile
     */
    public function createAuthor()
    {
        return new Profile( $this->ownerDocument );
    }
}