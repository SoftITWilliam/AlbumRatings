<?php
require_once(PROJECT_ROOT_PATH . "/class/data/Country.php");

class CountryModel extends Database {
    public function get_country($country_id) 
    {
        $result = new ObjectResult();
        try {
            $sql = "SELECT * FROM country WHERE id = ?";
            $data = $this->select($sql, "s", [$country_id]);
            if($data != null && count($data) > 0) {
                $result->object = new Country($data[0]);
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
    
    public function get_all_countries() 
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

    public function save_country(array $params) 
    {
        $result = new Result();

        $country = new Country();
        $primary_field = $country->get_primary_key_field();
        if(isset($params[$primary_field])) {
            $country->apply_params($this->get_country($params[$primary_field])->object);
        }
        $country->apply_params($params);

        try {
            $this->save("country", $country);
            $result->info = $country->get_primary_key_value() ? 
                "Successfully edited country" : "Successfully added country";
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