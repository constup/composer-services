<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\Components;

use Constup\Automatrix\LanguagePhp\Version0702\DesignPatternInterfaces\JsonMapperInterface;
use stdClass;

/**
 * Class MethodBodyJsonMapper
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\Components
 */
class MethodBodyJsonMapper implements JsonMapperInterface
{
    /**
     * @param object $json
     * @return null
     */
    public function fromJson(object $json)
    {
        return null;
    }

    /**
     * @param $methodBody
     * @return object
     */
    public function toJson($methodBody): object
    {
        return new stdClass();
    }
}