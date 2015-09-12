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

        $cfg = $mt->db()->fetch_plugin_data('ModifyURL', 'configuration:blog:' . $websiteId);
        $path = $cfg['path_setting'];
    } else {
        $websiteUrl = $ctx->__stash['blog']->site_url;

        $cfg = $mt->db()->fetch_plugin_data('ModifyURL', 'configuration:blog:' . $ctx->__stash['blog_id']);
        $path = $cfg['path_setting'];
    }

    if (strpos($str, 'http') === FALSE) {
        $blog_path = preg_replace('/https?:\/\/[^\/]+/', '', $websiteUrl);

        if ($blog_path === '/') {
            $str = $blog_path . $path . $str;
        } else if (preg_match('/\/$/', $blog_path)) {
            $str = $blog_path . $path . '/' . str_replace($blog_path, '', $str);
        } else {
            $str = '/' . $path . $str;
        }
    } else {
        $str = str_replace($websiteUrl, $websiteUrl . $path . '/', $str);
    }

    return $str;
}
