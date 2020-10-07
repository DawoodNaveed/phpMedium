<?php
session_start();?>



<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css">


    <style>
        .error {color: #ff0000;}
    </style>
</head>
<body>
<form method="post" action="timeIn">
    <h2>Attendance Form</h2>
    <p><span class="error">* required field</span></p>
    Time in:<br>
    <textarea name="timeIn" id="timeIn" rows="2" cols="10"></textarea>
    <br>
    <input type="submit" name="insertingTimeIn"  id="insertingTimeIn" value="SAVE"/>
    <br><br>
</form>
<br>
<form method="post" action="timeOut" id="timeoutForm">
    Time Out:<br>
    <textarea name="timeOut" id="timeOut" rows="2" cols="10"></textarea>
    <br><br>
    <input type="submit" id="insertingTimeOut" value="SAVE"/>
</form>
<br>
<a href="logout/logout" >Logout</a>
</body>

