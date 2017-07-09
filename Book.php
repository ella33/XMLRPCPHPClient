<?php
class Book {
  public $id;
  public $title;
  public $author;
  public $price;

  public function __construct($id = NULL, $title, $author, $price) {
    if ($id != NULL) {
      $this->id = $id;
    }
    $this->title = $title;
    $this->author = $author;
    $this->price = $price;
  }
}