<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
  
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'mpow';

// connect to db
  $konek = mysqli_connect($hostname, $username, $password, $dbname);
// get from db
  $results = $konek->query("SELECT * FROM `users` WHERE 1")->fetch_all(MYSQLI_ASSOC);

  if (isset($_POST['login'])) {
    $accountType = $_POST['accType'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // query if lahat match
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND accountType = '$accountType'";
    // function na nagsesen query to database using nung konek
    $result = mysqli_query($konek, $query);
    // assign dito value kung may nakuha
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // success
        if ($accountType == 'student') {
            header("Location: /webfinals/studentdb.php?user=$username");
        } else if ($accountType == 'teacher') {
            header("Location: /webfinals/teacherdb.php?user=$username");
        }
        exit();
    } else {
        // pag fail
        $error = "Invalid username, password, or account type";
        echo $error;
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>May Pasok O Wala</title>

    <style>
        *{
            padding: 0;
            margin: 0;
            /* border: 1px black solid; */
        }
        body{
            background-color: #FFE34E;
            font-family: Helvetica;
        }
        .parent-container{
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
            padding-bottom: 5rem;
        }
        .title{
            color: #0C5500;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 6rem;
            padding-bottom: 1rem;
        }
        .loginarea{
            background-color: #0C5500;
            width: 400px;
            height: 300px;
            display:flex;
            justify-content:center;
            border-radius: 10px;
            
        }
        .loginbox{
            display:flex;
            flex-direction:column;
            justify-content:center;
            gap:18px;
        }

        .loginbox select, input{
            border-radius:6px;
            padding: 8px;
            border:1px gray groove;
        }
        
        .loginbutton{
            display:flex;
            justify-content: center;
        }

        .loginbutton input {
            background-color: black;
            color: #f6f6f6;
            border:none;
            width: 6rem;
            height: 2rem;
        }

    </style>
</head>
<body>
    <div class="parent-container">
        <div class="title">
            <h1 style="font-size: 60pt">MPOW</h1>
            <h3 style="font-size: 20pt">May Pasok O Wala</h3>
        </div>
        <div class="loginarea">
            <form method="POST" class="loginbox">
                <h4 style="color: #F5F5F5">Select account type:</h4>
                <select name="accType" id="accType">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
                <div class="input">
                    <input type="text" name="username" placeholder="username"/>
                </div>
                <div class="input">
                <input type="password" name="password" placeholder="password"/>
                </div>
                    <div class="loginbutton">
                    <input type="submit" name="login" value="Login"/>
                    </div>
                    
            </form>
            </div>
        </div>
    </div>

</body>
</html>