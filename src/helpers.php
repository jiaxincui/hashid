<?php

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
            return null;
        }
        $sign = 0;
        foreach (str_split($int) as $v) {
            $sign += $v;
        }
        $keyArr = str_split(config('hashid.key'));
        $keyLen = count($keyArr);
        $rand = mt_rand(0, $keyLen - 1);
        $str = $keyArr[$rand];
        foreach (str_split(dechex($int)) as $v) {
            $offset = hexdec($v) + $rand;
            $str .= $keyArr[$offset % $keyLen];
        }
        return $str . $keyArr[$sign % $keyLen];
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
        if (! preg_match('/^[0-9a-zA-Z]{2,12}$/', $str)) {
            return null;
        }
        $strArr = str_split($str);
        $key = config('hashid.key');
        $keyArr = str_split($key);
        $keyLen = count($keyArr);
        $hex = '';
        $rand = strpos($key, array_shift($strArr));
        $verfy = array_pop($strArr);
        foreach ($strArr as $v) {
            $hex .= strpos($key, $v) >= $rand ? dechex(strpos($key, $v) - $rand) : dechex($keyLen - $rand + strpos($key, $v));
        }
        $dec = hexdec($hex);
        $decArr = str_split($dec);
        $sign = 0;
        foreach ($decArr as $v) {
            $sign += $v;
        }
        if ($verfy !== $keyArr[$sign % $keyLen]) {
            return null;
        }
        return $dec;
    }
}