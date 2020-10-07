<?php
session_start();
class Attendance {
    function __construct()
    {
        echo $_SESSION('timeIn');
    }
}

?>