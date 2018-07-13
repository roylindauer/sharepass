<?php
namespace Royl\Sharepass;

class Sharepass {
    public $DB;
    public function __construct($DB) {
        $this->DB = $DB;
    }
}