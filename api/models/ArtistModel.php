<?php

#[TableName("artist")]
class ArtistModel extends Model {
    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;
    #[DataColumn]
    public ?string $description;
    #[DataColumn]
    public ?string $years_active;

    public function get_artist($artist_id) : ObjectResult 
    {
        $result = new ObjectResult();
        try {
            $sql = QueryGenerator::generate_select_query($this);
            $data = $this->select($sql, "s", [$artist_id]);
            if($data != null && count($data) > 0) {
                $this->apply_params($data[0]);
                $result->object = $this;
                $result->success = true;
            }
            else throw new Exception("No data found");
        }
        catch(Exception $e) {
            $result->success = false;
            $result->info = $e->getMessage();
        }
        return $result;
    }

    public function get_all_artists() : DataResult 
    {
        $result = new DataResult();
        try {
            $sql = "SELECT * FROM artist";
            $data = $this->select($sql);
            $result->info = $sql;
            $result->data = $data;
            $result->success = true;
        }
        catch(Exception $e) {
            $result->success = false;
            $result->info = $e->getMessage();
        }
        return $result;
    }

    public function save_artist(array $params) : Result
    {
        $result = new Result();
        $primary_field = $this->get_primary_key_field();
        if(isset($params[$primary_field])) {
            $this->apply_params($this->get_artist($params[$primary_field])->object);
        }
        $this->apply_params($params);

        try {
            $this->save();
            $result->info = "Successfully " . ($this->get_primary_key_value() ? "edited" : "added");
            $result->success = true;
        }
        catch(Exception $e) {
            $result->success = false;
            $result->info = $e->getMessage();
        }
        return $result;
    }
}


?>