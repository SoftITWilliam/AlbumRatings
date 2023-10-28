<?php
class CountryModel extends Database {
    public function get_all_countries() {
        $result = new DataResult();
        try {
            $data = $this->select("SELECT * FROM country");
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