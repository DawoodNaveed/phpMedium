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




<form method="post" action="editEmployee">
    <h2>BOOK DETAILS Form</h2>
    <p><span class="error">* required field</span></p>
    Name:<br>
    <input type="text" name="name" value="<?php echo $_SESSION["name"]?>">

    <br><br>
    Password:<br>
    <input type="password" name="password" value="<?php echo $_SESSION["password"];?>">

    <br><br>
    Department:<br>
    <input type="text" name="department" value="<?php echo $_SESSION["department"];?>">

    <br><br>
    Salary:<br>
    <input type="text" name="salary" value="<?php echo $_SESSION["salary"];?>">

    <br><br>
    email:<br>
    <input type="text" name="email" value="<?php echo $_SESSION["email"];?>">

    <br><br>
    Boss:<br>
    <?php
    $desig="";
    $empBoss="";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/mvc/SourceFiles/models/user.php";
    $user=new User();
    $empBoss=$user->getBoss();
    $desig=$user->getDesignation();

    ?>
    <select name="Boss">
        <?php echo '<option>'.$_SESSION["boss"].'</option>'?>
        <?php
        foreach($empBoss as $val)
        {
            if($val!=$_SESSION["boss"]) {
                echo '<option>' . $val . '</option>';
            }
        }
        ?>
    </select>

    <br><br>
    Designation:<br>

    <select name="designation">
        <?php echo '<option>'. $_SESSION["designation"].'</option>'?>
        <?php

        foreach($desig as $a)
        {
            if($a!=$_SESSION["designation"]) {
                echo '<option>' . $a . '</option>';
            }
        }
        ?>
    </select>


    <br><br>
    <img id="img" src="<?php echo URL?>public/images/<?php echo $_SESSION["picture"] ?>" />
    <br>
    <br>
    Image:
    <input type="file" name="image" id="image" />

    <br><br>
    <input type="submit" name="submit" value="Submit">

</form>



</body>
</html>






