<?php

declare(strict_types = 1);

namespace Constup\ComposerServices;

/**
 * Class ComposerDirectoryService
 *
 * @package Constup\ComposerUtils\Service\NamespaceService
 */
interface ComposerDirectoryServiceInterface
{
    /**
     * Return an array of all absolute directory paths listed in `autoload > psr-4` and `autoload-dev > psr-4`
     * sections of `composer.json`. For a PHP project, these should be all directories where source code written by a
     * developer can be.
     *
     * @param object $composerJsonObject
     * @param string $projectRootDir
     *
     * @return string[]
     */
    public function getSourceDirectories(object $composerJsonObject, string $projectRootDir): array;
}
