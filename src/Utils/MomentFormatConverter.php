<?php

namespace App\Utils;

/**
 * This class is used to convert PHP date format to moment.js format.
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class MomentFormatConverter
{
    private static $formatConvertRules = [
        'yyyy' => 'YYYY',
        'yy' => 'YY',
        'y' => 'YYYY',

        'dd' => 'DD',
        'd' => 'D',
        'EE' => 'ddd',
        'EEEEEE' => 'dd',

        'ZZZZZ' => 'Z', 'ZZZ' => 'ZZ',

        '\'T\'' => 'T',
    ];

    /**
     * Returns associated moment.js format.
     */
    public function convert(string $format): string
    {
        return strtr($format, self::$formatConvertRules);
    }
}
