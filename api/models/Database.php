<?php
class Database {
    protected $connection = null;

    public function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }			
    }

    protected function select(string $query = "", ?string $types = null, $values = []) {
        try {
            $stmt = $this->execute_statement($query, $types, $values);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();
            return $result;
        } 
        catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }

    private function execute_statement(string $query = "", ?string $types = null, $values = []): mysqli_stmt
    {
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            if($types !== null && count($values) > 0) {
                $stmt->bind_param($types, ...$values);
            }
            $stmt->execute();
            return $stmt;
        } 
        catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }

    protected function save(string $table_name, DataBaseClass $object): mysqli_stmt {

        $primary_key = $object->get_primary_key_value();

        if(!$primary_key) {
            return $this->insert($table_name, $object);
        }
        else {
            return $this->update($table_name, $object);
        }
    }

    protected function insert(string $table_name, DataBaseClass $object): mysqli_stmt 
    {
        $sql = $this->generate_insert_query($table_name, $object);
        echo $sql;

        // Construct an array with values to bind
        $insert_values = $object->get_update_values();
        $types = str_repeat('s', count($insert_values));

        $stmt = $this->execute_statement($sql, $types, $insert_values);
        return $stmt;
    }

    protected function update(string $table_name, DataBaseClass $object): mysqli_stmt 
    {
        $sql = $this->generate_update_query($table_name, $object);

        // Construct an array with values to bind
        $update_values = $object->get_update_values();
        $update_values[] = $object->get_primary_key_value();

        $types = str_repeat('s', count($update_values));

        $stmt = $this->execute_statement($sql, $types, $update_values);
        return $stmt;
    }
    

    private function generate_update_query(string $table_name, DataBaseClass $object) : string
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

    private function generate_insert_query(string $table_name, DataBaseClass $object) : string 
    {
        $fields = $object->get_update_fields();
        $str_fields = implode(", ", $fields);
        
        $placeholders = implode(", ", array_map(fn() => "?", $fields));

        $sql = "INSERT INTO " . $table_name . " (" . $str_fields . ") VALUES (" . $placeholders . ")";
        return $sql;
    }
}

?>