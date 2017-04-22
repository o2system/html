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

namespace O2System\Html\Dom\Meta;

// ------------------------------------------------------------------------
use O2System\Core\Patterns\CollectorPatternClass;

/**
 * O2System Meta Opengraph
 *
 * This class is meta generator for The OpenGraph Protocol
 *
 * @see     http://ogp.me
 *
 * @package O2System\Core\HTML\Meta
 */
class OpenGraph extends CollectorPatternClass
{
    /**
     * Website Namespace
     *
     * @var string
     */
    const WEBSITE = 'website';

    /**
     * Profile Namespace
     *
     * @var string
     */
    const PROFILE = 'profile';

    /**
     * Music Namespace
     *
     * @var string
     */
    const MUSIC = 'music';

    /**
     * Video Namespace
     *
     * @var string
     */
    const VIDEO = 'video';

    /**
     * Book Namespace
     *
     * @var string
     */
    const BOOK = 'book';

    /**
     * Article Namespace
     *
     * @var string
     */
    const ARTICLE = 'article';

    /**
     * Product Namespace
     *
     * @var string
     */
    const PRODUCT = 'product';

    /**
     * Service Namespace
     *
     * @var string
     */
    const SERVICE = 'service';

    /**
     * OpenGraph Namespace
     *
     * @var string
     */
    protected $namespace;

    // ------------------------------------------------------------------------

