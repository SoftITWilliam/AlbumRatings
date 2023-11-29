<?php
require_once(PROJECT_ROOT_PATH . "/models/ModelUtil.php");

#[TableName("country")]
class Country extends Model implements IStandardModel {

    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public string $name;
    #[DataColumn]
    public string $code;

    public function get($country_id) : ObjectResult
    {
        return $this->std_get($country_id);
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

    public function search($value) : DataResult 
    {
        $table = table_name_of(Country::class);
        $sql = "SELECT * FROM $table 
            WHERE name LIKE ? 
            LIMIT 20";
        $data = $this->select($sql, "s", ["%$value%"]);
        return DataResult::from_data($data);
    }
}
?>