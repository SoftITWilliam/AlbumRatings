<?php
class ArtistModel extends Database {

    public function get_artist() : ObjectResult 
    {
        $result = new ObjectResult();
        return $result;
    }

    public static function get_all_artists() : DataResult 
    {
        $result = new DataResult();
        return $result;
    }
}


?>