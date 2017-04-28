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

use O2System\Html\Document;
use O2System\Html\Dom\Element;

/**
 * Class Meta
 *
 * @package O2System\HTML\DOM\Lists
 */
class Meta extends \ArrayIterator
{
    public $ownerDocument;

    // ------------------------------------------------------------------------

    /**
     * Meta::__construct
     *
     * @param \O2System\Html\Document $ownerDocument
     */
    public function __construct( Document $ownerDocument )
    {
        $this->ownerDocument =& $ownerDocument;
    }

    // ------------------------------------------------------------------------

    /**
     * Meta::import
     *
     * @param \O2System\Html\Dom\Lists\Meta $metaNodes
     *
     * @return $this
     */
    public function import( Meta $metaNodes )
    {
        if ( is_array( $metaNodes = $metaNodes->getArrayCopy() ) ) {
            foreach ( $metaNodes as $name => $value ) {
                $this->offsetSet( $name, $value );
            }
        }

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Meta::offsetSet
     *
     * @param string $name
     * @param string $value
     */
    public function offsetSet( $name, $value )
    {
        if ( $value instanceof Element ) {
            parent::offsetSet( $name, $value );
        } else {
            $meta = $this->ownerDocument->createElement( 'meta' );
            $meta->setAttribute( $name, $value );

            parent::offsetSet( $name, $meta );
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Meta::createElement
     *
     * @param $name
     * @param $value
     *
     * @return \DOMElement
     */
    public function createElement( $name, $value )
    {
        $meta = $this->ownerDocument->createElement( 'meta' );
        $meta->setAttribute( $name, $value );

        parent::offsetSet( $name, $meta );

        return $meta;
    }
}