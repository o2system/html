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

namespace O2System\HTML\DOM\Lists;

// ------------------------------------------------------------------------
use O2System\HTML\Document;
use O2System\HTML\DOM\Element;

/**
 * Class Meta
 *
 * @package O2System\HTML\DOM\Lists
 */
class Asset extends \ArrayIterator
{
    public $element = 'link';

    public $ownerDocument;

    public function __construct ( Document $ownerDocument )
    {
        $this->ownerDocument =& $ownerDocument;
    }

    public function import ( Asset $assetNodes )
    {
        if( is_array( $assetNodes = $assetNodes->getArrayCopy() ) ) {
            foreach ( $assetNodes as $name => $value ) {
                $this->offsetSet( $name, $value );
            }
        }

        return $this;
    }

    public function offsetSet ( $name, $value )
    {
        if ( $value instanceof Element ) {
            parent::offsetSet( $name, $value );
        } else {
            $meta = $this->ownerDocument->createElement( $this->element );
            $meta->setAttribute( $name, $value );

            parent::offsetSet( $name, $meta );
        }
    }

    public function createElement ( $name, $value )
    {
        $meta = $this->ownerDocument->createElement( $this->element );
        $meta->setAttribute( $name, $value );

        parent::offsetSet( $name, $meta );

        return $meta;
    }
}