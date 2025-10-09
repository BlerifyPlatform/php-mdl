<?php
namespace Blerify\Crypto;

require 'vendor/autoload.php';

use Exception;
use phpseclib3\File\ASN1;
use RuntimeException;

class Utils {

    /**
     * @param string $derSig Binary DER signature
     * @return array{r: string, s: string}
     * @throws \RuntimeException
     */
    public static function parse(string $derSig): array
    {
        $decoded = ASN1::decodeBER($derSig);
        if (empty($decoded)) {
            throw new RuntimeException('Unable to decode DER signature');
        }

        $el = $decoded[0];
        
        // 2) Mapear a estructura: SEQUENCE { INTEGER r, INTEGER s }
        $map = [
            'type' => ASN1::TYPE_SEQUENCE,
            'children' => [
                'r' => ['type' => ASN1::TYPE_INTEGER],
                's' => ['type' => ASN1::TYPE_INTEGER],
            ]
        ];
        
        // asn1map devuelve los valores mapeados
        $values = ASN1::asn1map($decoded[0], $map);
        // get bytes from big integers
        if (!isset($values['r'], $values['s'])) {
        throw new RuntimeException('Unexpected structure: missing r/s');
        }
        return ['r' => self::valToHex($values['r']), 's' => self::valToHex($values['s'])];
    }

    /**
     * @param string $derHex Hex-encoded DER signature (no “0x”, just hex digits)
     * @return array{r: string, s: string} Returns R and S as binary strings
     * @throws \RuntimeException
     */
    public static function parseFromHex(string $derHex): array
    {
        $der = hex2bin($derHex);
        if ($der === false) {
            throw new RuntimeException("Invalid hex input: unable to convert to binary");
        }
        $parts = self::parse($der);
        if (!isset($parts['r'], $parts['s'])) {
            throw new RuntimeException('Unexpected structure: missing r/s');
        }
        // normalize
        $parts['r'] = self::normalizeTo32Bytes(hex2bin($parts['r']));
        $parts['s'] = self::normalizeTo32Bytes(hex2bin($parts['s']));
        return $parts;
    }

    /**
     * @param string $derHex Hex-encoded DER signature
     * @return array{r: string, s: string} Hex strings for R and S (32 bytes each)
     * @throws \RuntimeException
     */
    public static function parseHexComponents(string $derHex): array
    {
        $parts = self::parseFromHex($derHex);
        return [
            'r' => bin2hex($parts['r']),
            's' => bin2hex($parts['s']),
        ];
    }

    public static function derToPlainSignature(string $hex_sig): string {
        $parts = self::parseHexComponents($hex_sig);
        return $parts['r'] . $parts['s'];
    }
 
    /**
     * Normalize an integer (raw bytes) to exactly 32 bytes for P-256.
     * - If it has 33 bytes and the first is 0x00 -> remove the 0x00 (positive)
     * - If it has < 32 bytes -> left-pad with zeros
     * - If it has > 32 bytes and first byte != 0x00 -> exception (out of range)
    */
    public static function normalizeTo32Bytes(string $raw): string {
        $len = strlen($raw);
        if ($len === 32) {
            return $raw;
        }
        if ($len === 33) {
            // if the first byte is 0x00 we remove it (it was added to indicate positive sign)
            if (ord($raw[0]) === 0x00) {
                $trimmed = substr($raw, 1);
                if (strlen($trimmed) !== 32) {
                    throw new Exception("Después de quitar 0x00 el tamaño no es 32 bytes");
                }
                return $trimmed;
            } else {
                throw new Exception("Integer of 33 bytes without leading 0x00 — unexpected value");
            }
        }
        if ($len < 32) {
            // left-pad with zeros
            return str_repeat("\x00", 32 - $len) . $raw;
        }
        // len > 33 -> out of range
        throw new Exception("Integer too large for P-256: {$len} bytes");
    }

    /**
    * Helper to convert various types of values to hex string
    * - BigInteger (phpseclib) with toHex() or toBytes()
    * - decimal string
    * - binary string
    */
    private static function valToHex($v) {
        // BigInteger de phpseclib típicamente es un objeto con toBytes() o toHex()
        if (is_object($v)) {
            if (method_exists($v, 'toHex')) {
                // toHex() devuelve hex sin prefijo
                return ltrim($v->toHex(), '0') === '' ? '0' : $v->toHex();
            }
            if (method_exists($v, 'toBytes')) {
                return bin2hex($v->toBytes());
            }
            if (method_exists($v, 'toString')) {
                // decimal string
                $dec = $v->toString();
                if (function_exists('gmp_init')) {
                    return gmp_strval(gmp_init($dec, 10), 16);
                } else {
                    // fallback con BCMath
                    $hex = '';
                    while (bccomp($dec, '0') > 0) {
                        $mod = (int) bcmod($dec, '16');
                        $hex = dechex($mod) . $hex;
                        $dec = bcdiv(bcsub($dec, (string)$mod), '16', 0);
                    }
                    return $hex === '' ? '0' : $hex;
                }
            }
        }
    
        // if it's a string it can be raw binary - convert to hex
        if (is_string($v)) {
            return bin2hex($v);
        }

        throw new RuntimeException('Unexpected value type for hex conversion');
    }

}