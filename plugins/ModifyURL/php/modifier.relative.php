<?php
function smarty_modifier_relative($str, $args)
{
    if ($args != 1) {
        return $str;
    }

    return preg_replace('/https?:\/\/[^\/]+/', '', $str);
}
