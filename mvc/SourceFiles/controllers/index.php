<?php
 class Index extends Controller {
     function __construct() {
         parent::__construct();
             //echo 'Helo';
         $this->view->render('index/header');

     }
     public function other() {
         //echo 'we are in other';
     }
 }