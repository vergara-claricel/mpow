<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mpow';

$konek = mysqli_connect($hostname, $username, $password, $dbname);

// edit class
    if (isset($_GET['edit'])){
        $schedule_id =$_GET['edit'];
    }

    $query1 = "SELECT `schedule_id`, `day`, `start_time`, `end_time`, `classstatus` from `schedule` where `schedule_id` = '$schedule_id'";
    $result = mysqli_query($konek, $query1);

    if ($result){
        $row = mysqli_fetch_assoc($result);
    }

    // para sa name display at username thing
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

    // update class
    if (isset($_POST['update'])){
        $day = $_POST['day'];
        $start_time = $_POST['starttime'];
        $end_time = $_POST['endtime'];
        $status = $_POST['classStatus'];
        
    
        $updatequery=$konek->query("UPDATE `schedule` SET `day`='$day', `start_time`='$start_time', `end_time`='$end_time', `classstatus`='$status' WHERE `schedule_id`='$schedule_id'");

        if ($updatequery){
            header("Location: /webfinals/teacherdb.php?user=$username");
        } else {
            mysqli_error($updatequery);
        }

    }

    // display code and section
    $codesectionquery = $konek->query("SELECT s.schedule_id, c.section AS section, c.classcode AS classcode 
    FROM schedule s JOIN classes c ON c.class_id=s.class_id
    JOIN instructors i ON c.instructor_id = i.instructor_id 
    WHERE c.instructor_id=1 AND s.schedule_id='$schedule_id';");
    
    $codesectionresults = $codesectionquery->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MPOW</title>

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
            color: #70FD4D;
            padding:1rem;
            font-size: 20pt;
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

        .formarea div button{
            background-color:#70FD4D;
            width: 8rem;
            height: 3rem;
            border:none;
            border-radius: 10px;
            font-weight:bold;
            font-size: 16px;

        }

        .updbutton{
            padding-top:1rem;
            display:flex;
            justify-content: center;
        }

    </style>
</head>
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
            <h2> Edit Class for <?php echo $codesectionresults['classcode'] . " " . $codesectionresults['section'];?> </h2>
    <form method="POST" class="formarea">
        <label for="day">Day</label>
        <select name="day" id="dayval">
            <option value="Monday" <?php if($row['day'] == 'Monday') echo 'selected'; ?>>Monday</option>
            <option value="Tuesday" <?php if($row['day'] == 'Tuesday') echo 'selected'; ?>>Tuesday</option>
            <option value="Wednesday" <?php if($row['day'] == 'Wednesday') echo 'selected'; ?>>Wednesday</option>
            <option value="Thursday" <?php if($row['day'] == 'Thursday') echo 'selected'; ?>>Thursday</option>
            <option value="Friday" <?php if($row['day'] == 'Friday') echo 'selected'; ?>>Friday</option>
            <option value="Saturday" <?php if($row['day'] == 'Saturday') echo 'selected'; ?>>Saturday</option>
        </select>
        <label for="startTime">Start Time</label>
        <input type="time" name="starttime" value="<?php echo $row['start_time']; ?>">
        <label for="endTime">End Time</label>
        <input type="time" name="endtime" value="<?php echo $row['end_time']; ?>">
        <label for="classStatus">Class Status</label>
        <select name="classStatus" id="classStatus">
            <option value="May pasok" <?php if($row['classstatus'] == 'May pasok') echo 'selected'; ?>>May pasok</option>
            <option value="Walang pasok" <?php if($row['classstatus'] == 'Walang pasok') echo 'selected'; ?>>Walang pasok</option>
        </select>
        <div class="updbutton">
        <button type="submit" name="update"> Update</button>
        </div>
    </form>
</div>
</body>
</html>