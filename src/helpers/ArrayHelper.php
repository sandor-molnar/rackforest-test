<?php

namespace MolnarSandorBenjamin\RackforestTest\helpers;

class ArrayHelper
{
    public static function getValue(array $array, string $key, mixed $default = null): mixed
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        return $default;
    }

    public static function mergeRecursive(...$arrays): array
    {
        $result = array_merge_recursive($arrays);
        array_walk($result, function(&$v) {
            $v = array_map('array_unique', $v);
        });

        return $result;
    }
}