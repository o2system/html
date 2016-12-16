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
 * Class Book
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Book extends Website
{
    /**
     * Book::setUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl ( $url )
    {
        $this->url = rtrim( $url, '/' ) . '/ns/book#';

        if ( isset( $this->namespace ) ) {
            $headElement = $this->ownerDocument->getElementsByTagName( 'head' )->item( 0 );
            $headElement->setAttribute( 'prefix', $this->namespace . ': ' . $this->url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Book::setReleaseDate
     *
     * @param $datetime
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Book
     */
    public function setReleaseDate ( $datetime )
    {
        return $this->setMetadata( 'release_date', $datetime );
    }

    // ------------------------------------------------------------------------

    /**
     * Book::setMetadata
     *
     * @param string $property
     * @param string $content
     *
     * @return static
     */
    public function setMetadata ( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'book:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Book::setIsbn
     *
     * @param $isbn
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Book
     */
    public function setIsbn ( $isbn )
    {
        return $this->setMetadata( 'isbn', $isbn );
    }

    // ------------------------------------------------------------------------

    /**
     * Book::setTag
     *
     * @param $tag
     *
     * @return $this
     */
    public function setTag ( $tag )
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
     * Book::createAuthor
     *
     * @return \O2System\HTML\DOM\Meta\OpenGraph\Profile
     */
    public function createAuthor ()
    {
        return new Profile( $this->ownerDocument );
    }
}