<?php
require __DIR__ . "/inc/bootstrap.php";
require __DIR__ . "/controller/api/CountryController.php";
require __DIR__ . "/controller/api/ArtistController.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$uri = array_slice($uri, array_search("api", $uri) + 1);
// 0 -> "index.php", 1 -> controller name, 2 -> controller method

function error_result(string $info) {
    $r = new Result();
    $r->info = $info;
    echo json_encode($r);
    exit();
}

try {
    $controller = null;

    switch($uri[1]) {
        case "artist":
            $controller = new ArtistController(); break;
            
        case "country": 
            $controller = new CountryController(); break;
    }

    if($controller === null) {
        error_result("Invalid module");
    }

    $str_method_name = $uri[2] . '_action';
    if(method_exists($controller, $str_method_name) === false) {
        error_result("Invalid method: '" . $uri[1] . "/" . $uri[2] . "'");
    }
    $controller->{$str_method_name}();
}

catch(Exception $e) {
    error_result($e->getMessage());
}
?>
