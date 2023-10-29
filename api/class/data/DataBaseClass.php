<?php

class DataBaseClass {

    public function __construct(?array $params = null) 
    {
        if($params !== null) {
            $this->apply_params($params);
        }
    }
    
    public function apply_params(array|object $params) 
    {
        $reflection = new ReflectionClass(get_class($this));

        foreach ($params as $key => $value) {

            try {
                $prop = $reflection->getProperty($key);
                $attributes = $prop->getAttributes(DataColumn::class);
                if(count($attributes) > 0) {
                    $this->{$key} = $value;
                }
            }
            catch(Exception $e) { }
        }
    }

    public function get_primary_key_value() 
    {
        $property = get_property_with_attr($this, PrimaryKey::class);

        if($property) {
            try {
                return $property->getValue($this);
            }
            catch(Exception $e) { }
        }
        return null;
    }

    public function get_primary_key_field() 
    {
        $property = get_property_with_attr($this, PrimaryKey::class);
        return $property ? $property->getName() : null;
    }

    public function get_all_columns() 
    {
        $reflector = new ReflectionClass(get_class($this));
        $properties = $reflector->getProperties();

        // Filter out any non-column properties
        $col_props = array_filter($properties, fn(ReflectionProperty $prop) => 
            count($prop->getAttributes(DataColumn::class)) > 0);

        return array_map(fn(ReflectionProperty $prop) => 
            ($prop->getName()), $col_props);
    }

    /**
     * Get object values as array
     * !!! DOES NOT INCLUDE PRIMARY KEY VALUE
     */
    public function get_update_values(): array 
    {
        $properties = $this->get_column_properties();

        $values = [];
        $primary_key_field = $this->get_primary_key_field();
        
        foreach($properties as $prop) {
            if($prop->getName() !== $primary_key_field) {
                $values[] = $prop->getValue($this);
            }
        }

        return $values;
    }

    /**
     * Get object fields as array
     * !!! DOES NOT INCLUDE PRIMARY KEY FIELD
     */
    public function get_update_fields(): array 
    {
        $properties = $this->get_column_properties();

        $fields = [];
        $primary_key_field = $this->get_primary_key_field();
        
        foreach($properties as $prop) {
            if($prop->getName() !== $primary_key_field) {
                $fields[] = $prop->getName();
            }
        }

        return $fields;
    }

    private function get_column_properties() 
    {
        $reflection = new ReflectionClass(get_class($this));
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        // Filter out any non-column properties
        return array_filter($properties, fn(ReflectionProperty $prop) => 
            count($prop->getAttributes(DataColumn::class)) > 0);
    }
}

?>