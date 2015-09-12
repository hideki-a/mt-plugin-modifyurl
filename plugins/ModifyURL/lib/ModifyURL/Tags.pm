package ModifyURL::Tags;
use strict;
use MT::Blog;

sub _hdlr_relativeurl {
    my ($str, $arg, $ctx) = @_;
    return $str if $arg != 1;

    $str =~ s/https?:\/\/[^\/]+//;

    return $str;
}

sub _hdlr_smartphone {
    my ($str, $arg, $ctx) = @_;
    return $str if $arg != 1;

    my $blog = $ctx->stash('blog') || return;
    my $website_id = $blog->parent_id || 0;
    my $website_url;
    my $plugin = MT->component('ModifyURL');
    my $path;

    if ($website_id == 0) {
        $website_url = $blog->site_url;
        $path = $plugin->get_config_value('path_setting', 'blog:' . $ctx->stash('blog_id'));
    } else {
        my $website = MT::Blog->load($website_id) || return;
        $website_url = $website->site_url;
        $path = $plugin->get_config_value('path_setting', 'blog:' . $website_id);
    }

    if ($str =~ /^http/) {
        $str =~ s/($website_url)/$1$path\//;
    } else {
        (my $blog_path = $website_url) =~ s/https?:\/\/[^\/]+//;
        $str =~ s/($blog_path)/$1$path\// . $str;
    }

    return $str;
}

1;
