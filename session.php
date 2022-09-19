<?php
    require_once "connection.php";
    session_start();

    $user_check=$_SESSION['login_id'];
    $stmt = $conn->prepare("SELECT user_name FROM user WHERE user_id='$user_check'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $login_session =$row['user_name'];
    if(!isset($login_session)){
        header('Location: sign-in.php');
    }
?>