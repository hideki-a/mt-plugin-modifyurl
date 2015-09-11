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

    if ($website_id == 0) {
        $website_url = $blog->site_url;
    } else {
        my $website = MT::Blog->load($website_id) || return;
        $website_url = $website->site_url;
    }

    if ($str =~ /^http/) {
        $str =~ s/($website_url)/$1sp\//;
    } else {
        (my $path = $website_url) =~ s/https?:\/\/[^\/]+//;
        $str =~ s/($path)/$1sp\// . $str;
    }

    return $str;
}

1;
