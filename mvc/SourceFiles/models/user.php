<?php
session_start();
require 'conn.php';
?>

<?php
class User extends Model {
    function __construct() {
        //echo 'Helo in user class';
    }
    public function login() {
        $name= $_SESSION["name"];
        $password=$_SESSION["password"];
        $conn=Conn::getInstance();
        $sql = "SELECT empDesignation.designationName,Employees.empId FROM empDesignation left join Employees
                  ON empDesignation.id=Employees.Designation
                   where employeeName='$name' AND password='$password'  ";

        foreach ($conn->query($sql) as $row) {

            $_SESSION["employeeDesignationId"] =$row['designationName'];
            $_SESSION["loginId"]=$row['empId'];
            return true;
        }
        return false;
    }
    public function insertTimeIn($timeIn){
        $empId=$_SESSION["loginId"];
        $date=date('Y-m-d');
        $conn=Conn::getInstance();
        echo $empId;
        echo $date;
        echo $timeIn;
        echo 'Helo';
        try {

            $sql = "INSERT INTO attendance (timeIn,timeOut,employeeId,attendance_date)
                VALUES ('$timeIn','$timeIn','$empId', '$date')";

            // use exec() because no results are returned
            $conn->exec($sql);

            echo "New record created successfully";
        }
        catch
        (PDOException $e) {
            $e->getMessage();
        }
    }
    public function insertTimeOut($timeOut){
        $empId=$_SESSION["loginId"];
        $date=date('Y-m-d');
        $conn=Conn::getInstance();

        echo $date;
        echo $timeOut;
        echo 'Helo';
        $sql = "UPDATE attendance SET timeOut='$timeOut' WHERE attendance_date='$date' AND employeeId='$empId'";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();
//        try {
//
//            $sql = "INSERT INTO attendance (timeIn,timeOut,employeeId,attendance_date)
//                VALUES ('$timeIn','$timeIn','$empId', '$date')";
//
//            // use exec() because no results are returned
//            $conn->exec($sql);
//
//            echo "New record created successfully";
//        }
//        catch
//        (PDOException $e) {
//            $e->getMessage();
//        }
    }
    public function todayAttendance(&$count) {
        $conn=Conn::getInstance();
        $date=date('Y-m-d');

        $sql = "SELECT attendance.timeIn,attendance.timeOut,attendance.onleave,attendance.late,Employees.employeeName FROM attendance
                   INNER JOIN Employees where attendance.employeeId=Employees.empId AND attendance.attendance_date='$date'";
        $attendance[]=array();
        foreach ($conn->query($sql) as $row) {
            $attendance["timeIn"]= $row['timeIn'];
            $attendance["timeOut"]=$row['timeOut'];
            $attendance["onleave"]=$row['onleave'];
            $attendance["late"]=$row['late'];
            $attendance["employeeName"]=$row['employeeName'];
            $count++;
        }
        return $attendance;
    }
    public function monthReport($name,&$count) {
        $conn=Conn::getInstance();
        $name=strtoupper($name);
        $sql = "SELECT attendance.timeIn,attendance.timeOut,attendance.attendance_date,attendance.onleave,attendance.late,Employees.employeeName FROM attendance
                   INNER JOIN Employees where attendance.employeeId=Employees.empId AND UPPER(monthname(attendance.attendance_date))='$name'";
        $report=[];
        foreach ($conn->query($sql) as $row) {
            $report["timeIn.'$count'"]=$row['timeIn'];
            $report["timeOut.'$count'"]=$row['timeOut'];
            $report["onleave.'$count'"]=$row['onleave'];
            $report["attendance_date.'$count'"]=$row["attendance_date"];
            $report["late.'$count'"]=$row['late'];
            $report["employeeName.'$count'"]=$row['employeeName'];
            $count++;
        }
        return $report;
    }
    public function employeeList($name,&$count) {
        $conn=Conn::getInstance();
        $name=strtoupper($name);
        $sql = "SELECT Employees.empId,Employees.employeeName,Employees.department,Employees.salary,Employees.boss,Employees.email,Employees.picture,empDesignation.designationName,Employees.password
                FROM Employees INNER JOIN empDesignation where empDesignation.id=Employees.designation
                AND UPPER(Employees.employeeName) like UPPER ('%$name%')";
        $employees=[];
        foreach ($conn->query($sql) as $row) {
            $id=$row['empId'];
            $employees["id.'$count'"]=$row['empId'];
            $employees["name.'$count'"]=$row['employeeName'];
            $employees["department.'$count'"]=$row["department"];
            $employees["salary.'$count'"]=$row["salary"];
            $employees["boss.'$count'"]=$row["boss"];
            $employees["email.'$count'"]=$row["email"];
            $employees["picture.'$count'"]=$row["picture"];
            $_SESSION["designation.'$id'"]=$row["designationName"];
            $employees["designation.'$count'"]=$row["designationName"];
            $employees["password.'$count'"]=$row["password"];
            echo '<br>';
            $count++;
        }
        return $employees;
    }
    public function getEditData() {
        $id=$_SESSION["editId"];
        $conn=Conn::getInstance();
        $sql="SELECT * FROM Employees WHERE empId='$id'";
        foreach ($conn->query($sql) as $row) {
            $_SESSION["name"]=$row['employeeName'];
            $_SESSION["department"]=$row["department"];
            $_SESSION["salary"]=$row["salary"];
            $_SESSION["boss"]=$row["boss"];
            $_SESSION["email"]=$row["email"];
            $_SESSION["picture"]=$row["picture"];


            $_SESSION["designation"]=$_SESSION["designation.'$id'"];
            $_SESSION["password"]=$row["password"];
        }
    }
    public function getDesignation()
    {
        $conn=Conn::getInstance();
        $designation=array();


        $sql = 'SELECT designationName FROM empDesignation';
        $i=0;
        foreach ($conn->query($sql) as $row) {
            $designation[]=  ($row['designationName']);
        }

        return $designation;
    }
    public function getBoss()
    {
        $conn=Conn::getInstance();
        $boss=array();


        $sql = 'SELECT Employees.employeeName FROM Employees INNER JOIN empDesignation
                  ON Employees.designation=empDesignation.id
                   where empDesignation.designationName="Manager" ';
        $i=0;
        foreach ($conn->query($sql) as $row) {
            $boss[]= ($row['employeeName']);
        }

        return $boss;
    }
    public function updateEmployee() {
        $conn=Conn::getInstance();
        $STH = $conn -> prepare( "select id from empDesignation where designationName=?" );
        $designation=$_SESSION["editDesignation"];
        $STH -> execute([$designation]);
        $result = $STH -> fetch();
        $designationId=$result ["id"];
        $name=$_SESSION["editName"];
        $boss=$_SESSION["editBoss"];
        $password=$_SESSION["editPassword"];
        $department=$_SESSION["editDepartment"];
        $salary=$_SESSION["editSalary"];
        $email=$_SESSION["editEmail"];
        $image=$_SESSION["editImage"];
        $id=$_SESSION["editId"];

        $sql = "UPDATE Employees SET employeeName='$name',department='$department',salary='$salary',email='$email',boss='$boss',picture='$image',designation='$designationId',password='$password'
                WHERE empId='$id'";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();
        echo 'successfuly';
    }
    public function deleteEmployee() {
        $id= $_SESSION["deleteId"];
        $conn=Conn::getInstance();

        try {


            // sql to delete a record
            $sql = "DELETE FROM Employees WHERE empId='$id'";

            // use exec() because no results are returned
            $conn->exec($sql);
            echo "Record deleted successfully";
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function insertEmployee(){
        $conn=Conn::getInstance();
        $STH = $conn -> prepare( "select id from empDesignation where designationName=?" );
        $designation=$_SESSION["insertDesignation"];
        $STH -> execute([$designation]);
        $result = $STH -> fetch();
        $designationId=$result ["id"];

        $name=$_SESSION["insertName"];
        $boss=$_SESSION["insertBoss"];
        $password=$_SESSION["insertPassword"];
        $department=$_SESSION["insertDepartment"];
        $salary=$_SESSION["insertSalary"];
        $email=$_SESSION["insertEmail"];
        $image=$_SESSION["insertImage"];

        try {


            $sql = "INSERT INTO Employees (employeeName,department,salary,boss,email,picture,designation,password)
                VALUES ('$name','$department', '$salary','$boss','$email','$image','$designationId','$password')";

            // use exec() because no results are returned
            $conn->exec($sql);

            echo "New record created successfully";
        }
        catch
        (PDOException $e) {
            $e->getMessage();
        }

    }
}