<?php

declare(strict_types=1);

/**
 * Copyright Andreas Heigl <andreas@heigl.org>
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

namespace Org_Heigl\HtmlToPdflib;

use Roave\BetterReflection\Reflection\ReflectionClass;
use RuntimeException;
use Throwable;
use function strtolower;

final class ConverterList
{
    private $converters = [];

    /**
     * ConverterList constructor.
     * @param array<array-key: class-name> $converters
     */
    public function __construct(array $converters)
    {
        foreach ($converters as $key => $converter) {
            try {
                $class = ReflectionClass::createFromName($converter);
            } catch (Throwable $e) {
                continue;
            }
            if (! $class->implementsInterface(ConverterInterface::class)) {
                continue;
            }

            $this->converters[strtolower($key)] = $converter;
        }
    }

    public function withConverter(string $tag, string $converter): ConverterList
    {
        $list = $this->converters;
        $list[strtolower($tag)] = $converter;

        $new = new self($list);
    }

    public function hasConverterClassNameForTag(string $tag): bool
    {
        return isset($this->converters[strtolower($tag)]);
    }

    public function getConverterForTag(string $tag): string
    {
        if (! $this->hasConverterClassNameForTag($tag)) {
            throw new RuntimeException(sprintf('No Converter for Tag %s available', $tag));
        }

        return $this->converters[strtolower($tag)];
    }
}