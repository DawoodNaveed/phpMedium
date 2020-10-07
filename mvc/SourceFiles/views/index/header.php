<?php
session_start();?>



<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .error {color: #ff0000;}
    </style>
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h2>BOOK DETAILS Form</h2>
    <p><span class="error">* required field</span></p>
    Name:<br>
    <input type="text" name="name" placeholder="Enter The name" value="">
    <br><br>
    Password:<br>
    <input type="password" name="password" placeholder="Enter The Password" value="">
    <br><br>
    <input type="submit" value="Login"/>
</form>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name=$_POST["name"];
$password=$_POST["password"];
$_SESSION["name"]= $name;
$_SESSION["password"]=$password;
header('location:login/check');
////$_SERVER["DOCUMENT_ROOT"] . "/MediumProject/app/models/User.php";
////$user=new User();
////$user->login($name,$password);
//
//
}
//?>