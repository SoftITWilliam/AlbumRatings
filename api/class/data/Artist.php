<?php 
require_once(PROJECT_ROOT_PATH . "/class/data/DataBaseClass.php");

class Artist extends DataBaseClass {
    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;
    #[DataColumn]
    public ?string $description;
    #[DataColumn]
    public ?string $years_active;
}
?>