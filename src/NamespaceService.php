<?php

declare(strict_types = 1);

namespace Constup\ComposerServices;

use Constup\ComposerServices\SubObject\NamespaceImmutableObject;
use Constup\ComposerServices\SubObject\NamespaceImmutableObjectInterface;
use Exception;

/**
 * Class NamespaceService
 *
 * @package Constup\ComposerUtils\Service\NamespaceService
 */
class NamespaceService implements NamespaceServiceInterface
{
    /**
     * Get all `autoload` namespaces and their respective absolute path directories from `composer.json` object.
     * The result is returned as an array of @see NamespaceImmutableObjectInterface objects.
     *
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return NamespaceImmutableObjectInterface[]
     */
    public function getAutoload(
        object $composerJsonObject,
        string $projectRootDirectory
    ): array {
        $psr_4 = ComposerConstantsInterface::PSR_4;
        $result = [];

        foreach ($composerJsonObject->autoload->$psr_4 as $namespace => $directory) {
            $_directory = realpath(rtrim($projectRootDirectory . DIRECTORY_SEPARATOR . $directory, '\\/'));
            if ($_directory === false) {
                // The directory doesn't exist. Do not process it.
                continue;
            }
            $result[] = new NamespaceImmutableObject(
                $namespace,
                $_directory
            );
        }

        return $result;
    }

    /**
     * Get all `autoload-dev` namespaces and their respective absolute path directories from `composer.json` object.
     * The result is returned as an array of @see NamespaceImmutableObjectInterface objects.
     *
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return NamespaceImmutableObjectInterface[]
     */
    public function getAutoloadDev(
        object $composerJsonObject,
        string $projectRootDirectory
    ): array {
        $psr_4 = ComposerConstantsInterface::PSR_4;
        $autoload_dev = ComposerConstantsInterface::AUTOLOAD_DEV;
        $result = [];

        foreach ($composerJsonObject->$autoload_dev->$psr_4 as $namespace => $directory) {
            $_directory = realpath(rtrim($projectRootDirectory . DIRECTORY_SEPARATOR . $directory, '\\/'));
            if ($_directory === false) {
                // The directory doesn't exist. Do not process it.
                continue;
            }
            $result[] = new NamespaceImmutableObject(
                $namespace,
                $_directory
            );
        }

        return $result;
    }

    /**
     * Simply returns a combined array of results from both `getAutoload()` and `getAutoloadDev()`.
     *
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return NamespaceImmutableObjectInterface[]
     */
    public function getAutoloadAndAutoloadDev(
        object $composerJsonObject,
        string $projectRootDirectory
    ): array {
        return array_merge(
            $this->getAutoload($composerJsonObject, $projectRootDirectory),
            $this->getAutoloadDev($composerJsonObject, $projectRootDirectory)
        );
    }

