<?php

class NixFifty_CacheControl_Listen
{
    public static function loadClass($class, array &$extend)
    {
        $extend[] = 'NixFifty_CacheControl_' . $class;
    }
}