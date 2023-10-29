<?php 
require_once(PROJECT_ROOT_PATH . "/class/data/DataBaseClass.php");

class Artist extends DataBaseClass {
    #[DataColumn("id"), PrimaryKey]
    public $id;
    #[DataColumn("name")]
    public ?string $name;
    #[DataColumn("description")]
    public ?string $description;
    #[DataColumn("years_active")]
    public ?string $years_active;
}
?>