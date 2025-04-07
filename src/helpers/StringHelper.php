<?php

namespace MolnarSandorBenjamin\RackforestTest\helpers;

class StringHelper
{
    public static function kebabToCamel(string $string): string
    {
        return lcfirst(
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace(
                        '-',
                        ' ',
                        $string
                    )
                )
            )
        );
    }
}