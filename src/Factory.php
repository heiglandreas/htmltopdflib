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
 * @copyright © Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @since     08.04.14
 * @link      https://github.com/heiglandreas/htmltopdflib
 */

namespace Org_Heigl\HtmlToPdflib;

use DOMNode;
use Org_Heigl\HtmlToPdflib\Converter\Em;
use Org_Heigl\HtmlToPdflib\Converter\Li;
use Org_Heigl\HtmlToPdflib\Converter\Ol;
use Org_Heigl\HtmlToPdflib\Converter\P;
use Org_Heigl\HtmlToPdflib\Converter\Standard;
use Org_Heigl\HtmlToPdflib\Converter\Strong;
use Org_Heigl\HtmlToPdflib\Converter\Ul;

final class Factory
{
    private static $factory;

    private $converterList;

    private function __construct(ConverterList $converterList)
    {
        $this->converterList = $converterList;
    }

    public static function fromConverterList(ConverterList $converterList): self
    {
        return new self($converterList);
    }

    public static function withDefaultConverters(): self
    {
        return new self(ConverterList::createViaReflection([
            'em' => Em::class,
            'li' => Li::class,
            'ol' => Ol::class,
            'p' => P::class,
            'strong' => Strong::class,
            'ul' => Ul::class,
        ]));
    }
    /**
     * @param DOMNode $node
     *
     * @return ConverterInterface
     */
    public static function factory(DOMNode $node, ConverterInterface $converter = null)
    {
        if (!self::$factory instanceof self) {
            self::$factory = self::withDefaultConverters();
        }

        return self::$factory->getConverterForTag($node, $converter);
    }

    public function getConverterForTag(DOMNode $node, ConverterInterface $converter = null): ConverterInterface
    {
        $tagName = $node->nodeName;

        try {
            $converterClass = $this->converterList->getConverterForTag($tagName);
            return new $converterClass($node, $converter);

        } catch (\Exception $e) {
            // Do nothing on purpose
        }
        return new Standard($node, $converter);
    }
}
