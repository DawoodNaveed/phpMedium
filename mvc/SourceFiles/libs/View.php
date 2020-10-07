<?php
class View {
  function __construct() {
      //echo 'This is the view';
  }
  public function render($name)
  {
      require 'views/' . $name . '.php';
  }
}