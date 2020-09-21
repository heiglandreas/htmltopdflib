<?php
/**
 * Copyright Andreas Heigl <andreas@heigl.org>
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

namespace Org_Heigl\HtmlToPdflibTest;

use Org_Heigl\HtmlToPdflib\Converter;
use Org_Heigl\HtmlToPdflib\ConverterList;
use Org_Heigl\HtmlToPdflib\Factory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testBasicExample(): void
    {
        $htmlContent = 'test with <em>some</em> <strong><em>strong</em> language</strong>';
        $converter = new Converter();
        $pdflibtext = $converter->convert($htmlContent);

        Assert::assertSame(
            "<&p>test with <&italic>some<&p> <&bold><&bolditalic>strong<&bold> language<&p>\n",
            $pdflibtext
        );
    }

    public function testExtendedSetup(): void
    {
        $converter = new Converter(Factory::fromConverterList(new ConverterList([
            'em'     => Converter\Em::class,
            'li'     => Converter\Li::class,
            'ol'     => Converter\Ol::class,
            'p'      => Converter\P::class,
            'strong' => Converter\Strong::class,
            'ul'     => Converter\Ul::class,
        ])));

        self::assertInstanceOf(Converter::class, $converter);
    }
}
