<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap;

use ReflectionClass;
use ReflectionException;

/**
 * Class InterfaceMapService
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap
 */
class InterfaceMapService implements InterfaceMapServiceInterface
{
    /**
     * @param string $interfaceName
     *
     * @throws ReflectionException
     *
     * @return string[]
     */
    public function getImplementingInterfaces(string $interfaceName): array
    {
        $interfaces = get_declared_interfaces();
        $result = [];
        foreach ($interfaces as $interface) {
            $reflection = new ReflectionClass($interface);
            if ($reflection->implementsInterface($interfaceName)) {
                $result[] = $interface;
            }
        }

        return $result;
    }
}
