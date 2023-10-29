<?php
require_once(PROJECT_ROOT_PATH . "/class/data/Artist.php");
class ArtistModel extends Database {

    public function get_artist($artist_id) : ObjectResult 
    {
        $result = new ObjectResult();
        try {
            $sql = "SELECT * FROM artist WHERE id = ?";
            $data = $this->select($sql, "s", [$artist_id]);
            if($data != null && count($data) > 0) {
                $result->object = new Artist($data[0]);
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

    public function save_artist(array $params) 
    {
        $result = new Result();

        $artist = new Artist();
        $primary_field = $artist->get_primary_key_field();
        if(isset($params[$primary_field])) {
            $artist->apply_params($this->get_artist($params[$primary_field])->object);
        }
        $artist->apply_params($params);

        try {
            $this->save("artist", $artist);
            $result->info = $artist->get_primary_key_value() ? 
                "Successfully edited artist" : "Successfully added artist";
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