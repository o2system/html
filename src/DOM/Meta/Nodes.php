<?php
/**
 * git
 *
 * @author      Steeve Andrian Salim
 * @created     23/09/2016 20:11
 * @copyright   Copyright (c) 2016 Steeve Andrian Salim
 */

namespace O2System\HTML\DOM\Meta;


use O2System\HTML\Tag;
use O2System\Psr\Patterns\CollectorPatternClass;

class Nodes extends CollectorPatternClass
{
    public function merge( array $elements )
    {
        foreach ( $elements as $name => $content ) {
            $this->push( $name, $content );
        }
    }

    /**
     * Add Meta
     *
     * Add meta to collections
     *
     * @param      $name
     * @param null $content
     *
     * @return $this
     */
    public function push( $name, $content = null )
    {
        if ( $name === 'http-equiv' ) {
            $value = key( $content );

            $this->__set(
                'http_equiv_' . $value,
                new Tag(
                    'meta', [
                        'http-equiv' => $value,
                        'content'    => $content[ $value ],
                    ]
                )
            );
        } elseif ( $name === 'property' ) {
            $value = key( $content );

            $this->__set(
                'property_' . $value,
                new Tag(
                    'meta', [
                        'property' => $value,
                        'content'  => $content[ $value ],
                    ]
                )
            );
        } else {
            $this->__set(
                underscore( $name ),
                new Tag(
                    'meta', [
                        'name'    => $name,
                        'content' => ( is_array( $content ) ? implode( ', ', $content ) : $content ),
                    ]
                )
            );
        }
    }

    public function replace( $name, $content )
    {
        $this->__unset( $name );

        $this->push( $name, $content );
    }

    // ------------------------------------------------------------------------
}