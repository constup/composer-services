<?php

declare(strict_types = 1);

namespace Constup\ComposerServices;

use Constup\ComposerServices\SubObject\NamespaceImmutableObjectInterface;
use Exception;

/**
 * Class NamespaceService
 *
 * @package Constup\ComposerUtils\Service\NamespaceService
 */
interface NamespaceServiceInterface
{
    const TEST_NAMESPACE_MARKER_TEST = 'Test';
    const TEST_NAMESPACE_MARKER_TESTS = 'Tests';

    /**
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return NamespaceImmutableObjectInterface[]
     */
    public function getAutoload(object $composerJsonObject, string $projectRootDirectory): array;

    /**
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return NamespaceImmutableObjectInterface[]
     */
    public function getAutoloadDev(object $composerJsonObject, string $projectRootDirectory): array;

    /**
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return NamespaceImmutableObjectInterface[]
     */
    public function getAutoloadAndAutoloadDev(object $composerJsonObject, string $projectRootDirectory): array;

    /**
     * @param string $filePath
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateNamespaceFromPath(string $filePath, object $composerJsonObject, string $projectRootDirectory): string;

    /**
     * Use this method to generate a directory path based on a namespace.
     * To generate PHP file path instead, @param string $namespace
     *
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return string
     *
     * @see NamespaceUtilInterface::generatePathFromFqcn() instead.
     */
    public function generatePathFromNamespace(string $namespace, object $composerJsonObject, string $projectRootDirectory): string;

    /**
     * @param string $fqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return string|null
     */
    public function generatePathFromFqn(string $fqn, object $composerJsonObject, string $projectRootDirectory): ?string;

    /**
     * @param string $fqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return bool
     */
    public function fileWithFqnExists(string $fqn, object $composerJsonObject, string $projectRootDirectory): bool;

    /**
     * @param string $namespaceOrFqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     *
     * @return string
     */
    public function getComposerBaseNamespace(string $namespaceOrFqn, object $composerJsonObject, string $projectRootDirectory): string;

    /**
     * @param string $componentFqn
     * @param object $composerJsonObject
     * @param string $projectRootDirectory
     * @param string $testNamespaceMarker
     *
     * @return string
     */
    public function generateTestNamespaceForComponent(string $componentFqn, object $composerJsonObject, string $projectRootDirectory, string $testNamespaceMarker = self::TEST_NAMESPACE_MARKER_TESTS): string;
}
