<?php
class Param {
  public $value;
  public $type;

  public function __construct($value, $type) {
    $this->value = $value;
    $this->type = $type;
  }
}