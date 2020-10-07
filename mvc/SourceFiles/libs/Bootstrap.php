<?php

 class Bootstrap {
     function __construct()
     {

         $url = isset($_GET['url']) ? $_GET['url'] : null;
         $url = explode('/', $url);
         // $url=explode('.php',$url);
         //echo '/controllers/' .$url[0];
         if(empty($url[0]))
         {
             require 'controllers/index.php';
             $controller=new Index();
             return false;
         }


             // print_r($url);
             //echo $url;

             $file = 'controllers/' . $url[0] . '.php';

             if (file_exists($file)) {
                 require 'controllers/' . $url[0] . '.php';
             } else {
                 // require 'controllers/errors';

             }
             $controller = new $url[0];

             if (isset($url[1])) {
                 $controller->{$url[1]}();
                 //$controller->function();
             }
         }

 }