<?php

namespace Jiaxincui\Hashid\Traits;


trait Hashid
{
    /**
     * ID访问器
     * @param $value
     * @return null|string
     */
    public function getIdAttribute($value)
    {
        return id_encode($value);
    }
}