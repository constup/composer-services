<?php

declare(strict_types = 1);

namespace Constup\ComposerServices;

/**
 * Class ComposerFileService
 *
 * @package Constup\ComposerUtils\Service\NamespaceService
 */
interface ComposerFileServiceInterface
{
    /**
     * Absolute path of the directory containing a parent `composer.json` (relative to the `startDirectory`).
     * If `composer.json` is not found, **`null`** is returned.
     * The method will recursively search the directory tree upwards up until the root.
     *
     * @param string $startDirectory A directory where you want to start searching for `composer.json` from.
     *
     * @return string|null
     */
    public function findComposerJson(string $startDirectory): ?string;

    /**
     * Returns the contents of `composer.json` object in an object form. Sub-nodes are then accessible as object's
     * properties.
     * A special case are nodes which have `-` sign in them (ex.: `autoload-dev`), since you can't directly access an
     * object's property with the `-` sign in it. To access the property, store the name of the node in a constant and
     * access by using the constant (ex. `self::$AUTOLOAD_DEV`).
     *
     * @param string $composerJsonFilePath Absolute file path of a `composer.json` file.
     *
     * @return object|null
     */
    public function fetchComposerJsonObject(string $composerJsonFilePath): ?object;

    /**
     * This method simply uses `fetchComposerJSON` after `findComposerJSON`.
     *
     * @param string $startDirectory A directory where you want to start searching for `composer.json` from.
     *
     * @return object|null
     */
    public function findAndFetchComposerJson(string $startDirectory): ?object;
}
