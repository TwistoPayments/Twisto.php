<?php

namespace Twisto;


interface BaseAddress
{
    const TYPE_FULL = 1;
    const TYPE_SHORT = 2;

    /**
     * @return array
     */
    function serialize();
    static function deserialize($data);
}
