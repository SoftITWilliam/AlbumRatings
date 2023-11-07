<?php
require_once(PROJECT_ROOT_PATH . "/models/Model.php");

class QueryGenerator {
    public static function generate_update_query(string $table_name, Model $object) : string
    {
        $primary_key = $object->get_primary_key_field();
        $primary_key_value = $object->get_primary_key_value();
    
        if (!$primary_key && !$primary_key_value) return false;

        $fields = $object->get_update_fields();
        $fields = array_map(fn($field) => ($field . " = ? "), $fields);
        $str_fields = implode(", ", $fields);

        $sql = "UPDATE " . $table_name . " SET " . $str_fields . " WHERE " . $primary_key . " = ?";
        return $sql;
    }

    public static function generate_insert_query(string $table_name, Model $object) : string 
    {
        $fields = $object->get_update_fields();
        $str_fields = implode(", ", $fields);
        
        $placeholders = implode(", ", array_map(fn() => "?", $fields));

        $sql = "INSERT INTO " . $table_name . " (" . $str_fields . ") VALUES (" . $placeholders . ")";
        return $sql;
    }
}

?>