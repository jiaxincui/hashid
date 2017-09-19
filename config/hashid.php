<?php
/**
 * key为0-9a-zA-Z的不重复字符串,最少16位,最多62位,推荐62位.
 * 可使用str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')对现有字符串重新生成复制到这里.
 */

return [
    'key' => env('HASH_ID_KEY', 'Fi1yqx4mk3Bda7DfMCjWoOSUHYTRKhuszl2cg5pXLe6AwEGn8NvJ9VtZr0IQbP')
];