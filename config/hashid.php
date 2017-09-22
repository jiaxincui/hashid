<?php

return [
    'salt' => env('APP_KEY'), //盐值，默认使用APP_KEY
    'min_hash_length' => 0, //加密字符串的最小长度
    'alphabet' => env('HASH_ID_ALPHABET', 'Fi1yqx4mk3Bda7DfMCjWoOSUHYTRKhuszl2cg5pXLe6AwEGn8NvJ9VtZr0IQbP')
];