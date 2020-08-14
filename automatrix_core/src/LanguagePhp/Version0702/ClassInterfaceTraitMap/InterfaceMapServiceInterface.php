<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap;

use ReflectionException;

/**
 * Class InterfaceMapService
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap
 */
interface InterfaceMapServiceInterface
{
    /**
     * @param string $interfaceName
     *
     * @throws ReflectionException
     *
     * @return string[]
     */
    public function getImplementingInterfaces(string $interfaceName): array;
}
