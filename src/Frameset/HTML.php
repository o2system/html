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

namespace O2System\HTML\Frameset;

// ------------------------------------------------------------------------

use O2System\HTML\Document;

/**
 * Class HTML
 *
 * @package O2System\HTML\Frameset
 */
class HTML extends Document
{
    /**
     * Document::loadHTMLTemplate
     *
     * Load HTML template from a file.
     *
     * @return void
     */
    protected function loadHTMLTemplate ()
    {
        parent::loadHTML( file_get_contents( __DIR__ . '/Template/HTML.html' ) );
    }
}