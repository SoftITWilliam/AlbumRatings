<?php
/**
 * Get URI elements.
 */
function get_uri_segments() : array
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    $uri = array_slice($uri, array_search("api", $uri) + 1);
    return $uri;
}

?>