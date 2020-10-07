<?php
session_start();
?>
<?php

 class Model {
     function __construct() {

     }
     public function login($name) {
         echo 'helo';
         require 'models/user';

     }
 }