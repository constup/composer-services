<?php

declare(strict_types = 1);

namespace Constup\Automatrix\LanguagePhp\Version0702\JsonMapper;

use DateTime;
use Exception;

/**
 * Class AbstractJsonMapper
 *
 * @package Constup\Automatrix\LanguagePhp\Version0702\JsonMapper
 */
abstract class AbstractJsonMapper
{
    /**
     * @param object|null $jsonObject
     * @param string      $jsonMapperClassName
     *
     * @return object|null
     */
    protected function fromJsonObject(?object $jsonObject, string $jsonMapperClassName): ?object
    {
        if (empty($jsonObject)) {
            return null;
        }

        /* @noinspection PhpUndefinedMethodInspection */
        return (new $jsonMapperClassName())->fromJson($jsonObject);
    }

    /**
     * @param object|null $object
     * @param string      $jsonMapperClassName
     *
     * @return object|null
     */
    protected function toJsonObject(?object $object, string $jsonMapperClassName): ?object
    {
        if (empty($object)) {
            return null;
        }

        /* @noinspection PhpUndefinedMethodInspection */
        return (new $jsonMapperClassName())->toJson($object);
    }

    /**
     * @param object[]|null $jsonObjectArray
     * @param string        $jsonMapperClassName
     *
     * @return object[]|null
     */
    protected function fromJsonObjectArray(?array $jsonObjectArray, string $jsonMapperClassName): ?array
    {
        if (empty($jsonObjectArray)) {
            return null;
        }

        $result = [];
        foreach ($jsonObjectArray as $data) {
            /* @noinspection PhpUndefinedMethodInspection */
            $result[] = (new $jsonMapperClassName())->fromJson($data);
        }

        return $result;
    }

    /**
     * @param object[]|null $objectArray
     * @param string        $jsonMapperClassName
     *
     * @return object[]|null
     */
    protected function toJsonObjectArray(?array $objectArray, string $jsonMapperClassName): ?array
    {
        if (empty($objectArray)) {
            return null;
        }

        $result = [];
        foreach ($objectArray as $data) {
            /* @noinspection PhpUndefinedMethodInspection */
            $result[] = (new $jsonMapperClassName())->toJson($data);
        }

        return $result;
    }

    /**
     * @param string|null $jsonValue
     *
     * @throws Exception
     *
     * @return DateTime|null
     */
    protected function dateTimefromJson(?string $jsonValue): ?DateTime
    {
        return ($jsonValue === null) ? null : new DateTime($jsonValue);
    }

    /**
     * @param DateTime|null $dateTime
     *
     * @return string|null
     */
    protected function dateTimeToJson(?DateTime $dateTime): ?string
    {
        return ($dateTime === null) ? null : $dateTime->format('Y-m-d H:i:s');
    }
}
