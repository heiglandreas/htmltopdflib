<?php

/**
 * Copyright (c) Andreas Heigl<andreas@heigl.org>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category 
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright © Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @since     08.04.14
 * @link      https://github.com/heiglandreas/htmltopdflib
 */

namespace Org_Heigl\HtmlToPdflib\Converter;

use DOMNode;
use Org_Heigl\HtmlToPdflib\ConverterInterface;
use Org_Heigl\HtmlToPdflib\Factory;

class Standard implements ConverterInterface
{
    /**
     * @var DOMNode $node
     */
    protected $node;

    protected $parentConverter;

    protected $macro = '';

    protected $prefix = '';

    protected $postfix = '';

    protected $leftDelimiter = '<';

    protected $rightDelimiter = '>';


    public function __construct(DOMNode $node, ConverterInterface $parentConverter = null)
    {
        $this->node = $node;
        $this->parentConverter = $parentConverter;

        // use the delimiters from the parent, if one is present
        //
        if($this->parentConverter) {
            $this->leftDelimiter = $this->parentConverter->leftDelimiter;
            $this->rightDelimiter = $this->parentConverter->rightDelimiter;
        }

    }

    public function getPdfLibString()
    {
        $content = '';

        foreach ($this->node->childNodes as $child) {
            $content .= $this->getContent($child);
        }

        return $this->getMacro()
             . $this->prefix
             . $content
             . $this->postfix
             . $this->getPreviousMacro();
    }

    public function getContent(DOMNode $node)
    {
        if (XML_TEXT_NODE == $node->nodeType) {
            return $node->textContent;
        }

        return Factory::factory($node, $this)->getPdfLibString();
    }

    public function getMacro()
    {
        if (! $this->macro) {
            return '';
        }
        $macro = $this->leftDelimiter . '&' . $this->macro . $this->rightDelimiter;

        if ($macro == $this->getPreviousMacro()) {
            return '';
        }

        return $macro;
    }

    public function getPreviousMacro()
    {
        if (! $this->parentConverter) {
            return '';
        }
        $macro =  $this->parentConverter->getMacro();
        if (! $macro) {
            $macro = $this->parentConverter->getPreviousMacro();
        }

        return $macro;
    }

    public function getPreviousConverter()
    {
        return $this->parentConverter;
    }

    public function setLeftDelimiter($p_delimiter) {
        $this->leftDelimiter = $p_delimiter;
        return $this;
    }

    public function setRightDelimiter($p_delimiter) {
        $this->rightDelimiter = $p_delimiter;
        return $this;
    }

}
