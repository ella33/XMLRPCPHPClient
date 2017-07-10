<?php
  include_once 'HTTPRequestService.php';
  include_once 'XMLRpcRequest.php';

  class LibraryService {
    private $httpRequestService;
    private $xmlWriter;
    private $xmlRpcRequest;
    private $result;

    public function __construct() {
      $this->httpRequestService = new HTTPRequestService();
      $this->xmlWriter = new XMLWriter();
    }

    private function printXML($xml) {
      $dom = new DOMDocument("1.0");
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;
      $dom->loadXML($xml);
      echo $dom->saveXML();
    } 

    private function printRequest() {
      echo "======== REQUEST ========= \n";
      $this->printXML($this->xmlRpcRequest->xmlDoc->asXML());
    }

    private function printResponse() {
      echo "======== RESPONSE ========= \n";
      $this->printXML($this->result);
    }

    public function addBook($title, $author, $price) {
      $this->xmlRpcRequest = new XMLRpcRequest();
      $this->xmlRpcRequest->addBook($title, $author, $price);
      $xmlData = $this->xmlRpcRequest->xmlDoc;
      $this->result = $this->httpRequestService->post($xmlData->asXML());
      $this->printRequest();
      $this->printResponse();
    }

    public function getBooks() {
      $this->xmlRpcRequest = new XMLRpcRequest();
      $this->xmlRpcRequest->getBooks();
      $xmlData = $this->xmlRpcRequest->xmlDoc;
      $this->result = $this->httpRequestService->post($xmlData->asXML());
      $this->printRequest();
      $this->printResponse();
    }

    public function getBookByTitle($title) {
      $this->xmlRpcRequest = new XMLRpcRequest();
      $this->xmlRpcRequest->getBookByTitle($title);
      $xmlData = $this->xmlRpcRequest->xmlDoc;
      $this->result = $this->httpRequestService->post($xmlData->asXML());
      $this->printRequest();
      $this->printResponse();
    }

    public function deleteBook($id) {
      $this->xmlRpcRequest = new XMLRpcRequest();
      $this->xmlRpcRequest->deleteBook($id);
      $xmlData = $this->xmlRpcRequest->xmlDoc;
      $this->result = $this->httpRequestService->post($xmlData->asXML());
      $this->printRequest();
      $this->printResponse();
    }
  }
?>