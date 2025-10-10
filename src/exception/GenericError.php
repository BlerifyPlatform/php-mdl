<?php

namespace Blerify\Exception;

class GenericError 
{
    public const ERROR_CODES = [
        100000 => 'Unable to decode DER signature',
        100001 => 'Unexpected structure: missing r/s bytes',
        100002 => 'Integer too large for P-256',
        100003 => 'Unexpected value type for hex conversion',
        100004 => 'Invalid hex input: unable to convert to binary',
        100005 => 'Unexpected structure: missing r/s hex characters',
        100006 => 'After removing 0x00 the size is not 32 bytes',
        100007 => 'Integer of 33 bytes without leading 0x00 — unexpected value',
    ];

    public static function getErrorMessage(int $code): string
    {
        return self::ERROR_CODES[$code] ?? 'Unknown error';
    }

    public static function getError(int $code, $trace): array
    {
        $msg = self::ERROR_CODES[$code] ?? 'Unknown error';
        return ["error" => true, "message" => $msg, "code" => $code, "trace" => $trace];
    }
}