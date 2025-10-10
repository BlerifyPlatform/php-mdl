<?php
namespace Blerify\Crypto;

use Exception;
use phpseclib3\File\ASN1;
use RuntimeException;

class Utils {

    /**
     * @param string $derSig Binary DER signature
     * @return array{r: string, s: string}
     */
    public static function parse(string $derSig): array
    {
        $decoded = ASN1::decodeBER($derSig);
        if (empty($decoded)) {
            $msg = 'Unable to decode DER signature';
            return ["error" => true, "message" => $msg, "code" => 100000];
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
        if (!isset($values['r']) || !isset($values['s'])) {
            $msg = 'Unexpected structure: missing r/s bytes';
            return ["error" => true, "message" => $msg, "code" => 100001];
        }
        $r = self::valToHex($values['r']);
        if (isset($r['error']) && $r['error'] === true) {
            return $r; // propagate error
        }
        $s = self::valToHex($values['s']);
        if (isset($s['error']) && $s['error'] === true) {
            return $s; // propagate error
        }
        return ['r' => $r, 's' => $s];
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
            $msg = "Invalid hex input: unable to convert to binary";
            return ["error" => true, "message" => $msg, "code" => 100000];
        }
        $parts = self::parse($der);
        if (isset($parts['error']) && $parts['error'] === true) {
            return $parts; // propagate error
        }
        if (!isset($parts['r']) || !isset($parts['s'])) {
            $msg = 'Unexpected structure: missing r/s hex characters';
            return ["error" => true, "message" => $msg, "code" => 100001];
        }
        // normalize
        $r = self::normalizeTo32Bytes(hex2bin($parts['r']));
        if (isset($r['error']) && $r['error'] === true) {
            return $r; // propagate error
        }
        $s = self::normalizeTo32Bytes(hex2bin($parts['s']));
        if (isset($s['error']) && $s['error'] === true) {
            return $s; // propagate error
        }
        // if all good, replace with normalized values
        $parts['r'] = $r;
        $parts['s'] = $s;
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
        if (isset($parts['error']) && $parts['error'] === true) {
            return $parts;
        }
        return [
            'r' => bin2hex($parts['r']),
            's' => bin2hex($parts['s']),
        ];
    }

    public static function derToPlainSignature(string $hex_sig) {
        $parts = self::parseHexComponents($hex_sig);
        if (isset($parts['error']) && $parts['error'] === true) {
            return $parts;
        }
        return $parts['r'] . $parts['s'];
    }
 
    /**
     * Normalize an integer (raw bytes) to exactly 32 bytes for P-256.
     * - If it has 33 bytes and the first is 0x00 -> remove the 0x00 (positive)
     * - If it has < 32 bytes -> left-pad with zeros
     * - If it has > 32 bytes and first byte != 0x00 -> exception (out of range)
    */
    /**
     * @param string $raw
     * @return string|array
     */
    public static function normalizeTo32Bytes(string $raw) {
        $len = strlen($raw);
        if ($len === 32) {
            return $raw;
        }
        if ($len === 33) {
            // if the first byte is 0x00 we remove it (it was added to indicate positive sign)
            if (ord($raw[0]) === 0x00) {
                $trimmed = substr($raw, 1);
                if (strlen($trimmed) !== 32) {
                    $msg = 'After removing 0x00 the size is not 32 bytes';
                    return ["error" => true, "message" => $msg, "code" => 100000];
                }
                return $trimmed;
            } else {
                $msg = 'Integer of 33 bytes without leading 0x00 — unexpected value';
                return ["error" => true, "message" => $msg, "code" => 100001];
            }
        }
        if ($len < 32) {
            // left-pad with zeros
            return str_repeat("\x00", 32 - $len) . $raw;
        }
        // len > 33 -> out of range
            $msg = "Integer too large for P-256: {$len} bytes";
            return ["error" => true, "message" => $msg, "code" => 100002];
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

        $msg = 'Unexpected value type for hex conversion';
        return ["error" => true, "message" => $msg, "code" => 100003];
    }

}