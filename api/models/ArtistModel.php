<?php
require_once(PROJECT_ROOT_PATH . "/models/ModelUtil.php");

#[TableName("artist")]
class ArtistModel extends Model implements IStandardModel {
    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;
    #[DataColumn]
    public ?string $description;
    #[DataColumn]
    public ?string $years_active;

    public function get($artist_id) : ObjectResult 
    {
        return $this->std_get($artist_id);
    }

    public function get_all() : DataResult 
    {
        return $this->std_get_all();
    }

    public function save(array $params) : Result
    {
        update_model($this, $params, $this->get_primary_key_field());
        return $this->std_save();
    }
}
?>