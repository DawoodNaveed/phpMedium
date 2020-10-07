<?php

$servername = "localhost";
$username = "root";
$password = "Dawood123";
echo $count=0;
   try {
    //self::$instance = new Singleton();
    $conn= new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     //echo "Connected successfully";
   } catch(PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
    }
      $date=DATE('Y-m-d');


      $sql=" SELECT * FROM Employees where empId
             NOT IN( SELECT  Employees.empId FROM Employees LEFT JOIN attendance
             ON Employees.empId=attendance.employeeId
             where attendance.attendance_date='$date')";

      $employee=[];
        foreach ($conn->query($sql) as $row) {
            $employee["id.$count"]=$row["empId"];
            $msg = "You did not mark the attendance yet";


            mail($row["email"],"Did not mark",$msg);
            $count++;
        }
        $i=0;foreach ($conn->query($sql) as $row) {
            $employee["id.$count"]=$row["empId"];
            $msg = "You did not mark the attendance yet";


            mail($row["email"],"Did not mark",$msg);
            $count++;
        }

        while($i<$count){
            $id=$employee["id.$i"];
            $leave=true;
            try {

                $sql = "INSERT INTO attendance (employeeId,onleave,attendance_date)

                VALUES ('$id','$leave','$date')";

                // use exec() because no results are returned
                $conn->exec($sql);

                echo "New record created successfully";
            }
            catch
            (PDOException $e) {
                $e->getMessage();
            }
            $i++;
        }

        echo 'helo';
        echo $i;
        echo $count;
            while($i<$count){
                echo 'jelo';
                $id=$employee["id.$i"];
                $leave=true;
                try {

                    $sql = "SELECT a.empId ,a.employeeName,
                            ,b.email FROM Employees a, Employees b
                             WHERE a.boss = b.employeeName AND a.empId='$id'";
                    foreach ($conn->query($sql) as $row) {
                        echo $row["empId"];
                        echo $row["employeeName"];
                        echo $row["email"];
                    }
                   } catch (PDOException $e) {
                                       $e->getMessage();
                     }

                $i++;
            }