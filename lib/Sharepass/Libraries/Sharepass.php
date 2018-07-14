<?php
namespace Royl\Sharepass\Libraries;

class Sharepass {
    public $DB;
    public function __construct($DB) {
        $this->DB = $DB;
    }
}