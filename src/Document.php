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

namespace O2System\HTML;

// ------------------------------------------------------------------------

use O2System\HTML\DOM\Beautifier;
use O2System\HTML\DOM\Element;
use O2System\HTML\DOM\Lists\Meta;
use O2System\HTML\DOM\Lists\Nodes;
use O2System\HTML\DOM\Lists\OpenGraph;
use O2System\HTML\DOM\Script;
use O2System\HTML\DOM\Style;
use O2System\HTML\DOM\XPath;

/**
 * Class Document
 *
 * @package O2System\HTML
 */
class Document extends \DOMDocument
{
    /**
     * Document Meta Nodes
     *
     * @var \O2System\HTML\DOM\Lists\Meta
     */
    public $metaNodes;

    /**
     * Document Meta Open Graph Nodes
     *
     * @var \O2System\HTML\DOM\Lists\OpenGraph
     */
    public $metaOGPNodes;

    /**
     * Document Link Nodes
     *
     * @var \O2System\HTML\DOM\Lists\Asset
     */
    public $linkNodes;

    /**
     * Document Style Content
     *
     * @var \O2System\HTML\DOM\Style
     */
    public $styleContent;

    /**
     * Document Script Nodes
     *
     * @var \O2System\HTML\DOM\Lists\Asset
     */
    public $scriptNodes;

    /**
     * Document Script Content
     *
     * @var \O2System\HTML\DOM\Script
     */
    public $scriptContent;

    // ------------------------------------------------------------------------

    /**
     * Document::__construct
     *
     * @param string $version  Document version.
     * @param string $encoding Document encoding.
     *
     * @return Document
     */
    public function __construct($version = '1.0', $encoding = 'UTF-8') {
        parent::__construct($version, $encoding);

        $this->registerNodeClass('DOMElement', '\O2System\HTML\DOM\Element');
        $this->registerNodeClass('DOMAttr', '\O2System\HTML\DOM\Attr');

        $this->formatOutput = true;

        $this->metaNodes = new Meta($this);
        $this->metaOGPNodes = new OpenGraph($this);

        $this->linkNodes = new DOM\Lists\Asset($this);
        $this->linkNodes->element = 'link';

        $this->styleContent = new Style();

        $this->scriptNodes = new DOM\Lists\Asset($this);
        $this->scriptNodes->element = 'script';

        $this->scriptContent = new Script();

        $this->loadHTMLTemplate();
    }

    // ------------------------------------------------------------------------

    /**
     * Document::loadHTMLTemplate
     *
     * Load HTML template from a file.
     *
     * @return void
     */
    protected function loadHTMLTemplate() {
        $htmlTemplate = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>O2System HTML</title>
</head>
<body>
</body>
</html>
HTML;

        parent::loadHTML($htmlTemplate);
    }

    // ------------------------------------------------------------------------

    /**
     * Document::__get
     *
     * @param string $tagName The document tag element.
     *
     * @return mixed The value at the specified index or false.
     */
    public function &__get($tagName) {
        $getDocument[ $tagName ] = null;

        if (in_array($tagName, ['html', 'head', 'body', 'title'])) {
            $getDocument[ $tagName ] = $this->getElementsByTagName($tagName)->item(0);
        }

        return $getDocument[ $tagName ];
    }

    // ------------------------------------------------------------------------

