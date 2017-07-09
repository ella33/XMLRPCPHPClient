<?php
  class XMLRpcRequest {
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



    private function init() {
      $this->xmlDoc = new DOMDocument();

      //create the root element
      $this->root = $this->xmlDoc->appendChild($this->xmlDoc->createElement(METHOD_CALL));
             
      //make the output pretty
      $this->xmlDoc->formatOutput = true;
    }

    private function saveXML() {
      $this->xmlDoc->saveXML();
    }

    private function addMethodName($name) {
      $this->root->appendChild($this->xmlDoc->createElement(METHOD_NAME), $name);
    }

    private function addMetodParams($params) {
      $params = $this->root->appendChild($this->xmlDoc->createElement(PARAMS)); 
      $param = $params->appendChild($this->xmlDoc->createElement(PARAM));

      if (is_object($params->value)) {
        $value = $param->appendChild($this->xmlDoc->createElement(VALUE));
        $bookNode = $value->appendChild($this->xmlDoc->createElement(BOOK_NODE['ROOT']));
        $bookNode->appendChild(
          $this->xmlDoc->createElement(BOOK_NODE['TITLE'], $params->value->title));
        $bookNode->appendChild(
          $this->xmlDoc->createElement(BOOK_NODE['AUTHOR'], $params->value->author));
        $bookNode->appendChild(
          $this->xmlDoc->createElement(BOOK_NODE['PRICE'], $params->value->price));
      } else {
        $value = $param->appendChild($this->xmlDoc->createElement(VALUE, $params->value));
      }
      $value->setAttribute(TYPE, $params->type);
    }

    public function addBook($title, $author, $price) {
      init();
      addMethodName(ADD_BOOK);
      addMethodParams(new Param(
        new Book(null, $title, $author, $price)), PARAM_TYPES['XML']);
      saveXML();
    }

    public function deleteBook($id) {
      init();
      addMethodName(DELETE_BOOK);
      addMethodParams(new Param($id, PARAM_TYPES['INT']));
      saveXML();
    }

    public function getBooks() {
      init();
      addMethodName(GET_BOOKS);
      saveXML();
    }

    public function getBookByTitle($title) {
      init();
      addMethodName(GET_BOOK_BY_TITLE);
      addMethodParams(new Param($title, PARAM_TYPES['STRING']));
      saveXML();
    }
  }