    /**
     * Set OpenGraph Locale
     *
     * @param string $locale
     * @param array  $alternates
     */
    public function setLocale( $locale, array $alternates = [] )
    {
        $this->collections[ 'og:locale' ] = $locale;

        if ( count( $alternates ) > 0 ) {
            foreach ( $alternates as $alternate ) {
                $this->collections[ 'og:locale:alternate' ][] = $alternate;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Set OpenGraph Title
     *
     * @param string $title
     */
    public function setTitle( $title )
    {
        $this->collections[ 'og:title' ] = $title;
    }

    // ------------------------------------------------------------------------

    /**
     * Set OpenGraph URL
     *
     * @param string $url
     */
    public function setUrl( $url )
    {
        $this->collections[ 'og:url' ] = $url;
    }

    // ------------------------------------------------------------------------

    /**
     * Set OpenGraph Site Name
     *
     * @param string $siteName
     */
    public function setSiteName( $siteName )
    {
        $this->collections[ 'og:site_name' ] = $siteName;
    }

    // ------------------------------------------------------------------------

    /**
     * Set OpenGraph Description
     *
     * @param string $description
     */
    public function setDescription( $description )
    {
        $this->collections[ 'og:description' ] = $description;
    }

    // ------------------------------------------------------------------------

    /**
     * Set Image
     *
     * Set image namespace properties
     *
     * @param string $image
     * @param array  $properties
     */
    public function setImage( $image, array $properties = [] )
    {
        $this->collections[ 'og:image' ] = $image;

        if ( count( $properties ) > 0 ) {
            foreach ( $properties as $key => $value ) {
                $this->collections[ 'og:image:' . $key ][] = $value;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Set Audio
     *
     * Set audio namespace properties
     *
     * @param string $audio
     * @param array  $properties
     */
    public function setAudio( $audio, array $properties = [] )
    {
        $this->collections[ 'og:audio' ] = $audio;

        if ( count( $properties ) > 0 ) {
            foreach ( $properties as $key => $value ) {
                $this->collections[ 'og:audio:' . $key ][] = $value;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Set Music
     *
     * Set music namespace properties
     *
     * @param string $music
     * @param array  $properties
     */
    public function setMusic( $music, array $properties = [] )
    {
        $this->setNamespace( self::MUSIC );
        $this->collections[ 'og:music' ] = $music;

        if ( count( $properties ) > 0 ) {
            foreach ( $properties as $key => $value ) {
                $this->collections[ 'og:audio:' . $key ][] = $value;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Set Namespace
     *
     * Set OpenGraph Namespace.
     *
     * @param string $namespace
     */
    public function setNamespace( $namespace )
    {
        $this->namespace = strtolower( $namespace );

        if ( $this->namespace === 'website' ) {
            $this->setType( 'website' );
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Set OpenGraph Type
     *
     * @param string $type
     */
    public function setType( $type )
    {
        $this->collections[ 'og:type' ] = $type;
    }

    // ------------------------------------------------------------------------

    /**
     * Set Video
     *
     * Set video namespace properties
     *
     * @param string $video
     * @param array  $properties
     */
    public function setVideo( $video, array $properties = [] )
    {
        $this->setNamespace( self::VIDEO );
        $this->collections[ 'og:video' ] = $video;

        if ( count( $properties ) > 0 ) {
            foreach ( $properties as $key => $value ) {
                $this->collections[ 'og:video:' . $key ][] = $value;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Magic Method __call
     *
     * Modified __call Method to perform OpenGraph class Setters
     *
     * @param string $method
     * @param array  $args
     */
    public function __call( $method, array $args = [] )
    {
        if ( method_exists( $this, $method ) ) {
            call_user_func_array( [ $this, $method ], $args );
        } elseif ( strrpos( $method, 'Properties' ) !== false ) {
            $object_key = str_replace( [ 'set', 'Properties' ], '', $method );
            $object_key = underscore( $object_key );

            list( $object_properties ) = $args;

            if ( isset( $object_properties ) AND is_array( $object_properties ) ) {
                foreach ( $object_properties as $key => $value ) {
                    if ( is_array( $value ) ) {
                        foreach ( $value as $item ) {
                            $this->collections[ 'og:' . $object_key . ':' . $key ][] = $item;
                        }
                    } else {
                        $this->collections[ 'og:' . $object_key . ':' . $key ] = $value;
                    }
                }
            }
        } elseif ( strpos( $method, 'set' ) !== false ) {
            $object_key = str_replace( 'set', '', $method );
            $object_key = underscore( $object_key );

            @list( $object_value, $object_properties ) = $args;

            $this->collections[ 'og:' . $object_key ] = $object_value;

            if ( isset( $object_properties ) AND is_array( $object_properties ) ) {
                foreach ( $object_properties as $key => $value ) {
                    $key = underscore( $key );

                    if ( is_array( $value ) ) {
                        foreach ( $value as $item ) {
                            $this->collections[ 'og:' . $object_key . ':' . $key ][] = $item;
                        }
                    } else {
                        $this->collections[ 'og:' . $object_key . ':' . $key ] = $value;
                    }
                }
            }
        }
    }

    public function setFacebookAppId( $facebook_app_id )
    {
        $this->collections[ 'fb:app_id' ] = $facebook_app_id;
    }

    // ------------------------------------------------------------------------

    /**
     * Get HTML Open Tag
     *
     * @param null $currentHTMLTagString
     *
     * @return string
     */
    public function getHtmlOpenTag( $currentHTMLTagString = null )
    {
        $attributes = $this->getHtmlOpenTagAttributes();

        if ( isset( $currentHTMLTagString ) ) {
            $previous_attributes = parse_attributes( $currentHTMLTagString );

            $attributes = array_merge( $previous_attributes, $attributes );
        }

        return '<html' . _stringify_attributes( $attributes ) . '>';
    }

    // ------------------------------------------------------------------------

    /**
     * Get HTML Open Tag Attributes
     *
     * @return array
     */
    public function getHtmlOpenTagAttributes()
    {
        return [
            'xmlns'    => 'http://www.w3.org/1999/xhtml',
            'xmlns:og' => 'http://ogp.me/ns#',
            'xmlns:fb' => 'https://www.facebook.com/2008/fbml',
        ];
    }

    // ------------------------------------------------------------------------

    /**
     * Get Head Open Tag
     *
     * @param null|string $currentHeadTagString
     *
     * @return string
     */
    public function getHeadOpenTag( $currentHeadTagString = null )
    {
        $attributes = $this->getHeadOpenTagAttributes();

        if ( isset( $currentHeadTagString ) ) {
            $currentAttributes = parse_attributes( $currentHeadTagString );

            $attributes = array_merge( $currentAttributes, $attributes );
        }

        return '<head' . _stringify_attributes( $attributes ) . '>';
    }

    // ------------------------------------------------------------------------

    /**
     * Get Head Open Tag Attributes
     *
     * @return array
     */
    public function getHeadOpenTagAttributes()
    {
        if ( empty( $this->namespace ) ) {
            return [
                'prefix' => 'og: http://ogp.me/ns#',
            ];
        } else {
            return [
                'prefix' => $this->namespace . ': http://ogp.me/' . $this->namespace . '#',
            ];
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Magic Method __toString
     *
     * Perform render OpenGraph Class into String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    // ------------------------------------------------------------------------

    /**
     * Render
     *
     * @access public
     *
     * @return string
     */
    public function render()
    {
        if ( ! empty( $this->collections ) ) {
            return implode( PHP_EOL, $this->collections );
        }

        return '';
    }
}