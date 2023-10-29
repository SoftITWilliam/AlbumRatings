<?php
require_once(PROJECT_ROOT_PATH . "/class/data/DataBaseClass.php");

class Country extends DataBaseClass {
    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;
}
?>