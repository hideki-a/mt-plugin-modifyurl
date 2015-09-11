<?php
function smarty_modifier_sp($str, $args)
{
    if ($args != 1) {
        return $str;
    }

    if (strpos($str, 'http') === FALSE) {
        $str = '/sp' . $str;
    } else {
        $str = preg_replace('/http(s)?:\/\/([^\/]+)/', 'http$1://$2/sp', $str);
    }

    return $str;
}
