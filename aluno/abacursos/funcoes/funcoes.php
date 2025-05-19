<?php
function transformarParaEmbed($url)
{
    if (preg_match('/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }
    return $url;
}

?>
