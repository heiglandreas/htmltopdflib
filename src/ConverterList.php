<?php

declare(strict_types=1);

/**
 * Copyright Andreas Heigl <andreas@heigl.org>
 *
 * Licenses under the MIT-license. For details see the included file LICENSE.md
 */

namespace Org_Heigl\HtmlToPdflib;

use RuntimeException;
use Throwable;
use function class_exists;
use function strtolower;

final class ConverterList
{
    private $converters = [];

    /**
     * ConverterList constructor.
     * @param array<array-key: class-name> $converters
     */
    private function __construct()
    {
        $this->converters = [];
    }

    public static function createViaBetterReflection(array $converters): self
    {
        if (! class_exists(\Roave\BetterReflection\Reflection\ReflectionClassReflectionClass)) {
            throw new RuntimeException('BetterReflection is not installed.');
        }
        $list = new self;
        foreach ($converters as $key => $converter) {
            try {
                $class = \Roave\BetterReflection\Reflection\ReflectionClassReflectionClass::createFromName($converter);
            } catch (Throwable $e) {
                continue;
            }
            if (! $class->implementsInterface(ConverterInterface::class)) {
                continue;
            }

            $list->converters[strtolower($key)] = $converter;
        }

        return $list;
    }

    public static function createViaReflection(array $converters): self
    {
        $list = new self;
        foreach ($converters as $key => $converter) {
            try {
                $class = new \ReflectionClass($converter);
            } catch (Throwable $e) {
                continue;
            }
            if (! $class->implementsInterface(ConverterInterface::class)) {
                continue;
            }

            $list->converters[strtolower($key)] = $converter;
        }

        return $list;
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