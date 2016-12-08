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

use O2System\HTML\Document;

/**
 * Class Website
 *
 * @package O2System\HTML\DOM\Meta\OpenGraph
 */
class Website extends Basic
{
    /**
     * Website URL
     *
     * @var string
     */
    public $url;

    /**
     * Website Namespace
     *
     * @var string
     */
    public $namespace;

    // ------------------------------------------------------------------------

    /**
     * Website::__construct
     *
     * @param \O2System\HTML\Document $document
     *
     * @return Website
     */
    public function __construct ( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'website' );
    }

    // ------------------------------------------------------------------------

    /**
     * Website::setName
     *
     * @param string $name
     *
     * @return static
     */
    public function setName ( $name )
    {
        $this->setMetadata( 'site_name', $name );

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Website::setUrl
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl ( $url )
    {
        $this->url = rtrim( $url, '/' ) . '/ns#';

        if ( isset( $this->namespace ) ) {
            $headElement = $this->ownerDocument->getElementsByTagName( 'head' )->item( 0 );
            $headElement->setAttribute( 'prefix', $this->namespace . ': ' . $this->url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Website::setNamespace
     *
     * @param string $namespace
     *
     * @return static
     */
    public function setNamespace ( $namespace )
    {
        $this->namespace = underscore( $namespace );

        if ( isset( $this->url ) ) {
            $headElement = $this->ownerDocument->getElementsByTagName( 'head' )->item( 0 );
            $headElement->setAttribute( 'prefix', $this->namespace . ': ' . $this->url );
        }

        return $this;
    }
}