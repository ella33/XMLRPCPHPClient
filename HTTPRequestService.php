<?php
  class HTTPRequestService {
    const URL = 'http://localhost:50431/xml-rpc';
    private $ch;

    private function init() {
      $this->ch = curl_init();
      curl_setopt($this->ch, CURLOPT_URL, self::URL);
      curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    private function exec() {
      $result = curl_exec($this->ch);
      curl_close($this->ch);
      return $result;
    }

    public function post($data) {
      $this->init();
      curl_setopt($this->ch, CURLOPT_POST, true);
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
      return $this->exec();
    } 
  } 
?>