<?php

class DataBaseClass {
    public function get_primary_key() {
        $property = get_property_with_attr($this, "PrimaryKey");

        if($property) {
            try {
                return $property->getValue($this);
            }
            catch(Exception $e) { }
        }
        return null;
    }
}

?>