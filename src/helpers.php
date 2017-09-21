<?php
use Jiaxincui\Hashid\Exceptions\HashidException;
use Hashids\Hashids;

if (! function_exists('id_encode')) {
    /**
     * 加密正整数
     *
     * @param $int
     * @return string | null
     */
    function id_encode($int)
    {
        if (! is_numeric($int) || $int < 0 || ! is_int($int + 0)) {
            throw new HashidException('Only positive integers can be accepted!');
        }
        $hashid = new Hashids(config('hashid.salt'), config('hashid.min_hash_length'), config('hashid.alphabet'));
        return $hashid->encode($int);
    }
}

if (! function_exists('id_decode')) {
    /**
     * 对加密后的字符串解密
     *
     * @param $str
     * @return Number | null
     */
    function id_decode($str)
    {
        if (! preg_match('/^[0-9a-zA-Z]{2,18}$/', $str)) {
            throw new HashidException('Bad parameter! Between 2-18 characters');
        }
        $hashid = new Hashids(config('hashid.salt'), config('hashid.min_hash_length'), config('hashid.alphabet'));
        $result = $hashid->decode($str);
        if (count($result) !== 1) {
            throw new HashidException('Unable to decrypt!');
        }
        return $result[0];
    }
}