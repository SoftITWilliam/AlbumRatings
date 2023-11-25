<?php
require_once(PROJECT_ROOT_PATH . "/models/ModelUtil.php");

#[TableName("primary_genre")]
class PrimaryGenreModel extends Model implements IStandardModel {

    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;

    public function get($primary_genre_id) : ObjectResult
    {
        return $this->std_get($primary_genre_id);
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

    public function get_subgenres($primary_genre_id) : DataResult 
    {
        $genre_table = table_name_of(GenreModel::class);
        $primary_genre_table = table_name_of(PrimaryGenreModel::class);

        $sql = "SELECT g.id, g.name, g.primary_genre_id, p.name as primary_genre_name
                FROM $genre_table AS g
                JOIN $primary_genre_table AS p
                    ON p.id = g.primary_genre_id
                WHERE g.primary_genre_id = ?";

        $data = $this->select($sql, "s", [$primary_genre_id]);
        $result = DataResult::from_data($data);
        if($result->success) $result->info = $sql;
        return $result;
    }
}
?>