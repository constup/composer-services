<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\Components\Classes;

use Constup\AutomatrixComponents\LanguagePhp\Version0702\LanguageComponent\Level1\UseComponent\UseImmutableObjectInterface;

/**
 * Interface PhpFileDataInterface
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\Components\Classes
 */
interface PhpFileDataInterface
{
    /**
     * @return bool
     */
    public function getDeclareStrictTypes(): bool;

    /**
     * @return string
     */
    public function getNamespace(): string;

    /**
     * @return UseImmutableObjectInterface[]|null
     */
    public function getUses(): ?array;
}
