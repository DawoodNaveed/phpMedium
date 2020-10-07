<?php
class Conn
{
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here.
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {

        if (self::$instance === null)
        {
            $servername = "localhost";
            $username = "root";
            $password = "Dawood123";

            try {
                //self::$instance = new Singleton();
                self::$instance= new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
                // set the PDO error mode to exception
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // echo "Connected successfully";
            } catch(PDOException $e) {

                echo "Connection failed: " . $e->getMessage();
            }
        }

        return self::$instance;
    }
}