    /**
     * Generate namespace for a given path.
     *
     * @param string $filePath
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateNamespaceFromPath(
        string $filePath,
        object $composerJsonObject,
        string $projectRootDirectory
    ): string {
        $_filePath = realpath($filePath);

        $autoload = $this->getAutoload($composerJsonObject, $projectRootDirectory);
        foreach ($autoload as $namespace) {
            if (strpos($_filePath, $namespace->getAbsoluteDirectory()) === 0) {
                return rtrim(str_replace('\\\\', '\\', $namespace->getNamespace() . substr($_filePath, strlen($namespace->getAbsoluteDirectory()))), '\\');
            }
        }

        $autoloadDev = $this->getAutoloadDev($composerJsonObject, $projectRootDirectory);
        foreach ($autoloadDev as $namespace) {
            if (strpos($_filePath, $namespace->getAbsoluteDirectory()) === 0) {
                return rtrim(str_replace('\\\\', '\\', $namespace->getNamespace() . substr($_filePath, strlen($namespace->getAbsoluteDirectory()))), '\\');
            }
        }

        throw new Exception(__METHOD__ . ' : ' . 'File path "' . $_filePath . '" does not belong to any namespace.');
    }

    /**
     * Generate a directory path based on a namespace.
     * To generate PHP file path instead, @see NamespaceUtilInterface::generatePathFromFqcn() instead.
     *
     * @param string $namespace
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return string
     */
    public function generatePathFromNamespace(
        string $namespace,
        object $composerJsonObject,
        string $projectRootDirectory
    ): string {
        $result = '';
        $match = '';

        $autoload = $this->getAutoload($composerJsonObject, $projectRootDirectory);
        foreach ($autoload as $namespaceData) {
            if (strpos($namespace, $namespaceData->getNamespace()) === 0) {
                $namespaceBaseDir = str_replace('/', DIRECTORY_SEPARATOR, $namespaceData->getAbsoluteDirectory());
                $count = 1;
                $_namespace = str_replace($namespaceData->getNamespace(), '', $namespace, $count);
                $result = rtrim($namespaceBaseDir, '\\/') . DIRECTORY_SEPARATOR . $_namespace;
                $match = $namespaceData->getNamespace();
            }
        }

        $autoloadDev = $this->getAutoloadDev($composerJsonObject, $projectRootDirectory);
        foreach ($autoloadDev as $namespaceData) {
            if (strpos($namespace, $namespaceData->getNamespace()) === 0) {
                $namespaceBaseDir = str_replace('/', DIRECTORY_SEPARATOR, $namespaceData->getAbsoluteDirectory());
                $count = 1;
                $_namespace = str_replace($namespaceData->getNamespace(), '', $namespace, $count);
                $_result = rtrim($namespaceBaseDir, '\\/') . DIRECTORY_SEPARATOR . $_namespace;
                // This covers the case when the namespace defined in autoload-dev is not a subset of any namespace defined in autoload.
                if (empty($match)) {
                    $result = $_result;
                } else {
                    // If previously found namespace root is a substring of the currently processed namespace root, the result is the new namespace root.
                    if (strpos($namespaceData->getNamespace(), $match) !== false) {
                        $result = $_result;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Generate directory from a fully qualified name (of a class, interface or trait).
     *
     * @param string $fqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return string|null
     */
    public function generatePathFromFqn(
        string $fqn,
        object $composerJsonObject,
        string $projectRootDirectory
    ): ?string {
        return (empty($this->generatePathFromNamespace($fqn, $composerJsonObject, $projectRootDirectory)))
                ? null
                : $this->generatePathFromNamespace($fqn, $composerJsonObject, $projectRootDirectory) . '.php';
    }

    /**
     * Check if a class, interface or trait with the provided fully qualified name exists.
     *
     * @param string $fqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return bool
     */
    public function fileWithFqnExists(
        string $fqn,
        object $composerJsonObject,
        string $projectRootDirectory
    ): bool {
        $filename = $this->generatePathFromFqn($fqn, $composerJsonObject, $projectRootDirectory);

        return file_exists($filename) && is_file($filename);
    }

    /**
     * @param string $namespaceOrFqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return string
     */
    public function getComposerBaseNamespace(
        string $namespaceOrFqn,
        object $composerJsonObject,
        string $projectRootDirectory
    ): string {
        $result = '';

        $allAutoloads = $this->getAutoloadAndAutoloadDev($composerJsonObject, $projectRootDirectory);
        foreach ($allAutoloads as $namespace) {
            if ((strpos($namespaceOrFqn, $namespace->getNamespace()) === 0) && (strlen($result) < strlen($namespace->getNamespace()))) {
                $result = $namespace->getNamespace();
            }
        }

        return $result;
    }

    /**
     * Generates a (phpUnit) test file namespace for a class, interface or trait based on the fully qualified name of
     * the class, interface or trait.
     *
     * @param string $componentFqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     * @param string $testNamespaceMarker
     *
     * @return string
     */
    public function generateTestNamespaceForComponent(
        string $componentFqn,
        object $composerJsonObject,
        string $projectRootDirectory,
        string $testNamespaceMarker = self::TEST_NAMESPACE_MARKER_TESTS
    ): string {
        $baseComponentNamespace = $this->getComposerBaseNamespace($componentFqn, $composerJsonObject, $projectRootDirectory);
        $baseComponentTestNamespace = $baseComponentNamespace . $testNamespaceMarker . '\\';

        return str_replace($baseComponentNamespace, $baseComponentTestNamespace, $componentFqn);
    }
}
