<?php

class CountryModel extends Model {

    #[DataColumn, PrimaryKey]
    public $id;
    #[DataColumn]
    public ?string $name;

    public function get_country($country_id) : ObjectResult
    {
        $result = new ObjectResult();
        try {
            $sql = "SELECT * FROM country WHERE id = ?";
            $data = $this->select($sql, "s", [$country_id]);
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
    
    public function get_all_countries() : DataResult
    {
        $result = new DataResult();
        try {
            $sql = "SELECT * FROM country";
            $data = $this->select($sql);
            $result->data = $data;
            $result->success = true;
        }
        catch(Exception $e) {
            $result->success = false;
            $result->info = $e->getMessage();
        }
        return $result;
    }

    public function save_country(array $params) : Result
    {
        $result = new Result();

        $primary_field = $this->get_primary_key_field();
        if(isset($params[$primary_field])) {
            $this->apply_params($this->get_country($params[$primary_field])->object);
        }
        $this->apply_params($params);

        try {
            $this->save("country", $this);
            $result->info = "Successfully " . ($this->get_primary_key_value() ? "edited" : "added") . " Country";
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