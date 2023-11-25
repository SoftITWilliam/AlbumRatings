<?php
class ObjectResult extends Result {
    public $object = null;

    static function from_data(array $data) : ObjectResult {
        $result = new ObjectResult();

        if($data == null || count($data) == 0) {
            $result->success = false;
            $result->info = "No result was found";
        } 
        else {
            $result->success = true;
            $result->object = $data[0];
        }
        return $result;
    }
}
?>