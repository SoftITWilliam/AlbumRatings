<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";
// include global constant values
require_once PROJECT_ROOT_PATH . "/inc/const.php";
// include base controller
require_once PROJECT_ROOT_PATH . "/controller/api/BaseController.php";
// include result classes
require_once PROJECT_ROOT_PATH . "/class/results/Result.php";
require_once PROJECT_ROOT_PATH . "/class/results/DataResult.php";
require_once PROJECT_ROOT_PATH . "/class/results/ObjectResult.php";

require_once PROJECT_ROOT_PATH . "/models/Database.php";
?>
