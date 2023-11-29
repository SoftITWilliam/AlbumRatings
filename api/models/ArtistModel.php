<?php
require_once(PROJECT_ROOT_PATH . "/models/ModelUtil.php");

#[TableName("artist")]
class Artist extends Model implements IStandardModel {
    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;
    #[DataColumn]
    public ?string $description;
    #[DataColumn]
    public ?string $years_active;
    #[DataColumn]
    public ?string $sorting_name;

    public function get($artist_id) : ObjectResult 
    {
        return $this->std_get($artist_id);
    }

    public function get_all() : DataResult 
    {
        $table = table_name_of(Artist::class);
        $sql = "SELECT * FROM $table ORDER BY COALESCE(NULLIF(sorting_name, ''), name)";
        $data = $this->select($sql);
        return DataResult::from_data($data);
    }

    public function save(array $params) : Result
    {
        update_model($this, $params, $this->get_primary_key_field());
        return $this->std_save();
    }

    public function get_countries_for($artist_id) : array 
    {
        $country_table = table_name_of(Country::class);

        $sql = "SELECT country.* FROM artist_country_xref AS xref
                JOIN $country_table AS country ON country.code = xref.country_code
                WHERE xref.artist_id = ?";

        $data = $this->select($sql, "s", [$artist_id]);
        return $data;
    }
}
?>