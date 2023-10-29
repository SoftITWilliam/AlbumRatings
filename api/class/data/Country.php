<?php
require_once(PROJECT_ROOT_PATH . "/class/data/DataBaseClass.php");

class Country extends DataBaseClass {
    #[DataColumn("id"), PrimaryKey]
    public $id;
    #[DataColumn("name")]
    public ?string $name;
}
?>