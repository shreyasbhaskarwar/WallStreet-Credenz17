<?php
//include('login.php');
session_start();


if(isset($_SESSION['login_id'])){
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | WallStreet</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="css/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css1/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">WALLSTREET</a>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" action="" method="POST">
                    <div class="msg">Sign in to start your game</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="userid" placeholder="UserID" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <?php
//                    if(isset($error)){
//                        echo '<div>'.$error.'</div>';
//                    }
//                    ?>
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8">
                            <input name="submit" type="submit" value=" Login ">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php

//    define( "DB_DSN", "mysql:host=localhost;dbname=wallstreet" );
//    define( "DB_USERNAME", "root" );
//    define( "DB_PASSWORD", "" );
//    define("LOGGEDINN",false);
//
//    try{
//
//        $conn=new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
//
//    }
//    catch (PDOException $exception)
//    {
//        echo "Error".$exception->getMessage();
//    }
    require_once 'connection.php';


    $error='';
    if (isset($_POST['submit'])) {
        if (empty($_POST['userid']) || empty($_POST['password'])) {
            $error = "UserID or Password is invalid";
        }
        else
        {
            $userid=$_POST['userid'];
            $password=$_POST['password'];
            $userid=stripslashes($userid);
            $password=stripslashes($password);
            $userid=trim($userid);
            $password=trim($password);
            
            $stmt = $conn->prepare("SELECT user_name FROM user WHERE user_id=:userid AND user_psw=:password");
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount()>0) {
                $_SESSION['login_id']=$userid;
                header("Location: index.php");
            } else {
                $error = "Username or Password is invalid";
            }
        }
    }
    ?>

    <!-- Jquery Core Js -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="js/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="js/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/sign-in.js"></script>
</body>

</html>