<?php
require_once(PROJECT_ROOT_PATH . "/models/ModelUtil.php");

#[TableName("genre")]
class GenreModel extends Model implements IStandardModel {

    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;
    #[DataColumn]
    public ?string $description;

    public function get($genre_id) : ObjectResult
    {
        return $this->std_get($genre_id);
    }

    public function get_subgenres($genre_id) : DataResult 
    {
        $genre_table = table_name_of(GenreModel::class);

        $sql = "SELECT * FROM $genre_table WHERE parent_id = ?";

        $data = $this->select($sql, "s", [$genre_id]);
        $result = DataResult::from_data($data);
        return $result;
    }

    public function get_subgenre_tree($genre_id) : DataResult
    {
        $genre_table = table_name_of(GenreModel::class);

        $sql = "WITH RECURSIVE genre_tree AS (
                    SELECT id, parent_id, name, description
                    FROM $genre_table
                    WHERE id = ?
                    UNION ALL
                    SELECT g.id, g.parent_id, g.name
                    FROM $genre_table g
                    JOIN genre_tree gh ON g.parent_id = gh.id
                )
                SELECT id, parent_id, name, description
                FROM genre_tree;";

        $data = $this->select($sql, "s", [$genre_id]);
        $result = DataResult::from_data($data);
        return $result;
    }

    public function get_top_level_genre($genre_id) : ObjectResult
    {
        $genre_table = table_name_of(GenreModel::class);

        $sql = "WITH RECURSIVE GenreHierarchy AS (
                    SELECT id, parent_id, name, description
                    FROM $genre_table
                    WHERE id = ? 
                    UNION ALL
                    SELECT g.id, g.parent_id, g.name
                    FROM $genre_table g
                    JOIN GenreHierarchy gh ON g.id = gh.parent_id
                )
                SELECT id, name, description
                FROM GenreHierarchy
                WHERE parent_id IS NULL";

        $data = $this->select($sql, "s", [$genre_id]);
        $result = ObjectResult::from_data($data);
        return $result;
    }

    public function get_ancestors($genre_id) : DataResult
    {
        $genre_table = table_name_of(GenreModel::class);

        $sql = "WITH RECURSIVE genre_ancestors AS (
                    SELECT id, parent_id, name, description
                    FROM $genre_table
                    WHERE id = ?
                    UNION ALL
                    SELECT g.id, g.parent_id, g.name, g.description
                    FROM $genre_table g
                    JOIN genre_ancestors ga ON g.id = ga.parent_id
                )
                SELECT id, parent_id, name
                FROM genre_ancestors;";

        $data = $this->select($sql, "s", [$genre_id]);
        $result = DataResult::from_data($data);
        return $result;
    }

    public function get_all_top_level_genres() : DataResult
    {
        $genre_table = table_name_of(GenreModel::class);

        $sql = "SELECT id, name, description
                FROM $genre_table
                WHERE parent_id IS NULL";

        $data = $this->select($sql);
        $result = DataResult::from_data($data);
        return $result;
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