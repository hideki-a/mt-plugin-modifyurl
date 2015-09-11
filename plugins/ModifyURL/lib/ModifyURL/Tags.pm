package ModifyURL::Tags;
use strict;

sub _hdlr_relativeurl {
    my ($str, $arg, $ctx) = @_;
    return $str if $arg != 1;

    $str =~ s/https?:\/\/[^\/]+//;

    return $str;
}

sub _hdlr_smartphone {
    my ($str, $arg, $ctx) = @_;
    return $str if $arg != 1;

    if ($str =~ /^http/) {
        $str =~ s/http(s)?:\/\/([^\/]+)/http$1:\/\/$2\/sp/;
    } else {
        $str = '/sp' . $str;
    }

    return $str;
}

1;
