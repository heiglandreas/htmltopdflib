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
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2014-2014 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @since     08.04.14
 * @link      https://github.com/heiglandreas/htmltopdflib
 */

namespace Org_Heigl\HtmlToPdflib\Converter;

use DOMNode;
use Org_Heigl\HtmlToPdflib\ConverterInterface;

class Li extends Standard
{

    protected $macro = 'li';

    protected $postfix = "\n";

    public function __construct(DOMNode $node, ConverterInterface $parentConverter = null)
    {
        parent::__construct($node, $parentConverter);

        $this->setPrefix();
    }

    protected function setPrefix()
    {
        if ($this->parentConverter instanceof Ul) {
            $this->prefix = '-' . "\t";
            return $this;
        }

        if ($this->parentConverter instanceof Ol) {
            $this->prefix = $this->countPreviousSiblings() . '.' . "\t";
            return $this;
        }

        return $this;
    }

    protected function countPreviousSiblings()
    {
        $counter = 1;
        $prev = $this->node->previousSibling;
        while ($prev) {
            if ($prev->nodeName != 'li') {
                $prev = $prev->previousSibling;
                continue;
            }
            $prev = $prev->previousSibling;
            $counter++;
        }

        return $counter;

    }
} 
