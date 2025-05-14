<?php
function transformarParaEmbed($url)
{
    if (strpos($url, 'watch?v=') !== false) {
        return preg_replace('/watch\?v=([a-zA-Z0-9_-]+)/', 'embed/$1', $url);
    }
    return $url;
}
?>
