<?php
/**
 * Copyright Andreas Heigl <andreas@heigl.org>
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

namespace Org_Heigl\HtmlToPdflibTest;

use Org_Heigl\HtmlToPdflib\Converter;
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
}
