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

/**
 * Returns first property with an attribute that matches the provided name.
 */
function get_property_with_attr(object|null $object, string $attr_name) : ?ReflectionProperty {
    $reflector = new ReflectionClass(get_class($object));
    $properties = $reflector->getProperties();

    return array_find($properties, fn($prop) => (
        count($prop->getAttributes($attr_name)) > 0
    ));
}

function get_attr(object|null $object, string $attr_name) : ?ReflectionAttribute {
    $reflector = new ReflectionClass(get_class($object));
    $attr = $reflector->getAttributes($attr_name);
    return count($attr) > 0? $attr[0] : null;
}

/**
 * Executes callback function for each item in array.
 * Returns the first item that satisfies the callback condition.
 */
function array_find(array $array, Closure $callback_fn) {
    foreach ($array as $value) {
        if ($callback_fn($value)) return $value;
    }
    return null;
}
?>