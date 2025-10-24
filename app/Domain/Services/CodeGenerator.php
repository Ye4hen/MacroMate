<?php

namespace App\Domain\Services;

class CodeGenerator
{
    public function generateCode(int $length = 6): string
    {
        $bytes = random_bytes($length);

        return self::base62Encode($bytes);
    }

    private static function base62Encode(string $data): string
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $value = gmp_init(bin2hex($data), 16);

        $out = '';

        while (gmp_cmp($value, 0)) {
            list($value, $rem) = gmp_div_qr($value, 62);
            $out .= $chars[gmp_intval($rem)];
        }

        return str_pad($out, (int)(strlen($data) * 8 / log(62)), '0', STR_PAD_LEFT);
    }
}
