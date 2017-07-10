<?php
  include_once 'LibraryService.php';

  class Index {
    private $options;
    private $option;
    private $stop;
    private $libraryService;

    public function __construct() {
      $this->stop = false;
      $this->libraryService = new LibraryService();
    }

    private function printMenu() {
      echo "Enter options 0-4: \n";
      echo "0 - Exit\n";
      echo "1 - Get books\n";
      echo "2 - Get book by title\n";
      echo "3 - Add book\n";
      echo "4 - Delete book\n";
      echo "You choose: \n";
    }

    private function runOption() {
      $this->options[$this->option]();
    }

    private function readOption() {
      $this->option = trim(fgets(STDIN));
    }

    private function initializeOptions() {
      $this->options = array(
        0 => function() { $this->exit(); },
        1 => function() { $this->getBooks(); },
        2 => function() { $this->getBookByTitle(); },
        3 => function() { $this->addBook(); },
        4 => function() { $this->deleteBook(); }
      );
    }

    public function run() {
      $this->initializeOptions();
      $this->loop();
    }

    private function loop() {
      while (!$this->stop) {
        $this->printMenu();
        $this->runOption($this->readOption());
      } 
    }

    private function exit() {
      $this->stop = true;
      echo ">>> BYE BYE\n";
    }

    private function getBooks() {
      echo ">>> List of books \n";
      $this->libraryService->getBooks();
    }

    private function getBookByTitle() {
      echo ">>> Title:\n";
      $title = trim(fgets(STDIN));
      $this->libraryService->getBookByTitle($title);
    }

    private function addBook() {
      echo ">>> Title:\n";
      $title = trim(fgets(STDIN));
      echo ">>> Author:\n";
      $author = trim(fgets(STDIN));
      echo ">>> Price:\n";
      $price = floatval(trim(fgets(STDIN)));
      $this->libraryService->addBook($title, $author, $price); 
    }

    private function deleteBook() {
      echo ">>> Id:\n";
      $id = intval(trim(fgets(STDIN)));
      $this->libraryService->deleteBook($id);  
    }
  }

  $index = new Index();
  $index->run();
?>