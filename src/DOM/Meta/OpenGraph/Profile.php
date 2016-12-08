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


use O2System\HTML\Document;

class Profile extends Basic
{
    /**
     * Profile Website URL
     *
     * @var string
     */
    public $url;

    /**
     * Profile Website Namespace
     *
     * @var string
     */
    public $namespace;

    // ------------------------------------------------------------------------

    /**
     * Profile::__construct
     *
     * @param \O2System\HTML\Document $document
     *
     * @return Profile
     */
    public function __construct ( Document $document )
    {
        parent::__construct( $document );

        $this->setType( 'profile' );
    }

    // ------------------------------------------------------------------------

    public function setSiteName ( $name )
    {
        $this->setMetadata( 'site_name', $name );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setMetadata ( $property, $content )
    {
        $this->ownerDocument->metaOGPNodes->offsetSet( 'profile:' . $property, $content );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setUrl ( $url )
    {
        $this->url = rtrim( $url, '/' ) . '/ns/profile#';

        if ( isset( $this->namespace ) ) {
            $headElement = $this->ownerDocument->getElementsByTagName( 'head' )->item( 0 );
            $headElement->setAttribute( 'prefix', $this->namespace . ': ' . $this->url );
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setName ( $name )
    {
        $xName = explode( ' ', $name );
        $firstName = $xName[ 0 ];

        array_shift( $xName );

        $lastName = implode( ' ', $xName );

        $this->setMetadata( 'first_name', $firstName );
        $this->setMetadata( 'last_name', $lastName );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setUsername ( $username )
    {
        $this->setMetadata( 'username', $username );

        return $this;
    }

    // ------------------------------------------------------------------------

    public function setGender ( $gender )
    {
        $gender = strtolower( $gender );

        if ( in_array( $gender, [ 'male', 'female' ] ) ) {
            $this->setMetadata( 'gender', $gender );
        }

        return $this;
    }
}