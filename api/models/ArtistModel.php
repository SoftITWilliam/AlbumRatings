<?php
class ArtistModel extends Database {

    public static function get_artist() {
        $result = new Result();
        echo json_encode($result);
    }

    public static function get_all_artists() {

    }
}


?>