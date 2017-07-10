<?php
  include_once 'Param.php';
  include_once 'Book.php';

  class XMLRpcRequest {
    const XML_ROOT          = '<?xml version="1.0"?><methodCall></methodCall>';
    const METHOD_CALL       = 'methodCall';
    const METHOD_NAME       = 'methodName';
    const BOOK_NODE         = array(
      'ROOT'   => 'Book',
      'TITLE'  => 'Title',
      'AUTHOR' => 'Author',
      'PRICE'  => 'Price'
    );
    const PARAMS            = 'params';
    const PARAM             = 'param';
    const VALUE             = 'value';
    const TYPE              = 'type';
    const PARAM_TYPES       = array(
      'INT'    => 'int',
      'STRING' => 'string',
      'XML'    => 'xml'
    );
    const ADD_BOOK          = 'AddBook';
    const DELETE_BOOK      = 'DeleteBook';
    const GET_BOOK_BY_TITLE = 'GetBookByTitle';
    const GET_BOOKS         = 'GetBooks';

    public $xmlDoc;

    public function __construct() {
      $this->xmlDoc = new SimpleXMLElement(self::XML_ROOT);
    }

    private function addMethodName($name) {
      $this->xmlDoc->addChild(self::METHOD_NAME, $name);
    }

    private function addBookParam($book, $value) {
      $bookNode = $value->addChild(self::BOOK_NODE['ROOT']);
      $bookNode->addChild(self::BOOK_NODE['TITLE'], $book->title);
      $bookNode->addChild(self::BOOK_NODE['AUTHOR'], $book->author);
      $bookNode->addChild(self::BOOK_NODE['PRICE'], $book->price);
    }

    private function addMethodParams($parameters) {
      $params = $this->xmlDoc->addChild(self::PARAMS);
      $param = $params->addChild(self::PARAM);

      if (is_object($parameters->value)) {
        $value = $param->addChild(self::VALUE);
        $this->addBookParam($parameters->value, $value);
      } else {
        $value = $param->addChild(self::VALUE, $parameters->value);
      }
      $value->addAttribute(self::TYPE, $parameters->type);
    }

    public function addBook($title, $author, $price) {
      $this->addMethodName(self::ADD_BOOK);
      $this->addMethodParams(new Param(
        new Book(null, $title, $author, $price), self::PARAM_TYPES['XML']));
    }

    public function deleteBook($id) {
      $this->addMethodName(self::DELETE_BOOK);
      $this->addMethodParams(new Param($id, self::PARAM_TYPES['INT']));
    }

    public function getBooks() {
      $this->addMethodName(self::GET_BOOKS);
    }

    public function getBookByTitle($title) {
      $this->addMethodName(self::GET_BOOK_BY_TITLE);
      $this->addMethodParams(new Param($title, self::PARAM_TYPES['STRING']));
    }
  }
?>
