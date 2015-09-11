<?php
function smarty_modifier_sp($str, $args)
{
    if ($args != 1) {
        return $str;
    }

    $mt = MT::get_instance();
    $ctx =& $mt->context();
    $websiteId = $ctx->__stash['blog']->blog_parent_id || 0;

    if ($websiteId) {
        $website = $mt->db()->fetch_blog($websiteId);
        $websiteUrl = $website->site_url;
    } else {
        $websiteUrl = $ctx->__stash['blog']->site_url;
    }

    if (strpos($str, 'http') === FALSE) {
        $path = preg_replace('/https?:\/\/[^\/]+/', '', $websiteUrl);

        if ($path === '/') {
            $str = $path . 'sp' . $str;
        } else if (preg_match('/\/$/', $path)) {
            $str = $path . 'sp/' . str_replace($path, '', $str);
        } else {
            $str = '/sp' . $str;
        }
    } else {
        $str = str_replace($websiteUrl, $websiteUrl . 'sp/', $str);
    }

    return $str;
}
