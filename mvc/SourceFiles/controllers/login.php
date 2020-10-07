<?php
require 'models/user.php';

class login extends Controller {

    function __construct() {
        parent::__construct();
        $user=new User();        //$this->view->render('login/index');
    }

    public function check() {

        $user=new User();
        $check=$user->login();

        $designation=$_SESSION["employeeDesignationId"];

        if ($check==1 && $designation!='HR Manager') {
            $this->view->render('employeeView/empIndex');
        } else if ($check==1 && $designation=='HR Manager') {
            $this->view->render('hrManager/index');
        } else {
            require_once 'controllers/index.php';
            $controller=new Index();
            $controller->other();
            return false;
        }

    }
    public function timeIn(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $timeIn= $_POST['timeIn'];

            $user=new User();
            $user->insertTimeIn($timeIn);

        }

    }
    public function timeOut() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $timeOut= $_POST['timeOut'];

            $user=new User();
            $user->insertTimeOut($timeOut);

        }
    }
    public function logout () {
        session_destroy();

        require_once 'controllers/index.php';
        $controller=new Index();
        $controller->other();
    }
    public function attendanceToday() {
          $user=new User();
          $count=0;
          $attendance=$user->todayAttendance($count);

          $i=0;
        echo '<link rel="stylesheet" href="http://localhost/mvc/SourceFiles/public/css/default.css">';
        echo '<a href="check">Back</a>';
        echo '<br><br>';
        echo '<table>';
        echo '<tr>';
        echo  '<th>Name</th>';
        echo  '<th>timeIn</th>';
        echo  '<th>timeOut</th>';
        echo  '<th>Late Status</th>';
        echo  '<th>Leave Status</th>';
        echo  '</tr>';
          while($i<$count)
          {
             echo '<tr>';
              echo '<td>'.$attendance['employeeName'].'</td>';
              echo '<td>'.$attendance["timeIn"].'</td>';
              echo '<td>'.$attendance["timeOut"].'</td>';
              if($attendance['late']==true)
              {
                  echo '<td>YES</td>';
              } else {
                  echo '<td>No</td>';
              }
              if($attendance['onleave']==true)
              {
                  echo '<td>Yes</td>';
              } else {
                  echo '<td>No</td>';
              }
              echo '</tr>';
              $i++;
          }
          echo '</table>';
//          foreach ($attendance as $row)
//          {
//              echo $row['timeIn'];
//              echo $row['timeOut'];
//              echo $row['onleave'];
//              echo $row['late'];
//              echo $row['employeeName'];
//          }
    }
    public function monthlyReport(){
        $this->view->render('monthlyReport/index');
    }
    public function liveSearch() {
       $name= $_GET['q'];
        $user=new User();
        $count=0;
        $report=$user->monthReport($name,$count);


        $i=0;
        echo '<link rel="stylesheet" href="http://localhost/mvc/SourceFiles/public/css/default.css">';
        echo '<table>';
        echo '<tr>';
        echo  '<th>Name</th>';
        echo  '<th>timeIn</th>';
        echo  '<th>timeOut</th>';
        echo '<th>DATE</th>';
        echo  '<th>Late Status</th>';
        echo  '<th>Leave Status</th>';
        echo  '</tr>';
        while($i<$count)
        {
            echo '<tr>';
            echo '<td>'.$report["employeeName.'$i'"].'</td>';
            echo '<td>'.$report["timeIn.'$i'"].'</td>';
            echo '<td>'.$report["timeOut.'$i'"].'</td>';
            echo '<td>'.$report["attendance_date.'$i'"].'</td>';
            if($report["late.'$i'"]==true)
            {
                echo '<td>YES</td>';
            } else {
                echo '<td>No</td>';
            }
            if($report["onleave.'$i'"]==true)
            {
                echo '<td>Yes</td>';
            } else {
                echo '<td>No</td>';
            }
            echo '</tr>';
            $i++;
        }
        echo '</table>';
    }
    public function employeesList(){
        $this->view->render('employeesList/index');
    }
    public function employeeSearch() {
        $name= $_GET['q'];
        $user=new User();
        $count=0;
        $employeeList=$user->employeeList($name,$count);
        $i=0;
        while($i<$count)
        {
            echo '<div id="div">';
            echo '<span>Name: </span>';
            echo '<span>'.$employeeList["name.'$i'"].'</span>';
            echo '<br>';
            echo '<span>email: </span>';
            echo '<span>'.$employeeList["email.'$i'"].'</span>';
            echo '<br>';
            echo '<span>email: </span>';
            echo '<span>'.$employeeList["boss.'$i'"].'</span>';
            echo '<br>';
            echo '<span>designation: </span>';
            echo '<span>'.$employeeList["designation.'$i'"].'</span>';
            echo '<br>';
            echo '<br>';
            echo '<a href="edit?pid='.$employeeList["id.'$i'"].'">Edit </a>';
            echo '<a href="delete?pid='.$employeeList["id.'$i'"].'"> Delete</a>';
            echo '</div>';
            echo '<br>';
            $i++;
        }
    }
    public function edit() {
        $_SESSION["editId"]=$_GET['pid'];
        $user=new User();
        $user->getEditData();
        $this->view->render('edit/index');
    }
    public function editEmployee() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION["editName"]=$_POST["name"];
            $_SESSION["editBoss"]=$_POST["Boss"];
            $_SESSION["editPassword"]=$_POST["password"];
            $_SESSION["editDepartment"]=($_POST["department"]);
            $_SESSION["editSalary"]=$_POST["salary"];
            if(!empty($_POST["image"])){
                $_SESSION["editImage"]=$_POST["image"];
            } else {
                $_SESSION["editImage"]=$_SESSION["picture"];
            }
            $_SESSION["editEmail"]=$_POST["email"];
            $_SESSION["editDesignation"]=$_POST["designation"];

        }
        $user=new User();
        $user->updateEmployee();
    }
    public function delete() {
        $_SESSION["deleteId"]=$_GET['pid'];
        $user=new User();
        $user->deleteEmployee();
        //$this->view->render('edit/index');
    }
    public function insertEmployee() {
        $this->view->render('insertEmployee/index');
    }
    public function insert() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION["insertName"]=$_POST["name"];
            $_SESSION["insertBoss"]=$_POST["Boss"];
            $_SESSION["insertPassword"]=$_POST["password"];
            $_SESSION["insertDepartment"]=($_POST["department"]);
            $_SESSION["insertSalary"]=$_POST["salary"];
            $_SESSION["insertImage"]=$_POST["image"];

            $_SESSION["insertEmail"]=$_POST["email"];
            $_SESSION["insertDesignation"]=$_POST["designation"];

        }
        $user=new User();
        $user->insertEmployee();
        $this->view->render('hrManager/index');
    }

}