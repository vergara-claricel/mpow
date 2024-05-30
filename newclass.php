<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
  
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'mpow';

// connect to db
  $konek = mysqli_connect($hostname, $username, $password, $dbname);

  if(isset($_GET['user'])){
    $username = $_GET['user'];
    $queryname = $konek -> query("SELECT `lastname`, `firstname` FROM `users` where `username` = '$username';");
    $rowname = $queryname->fetch_assoc();

    if(!isset($_SESSION['firstname']) && !isset($_SESSION['lastname'])){
        $_SESSION['firstname'] = $rowname['firstname'];
        $_SESSION['lastname'] = $rowname['lastname'];
    }
}

  $firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
  $lastname = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';

  if(isset($_POST['addclass'])){
    $day = $_POST['day'];
    $start_time = $_POST['starttime'];
    $end_time = $_POST['endtime'];
    $classcode = $_POST['classcode'];
    $section = $_POST['section'];

      $sql1 = $konek->query("INSERT INTO schedule (`day`, `start_time`, `end_time`) VALUES ('$day','$start_time', '$end_time')");
      $schedule_id = $konek->insert_id;
      $sql2 = $konek->query("INSERT INTO classes (`classcode`, `section`) VALUES ('$classcode','$section')");

      $class_id = $konek->insert_id;
      $update_sql = $konek->query("UPDATE classes SET instructor_id = 1 WHERE class_id = $class_id");
      $update_schedule_sql = $konek->query("UPDATE schedule SET class_id = $class_id WHERE schedule_id = $schedule_id");
      if ($sql1 && $sql2 && $update_sql && $update_schedule_sql){
        header("Location: /webfinals/teacherdb.php?user=$username");
        exit();
      }
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Class</title>
</head>
<style>
        *{
        padding: 0;
        margin: 0;
        /* border: 1px black solid; */
        }
        body{
            background-color: #0C5500;
            font-family: Helvetica;
        }
        .navbar{
            padding-bottom:2rem;

        }

        .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 62px;
        }

        .navbar .nav-container a {
        text-decoration: none;
        color: #0e2431;
        font-weight: 500;
        font-size: 1.2rem;
        padding: 0.7rem;
        }

        .navbar .nav-container a:hover{
            font-weight: bolder;
        }

        .nav-container {
        display: block;
        position: relative;
        height: 60px;
        }

        .nav-container .checkbox {
        position: absolute;
        display: block;
        height: 32px;
        width: 32px;
        top: 20px;
        left: 20px;
        z-index: 5;
        opacity: 0;
        cursor: pointer;
        }

        .nav-container .hamburger-lines {
        display: block;
        height: 26px;
        width: 32px;
        position: absolute;
        top: 17px;
        left: 20px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        }

        .nav-container .hamburger-lines .line {
        display: block;
        height: 4px;
        width: 100%;
        border-radius: 10px;
        background: #f6f6f6;
        }

        .nav-container .hamburger-lines .line1 {
        transform-origin: 0% 0%;
        transition: transform 0.4s ease-in-out;
        }

        .nav-container .hamburger-lines .line2 {
        transition: transform 0.2s ease-in-out;
        }

        .nav-container .hamburger-lines .line3 {
        transform-origin: 0% 100%;
        transition: transform 0.4s ease-in-out;
        }

        .navbar .menu-items {
        padding-top: 60px;
        height: 3rem;
        width: 10%;
        transform: translate(-150%);
        display: flex;
        flex-direction: column;
        padding-left:50px;
        transition: transform 0.3s ;
        text-align: left;
        font-size: 1.5rem;
        font-weight: 500;
        background-color: black;
        }

        .title {
        position: absolute;
        top: 13px;
        right: 15px;
        font-size: 1.2rem;
        color: #f6f6f6;
        }
        .teacherName {
            position: absolute;
            top: 13px;
            left: 70px;
            font-size: 1rem;
            color: #f6f6f6;
        }

        .nav-container input[type="checkbox"]:checked ~ .menu-items {
        transform: translateX(0);
        }

        .nav-container input[type="checkbox"]:checked ~ .hamburger-lines .line1 {
        transform: rotate(45deg);
        }

        .nav-container input[type="checkbox"]:checked ~ .hamburger-lines .line2 {
        transform: scaleY(0);
        }

        .nav-container input[type="checkbox"]:checked ~ .hamburger-lines .line3 {
        transform: rotate(-45deg);
        }
        .parent-container{
            display:flex;
            flex-direction:column;
            padding-bottom: 2rem;
        }

        h2{
            text-align:center;
            color: #FFE34E;
            padding:1rem;
            font-size: 25pt;
        }
        
        .formarea{
            display:flex;
            flex-direction: column;
            gap:1rem;
            background-color: #f6f6f6;
            margin-left: 250px;
            margin-right: 250px;
            padding-top:3rem;
            padding-bottom:2rem;
            padding-left:15rem;
            padding-right:15rem;
            border-radius:10px;
            font-family:arial;
        }

        .formarea select, input{
            border-radius:6px;
            padding: 6px;
            border:1px gray groove;
        }

        .formarea label{
            font-size: 11pt;
            font-weight: bold;
            font-family: Arial;
        }


        .buttons{
          margin-top:1rem;
          display:flex;
          justify-content:center;
          align-self:center;
        }
        
        .addclass{
          background-color: #FFE34E;
          font-size: 16px;
          /* display:flex;
          justify-content:center;
          align-self:center;*/
          border:none;
          font-weight: bold;
          width:7rem;
          height:3rem;
        }



    </style>
<body>
<div class="parent-container">
        <div class="navbar">
            <div class="container nav-container">
                <input class="checkbox" type="checkbox"/>
                <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
                </div>
            <div class="teacherName">
                <h1>hello, <?php echo $firstname . " ". $lastname ?></h1>
            </div> 
            <div class="title">
                <h1>MPOW</h1>
            </div>
            <div class="menu-items">
                <!-- <a style="color: #f6f6f6" href="#">Schedule</a> -->
                <a style="color: #f6f6f6" href="/webfinals/logout.php">Logout</a>
            </div>
            </div>
        </div>
        <h2> New Class </h2>
        <form method="POST" class="formarea">
        <label for="day">Day</label>
        <select name="day">
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
        </select>
        <label for="startTime">Start Time</label>
        <input type="time" name="starttime"/>
        <label for="endTime">End Time</label>
        <input type="time" name="endtime"/>
        <label for="classCode">Class Code</label>
        <input type="text" name="classcode"/>
        <label for="section">Section</label>
        <select name="section">
            <option value="BSIT 101">BSIT 101</option>
            <option value="BSIT 102">BSIT 102</option>
            <option value="BSIT 103">BSIT 103</option>
            <option value="BSIT 201">BSIT 201</option>
            <option value="BSIT 202">BSIT 202</option>
            <option value="BSIT 203">BSIT 203</option>
        </select>

        <div class="buttons">
          <input type="submit" name="addclass" value="Add Class" class="addclass">
        </div>
    </form>
  </div>
</body>
</html>