    /**
     * Document::saveHTMLFile
     *
     * Dumps the internal document into a file using HTML formatting
     *
     * @see   http://php.net/manual/domdocument.savehtmlfile.php
     *
     * @param string $filePath <p>
     *                         The path to the saved HTML document.
     *                         </p>
     *
     * @return int the number of bytes written or false if an error occurred.
     * @since 5.0
     */
    public function saveHTMLFile($filePath) {
        if (!is_string($filePath)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }

        if (!is_writable($filePath)) {
            return false;
        }

        $result = $this->saveHTML();
        file_put_contents($filePath, $result);
        $bytesWritten = filesize($filePath);

        if ($bytesWritten === strlen($result)) {
            return $bytesWritten;
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * Document::saveHTML
     *
     * Dumps the internal document into a string using HTML formatting.
     *
     * @see   http://php.net/manual/domdocument.savehtml.php
     *
     * @param \DOMNode $node [optional] parameter to output a subset of the document.
     *
     * @return string the HTML, or false if an error occurred.
     * @since 5.0
     */
    public function saveHTML(\DOMNode $node = null) {
        $headElement = $this->getElementsByTagName('head')->item(0);

        $styleContent = trim($this->styleContent->__toString());

        if (!empty($styleContent)) {
            $styleElement = $this->createElement('style', $styleContent);
            $styleElement->setAttribute('type', 'text/css');
            $headElement->appendChild($styleElement);
        }

        $titleElement = $this->getElementsByTagName('title')->item(0);

        // Insert Meta
        if (is_array($metaNodes = $this->metaNodes->getArrayCopy())) {
            foreach (array_reverse($metaNodes) as $metaNode) {
                $headElement->insertBefore($this->importNode($metaNode), $titleElement);
            }
        }

        // Insert Meta Open Graph Protocol
        if (is_array($metaOGPNodes = $this->metaOGPNodes->getArrayCopy())) {
            foreach ($metaOGPNodes as $metaOGPNode) {
                $headElement->appendChild($this->importNode($metaOGPNode));
            }
        }

        // Insert Link
        if( count( $this->linkNodes ) ) {
            foreach ($this->linkNodes as $linkNode) {
                $headElement->appendChild($this->importNode($linkNode));
            }
        }

        $bodyElement = $this->getElementsByTagName('body')->item(0);

        // Insert Script
        if ( count( $this->scriptNodes ) ) {
            foreach ($this->scriptNodes as $scriptNode) {
                $bodyElement->appendChild($this->importNode($scriptNode));
            }
        }

        $scriptContent = trim($this->scriptContent->__toString());

        if (!empty($scriptContent)) {
            $scriptElement = $this->createElement('script', $scriptContent);
            $scriptElement->setAttribute('type', 'text/javascript');
            $bodyElement->appendChild($scriptElement);
        }

        $output = parent::saveHTML($node);

        if ($this->formatOutput === true) {
            $beautifier = new Beautifier();
            $output = $beautifier->format($output);
        }

        return trim($output);
    }

    // ------------------------------------------------------------------------

    /**
     * Document::find
     *
     * JQuery style document expression finder.
     *
     * @param string $expression String of document expression.
     *
     * @return Nodes
     */
    public function find($expression) {
        $xpath = new XPath($this);

        $xpath->registerNamespace("php", "http://php.net/xpath");
        $xpath->registerPhpFunctions();

        return $xpath->query($expression);
    }

    // ------------------------------------------------------------------------

    /**
     * Document::importSourceNode
     *
     * Import HTML source code into document.
     *
     * @param string $source HTML Source Code.
     *
     * @return \DOMNode|\O2System\HTML\DOM\Element
     */
    public function importSourceNode($source) {
        $DOMDocument = new self();
        $DOMDocument->load($source);

        $this->metaNodes->import($DOMDocument->metaNodes);
        $this->scriptNodes->import($DOMDocument->scriptNodes);
        $this->linkNodes->import($DOMDocument->linkNodes);
        $this->styleContent->import($DOMDocument->styleContent);
        $this->scriptContent->import($DOMDocument->scriptContent);

        $bodyElement = $DOMDocument->getElementsByTagName('body')->item(0);

        if ($bodyElement->firstChild instanceof Element) {
            return $bodyElement->firstChild;
        } elseif ($bodyElement->firstChild instanceof \DOMText) {
            foreach ($bodyElement->childNodes as $childNode) {
                if ($childNode instanceof Element) {
                    return $childNode->cloneNode(true);
                    break;
                }
            }
        }

        return $bodyElement;
    }

    // ------------------------------------------------------------------------

    /**
     * Document::load
     *
     * Load HTML from a file.
     *
     * @link  http://php.net/manual/domdocument.load.php
     *
     * @param string     $filePath <p>
     *                             The path to the HTML document.
     *                             </p>
     * @param int|string $options  [optional] <p>
     *                             Bitwise OR
     *                             of the libxml option constants.
     *                             </p>
     *
     * @return mixed true on success or false on failure. If called statically, returns a
     * DOMDocument and issues E_STRICT
     * warning.
     * @since 5.0
     */
    public function load($filePath, $options = null) {
        if (file_exists($filePath)) {
            return $this->loadHTMLFile($filePath, $options);
        } elseif (is_string($filePath)) {
            return $this->loadHTML($filePath, $options);
        } elseif (!empty($filePath)) {
            return parent::load($filePath, $options);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Document::loadHTMLFile
     *
     * Load HTML from a file.
     *
     * @see   http://php.net/manual/domdocument.loadhtmlfile.php
     *
     * @param string     $filePath <p>
     *                             The path to the HTML file.
     *                             </p>
     * @param int|string $options  [optional] <p>
     *
     * Since PHP 5.4.0 and Libxml 2.6.0, you may also
     * use the options parameter to specify additional Libxml parameters.
     * </p>
     *
     * @return bool true on success or false on failure. If called statically, returns a
     * DOMDocument and issues E_STRICT
     * warning.
     * @since 5.0
     */
    public function loadHTMLFile($filePath, $options = 0) {
        return $this->loadHTML(file_get_contents($filePath), $options);
    }

    // ------------------------------------------------------------------------

    /**
     * Document::loadHTML
     *
     * Load HTML from a string.
     *
     * @see   http://php.net/manual/domdocument.loadhtml.php
     *
     * @param string     $source  <p>
     *                            The HTML string.
     *                            </p>
     * @param int|string $options [optional] <p>
     *                            Since PHP 5.4.0 and Libxml 2.6.0, you may also
     *                            use the options parameter to specify additional Libxml parameters.
     *                            </p>
     *
     * @return bool true on success or false on failure. If called statically, returns a
     * DOMDocument and issues E_STRICT
     * warning.
     * @since 5.0
     */
    public function loadHTML($source, $options = 0) {
        // Enables libxml errors handling
        $internalErrorsOptionValue = libxml_use_internal_errors();

        if ($internalErrorsOptionValue === false) {
            libxml_use_internal_errors(true);
        }

        $source = $this->parseHTML($source);

        $bodyElement = $this->getElementsByTagName('body')->item(0);

        $DOMDocument = new \DOMDocument();
        $DOMDocument->formatOutput = true;
        $DOMDocument->preserveWhiteSpace = false;

        if ($this->encoding === 'UTF-8') {
            if (function_exists('mb_convert_encoding')) {
                $source = mb_convert_encoding($source, 'HTML-ENTITIES', 'UTF-8');
            } else {
                $source = utf8_decode($source);
            }

            $DOMDocument->encoding = 'UTF-8';
        }

        $DOMDocument->loadHTML(trim($source), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        if (null !== ($sourceBodyElement = $DOMDocument->getElementsByTagName('body')->item(0))) {
            foreach ($sourceBodyElement->childNodes as $childNode) {
                $childNode = $this->importNode($childNode, true);
                $bodyElement->appendChild($childNode);
            }
        } elseif ($bodyChildNode = $this->importNode($DOMDocument->firstChild, true)) {
            $bodyElement->appendChild($bodyChildNode);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Document::parseHTML
     *
     * Parse HTML Source Code.
     *
     * @param string $source HTML Source Code.
     *
     * @return mixed
     */
    private function parseHTML($source) {
        // Has inline meta tags
        $pattern
            = '
		  ~<\s*meta\s
		
		  # using lookahead to capture type to $1
		    (?=[^>]*?
		    \b(?:name|property|http-equiv)\s*=\s*
		    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
		    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
		  )
		
		  # capture content to $2
		  [^>]*?\bcontent\s*=\s*
		    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
		    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
		  [^>]*>
		
		  ~ix';

        if (preg_match_all($pattern, $source, $matches)) {
            $metaTags = array_combine(array_map('strtolower', $matches[1]), $matches[2]);

            foreach ($metaTags as $name => $content) {
                $meta = $this->createElement('meta');
                $meta->setAttribute($name, $content);
                $this->metaNodes[ $name ] = $meta;
            }

            $source = preg_replace('#<meta(.*?)>#is', '', $source);
        }

        // Has inline script Element
        if (preg_match_all('/((<[\\s\\/]*script\\b[^>]*>)([^>]*)(<\\/script>))/', $source, $matches)) {
            if (isset($matches[2])) {
                foreach ($matches[2] as $match) {
                    if (strpos($match, 'src=') !== false) {
                        $scriptElement = $this->createElement('script');
                        $scriptXml = simplexml_load_string(str_replace('>', '/>', $match));

                        foreach ($scriptXml->attributes() as $name => $value) {
                            $scriptElement->setAttribute($name, $value);
                        }

                        $this->scriptNodes[] = $scriptElement;
                    }
                }
            }

            if (isset($matches[3])) {
                foreach ($matches[3] as $match) {
                    $this->scriptContent[] = trim($match) . PHP_EOL;
                }
            }

            $source = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $source);
        }

        // Has inline link Element
        if (preg_match_all('#<link(.*?)>#is', $source, $matches)) {
            if (isset($matches[0])) {
                foreach ($matches[0] as $match) {
                    if (strpos($match, 'href=') !== false) {
                        $linkElement = $this->createElement('link');
                        $linkXml = simplexml_load_string(str_replace('>', '/>', $match));

                        foreach ($linkXml->attributes() as $name => $value) {
                            $linkElement->setAttribute($name, $value);
                        }

                        $this->linkNodes[] = $linkElement;
                    }
                }
            }

            $source = preg_replace('#<link(.*?)>#is', '', $source);
        }

        // Has inline style Element
        if (preg_match_all('/((<[\\s\\/]*style\\b[^>]*>)([^>]*)(<\\/style>))/i', $source, $matches)) {
            if (isset($matches[3])) {
                foreach ($matches[3] as $match) {
                    $this->styleContent[] = trim($match) . PHP_EOL;
                }
            }

            $source = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $source);
        }

        // Remove html comments
        $source = preg_replace('/<!--(.|\s)*?-->/', '', $source);

        // Remove blank lines
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $source);
    }

    // ------------------------------------------------------------------------

    /**
     * Document::__toString
     *
     * Convert document into HTML source code string.
     *
     * @return string
     */
    public function __toString() {
        return $this->saveHTML();
    }
}