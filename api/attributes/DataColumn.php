<?php

#[Attribute]
class DataColumn {
    public $column;
    public function __construct($column) {
        $this->column = $column;
    }
}

?>