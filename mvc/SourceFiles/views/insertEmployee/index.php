<?php
// Start the session
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="/MediumProject/public/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .error {color: #ff0000;}
        #img{
            height: 150px;
            width: 200px;
        }
    </style>
</head>
<body>




<form method="post" action="insert">
    <h2>BOOK DETAILS Form</h2>
    <p><span class="error">* required field</span></p>
    Name:<br>
    <input type="text" name="name" value="">

    <br><br>
    Password:<br>
    <input type="password" name="password" value="">

    <br><br>
    Department:<br>
    <input type="text" name="department" value="">

    <br><br>
    Salary:<br>
    <input type="text" name="salary" value="">

    <br><br>
    email:<br>
    <input type="text" name="email" value="">

    <br><br>
    Boss:<br>
    <?php
    $desig="";
    $empBoss="";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/mvc/Source Files/models/user.php";
    $user=new User();
    $empBoss=$user->getBoss();
    $desig=$user->getDesignation();

    ?>
    <select name="Boss">
        <?php
        foreach($empBoss as $val)
        {

                echo '<option>' . $val . '</option>';

        }
        ?>
    </select>

    <br><br>
    Designation:<br>

    <select name="designation">

        <?php

        foreach($desig as $a)
        {

                echo '<option>' . $a . '</option>';

        }
        ?>
    </select>


    <br><br>

    Image:
    <input type="file" name="image" id="image" />

    <br><br>
    <input type="submit" name="submit" value="Submit">

</form>



</body>
</html>






