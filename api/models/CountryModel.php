<?php
class CountryModel extends Database {
    public function get_country($country_id) 
    {
        $result = new ObjectResult();
        try {
            $sql = "SELECT * FROM country WHERE id = ?";
            $data = $this->select($sql, ["s", $country_id]);
            if($data != null && count($data) > 0) {
                $result->object = $data[0];
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
}
?>