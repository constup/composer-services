<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap;

use ReflectionClass;
use ReflectionException;

/**
 * Class ClassMapService
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\ClassInterfaceTraitMap
 */
class ClassMapService implements ClassMapServiceInterface
{
    /**
     * @param string $interfaceName
     *
     * @throws ReflectionException
     *
     * @return string[]
     */
    public function getImplementingClasses(string $interfaceName): array
    {
        $classes = get_declared_classes();
        $result = [];
        foreach ($classes as $class) {
            $reflection = new ReflectionClass($class);
            if ($reflection->implementsInterface($interfaceName)) {
                $result[] = $class;
            }
        }

        return $result;
    }
}
