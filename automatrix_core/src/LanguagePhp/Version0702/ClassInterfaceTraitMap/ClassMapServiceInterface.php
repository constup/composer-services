<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap;

use ReflectionException;

/**
 * Class ClassMapService
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap
 */
interface ClassMapServiceInterface
{
    /**
     * @param string $interfaceName
     *
     * @throws ReflectionException
     *
     * @return string[]
     */
    public function getImplementingClasses(string $interfaceName): array;
}
