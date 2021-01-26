<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<style type="text/css">
        body{ font: 14px sans-serif; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h4 style = "color: #FFFFFF" class="navbar-text">SK BANK APPLICATION</h4>
            </div>
        </div>
    </nav>
    <div id="centerwrapper">
        <div id="centerdiv">
            <br><br>
            <h2>LOGIN TO YOUR ACCOUNT</h2>
            <p>Login name is your name and password is your customer id :)</p>
            <form id="loginForm" action="" method="post">
                <div class="form-group">
                    <label>Login Name:</label>
                    <input type="text" name="loginName" class="form-control" id="loginName">

                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" id="password">

                </div>
                <div class="form-group">
                    <input onclick="checkEmptyAndLogin()" class="btn btn-primary" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function checkEmptyAndLogin() {
        var usernameVal = document.getElementById("loginName").value;
        var passwordVal = document.getElementById("password").value;
        if (usernameVal === "" || passwordVal === "") {
            alert("Empty!");
        }
        else {
            var form = document.getElementById("loginForm").submit();
        }
    }
</script>
</body>
</html>

<?php


//connection to database   
   define('DB_SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
   define('DB_USERNAME', 'sena.korkut');
   define('DB_PASSWORD', 'KcAWEeki');
   define('DB_DATABASE', 'sena_korkut');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (!$db) {
    die("Mysql Connection Error!!" . mysqli_connect_error());
}
session_start();
$username = "";
$password = "";
if($_POST) {
    $loginName = mysqli_real_escape_string($db,$_POST['loginName']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
    //Check customer from database
    $sql = "SELECT name, cid FROM customer WHERE name = ? and cid = ?";
    if($stmt = mysqli_prepare($db, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $current_customer, $current_customerId);
        $current_customer = $loginName;
        $current_customerId = $password;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) > 0){

                mysqli_stmt_bind_result($stmt, $loginName, $turned_pw);
                if(mysqli_stmt_fetch($stmt)){
                    if($turned_pw == $password){
                        session_start();
                        $_SESSION['name'] = $loginName;
                        $_SESSION['cid'] = $password;
                        header("location: customer_welcome.php");
                    }
                }
            }else{
                echo "<script type='text/javascript'>alert('Invalid Credentials');</script>";
            }

        }
    }

    mysqli_stmt_close($stmt);
}
?>
