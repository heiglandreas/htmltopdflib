<?php

declare(strict_types=1);

/**
 * Copyright Andreas Heigl <andreas@heigl.org>
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

namespace Org_Heigl\HtmlToPdflibTest;

use Org_Heigl\HtmlToPdflib\ConverterInterface;

class TestConverter implements ConverterInterface
{

    public function getPdfLibString()
    {
        return 'pdflibString';
    }

    public function getPreviousMacro()
    {
        return 'previousMacro';
    }

    public function getMacro()
    {
        return 'macro';
    }
}