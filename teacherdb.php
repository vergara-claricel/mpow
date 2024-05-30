<?php
// require 'dashboard.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
  
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'mpow';

// connect to db
  $konek = mysqli_connect($hostname, $username, $password, $dbname);

    $result = $konek->query("SELECT s.schedule_id, s.day, s.start_time, s.end_time, s.classstatus, 
    c.section AS section, c.classcode AS classcode 
    FROM schedule s JOIN classes c ON c.class_id=s.class_id
    JOIN instructors i ON c.instructor_id = i.instructor_id 
    WHERE c.instructor_id=1 
    ORDER BY s.day, s.start_time;
    ");

// name persistence?? so malipat-lipat w/o error
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

// delete
    if (isset($_GET['delete'])) {
        $konek->query("DELETE s, c
        FROM schedule s
        JOIN classes c ON c.class_id = s.class_id
        JOIN instructors i ON c.instructor_id = i.instructor_id
        WHERE s.schedule_id = {$_GET['delete']} AND c.instructor_id = 1;");
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
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
    top: 5px;
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
    }

    .schedulearea{
        display:flex;
        flex-direction: column;
        align-items:center;
        gap:2rem;
        padding-top: 1rem;
        padding-bottom: 2rem;
    }

    .schedulearea table {
        background-color: #f6f6f6;
    }

    .schedulearea table th {
        width: 170px;
        height: 50px;
    }

    .schedulearea table td {
        width: 170px;
        height: 50px;
        text-align: center;
    }

    .schedheader{
        display:flex;
        margin-left: 8rem;
        margin-right: 8rem;
        justify-content: space-between;
    }

    .schedheader h1{
        font-size: 36px;
        text-align: left;
        color: #f6f6f6;
    }

    .newclassbutton a {
        display: inline-block;
        color: black;
        padding: 11px;
        text-decoration:none;
        text-align: center;
        background-color: #FFE34E;
        border-radius: 10px;
    }

    .edit {
        display: inline-block;
        color: black;
        padding: 7px;
        text-decoration:none;
        text-align: center;
        background-color: #70FD4D;
        border-radius: 10px;
        border: none;
    }

    .delete{
        display: inline-block;
        color: black;
        padding: 6px;
        text-decoration:none;
        text-align: center;
        background-color: red;
        border-radius: 10px;
        border:none;
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
            <div class="schedheader">
                <div class="schedh1">
                    <h1>Schedule</h1>
                </div>
                <div class="newclassbutton">
                    <a href="/webfinals/newclass.php?user=<?php echo $username; ?>">+ New Class</a>
                </div>
            </div>
    <section class="schedulearea">
            <div class="tableheader">
                <table>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Class Code</th>
                    <th>Section</th>
                    <th>Class Status</th>
                    <th>Action</th>
                </table>
            </div>

            <div class="schedtable">
                <table>
                    <tbody>
                        <?php
                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td style = 'display:none;'>" . $row['schedule_id'] . "</td>";
                                echo "<td>" . $row['day'] . "</td>";
                                echo "<td>" . $row['start_time'] . " - " . $row['end_time'] . "</td>";
                                echo "<td>" . $row['classcode'] . "</td>";
                                echo "<td>" . $row['section'] . "</td>";
                                echo "<td>" . $row['classstatus'] . "</td>";
                                // echo "<td> <a href='editclass.php?edit=" . $row['schedule_id']. "' &user=". $username ."'>edit</a> <a href='?delete=" . $row['schedule_id'] . "'>delete</a></td>";
                                echo "<td> <a href='editclass.php?edit=" . $row['schedule_id'] . "&user=" . $username . "' class='edit'>edit</a> <a href='teacherdb.php?delete=" . $row['schedule_id'] . "&user=" . $username . "' class='delete'>delete</a></td>";
                                echo "</tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
    </section>
</body>
</html>