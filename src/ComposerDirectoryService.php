<?php

declare(strict_types = 1);

namespace Constup\ComposerServices;

/**
 * Class ComposerDirectoryService
 *
 * @package Constup\ComposerUtils\Service\NamespaceService
 */
class ComposerDirectoryService implements ComposerDirectoryServiceInterface
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
    public function getSourceDirectories(object $composerJsonObject, string $projectRootDir): array
    {
        $result = [];

        $psr_4 = ComposerConstantsInterface::PSR_4;
        $autoload_dev = ComposerConstantsInterface::AUTOLOAD_DEV;

        foreach ($composerJsonObject->autoload->$psr_4 as $namespace => $relativeDirectory) {
            $absoluteDirectory = realpath(rtrim($projectRootDir . DIRECTORY_SEPARATOR . $relativeDirectory, '\\/'));
            if ($absoluteDirectory === false) {
                // The directory does not exist. Do not process it.
                continue;
            }
        }
        foreach ($composerJsonObject->$autoload_dev->$psr_4 as $namespace => $relativeDirectory) {
            $absoluteDirectory = realpath(rtrim($projectRootDir . DIRECTORY_SEPARATOR . $relativeDirectory, '\\/'));
            if ($absoluteDirectory === false) {
                // The directory does not exist. Do not process it.
                continue;
            }
        }

        return $result;
    }
}
