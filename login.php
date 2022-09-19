<?php
    require_once "connection.php";
    session_start();
    $error='';
    if (isset($_POST['submit'])) {
        if (empty($_POST['userid']) || empty($_POST['password'])) {
            $error = "UserID or Password is invalid";
        }
        else
        {
            $userid=$_POST['userid'];
            $password=$_POST['password'];
            //$userid="123";
            //$password="321";

            $stmt = $conn->prepare("SELECT user_name FROM user WHERE user_id='$userid' AND user_psw='$password'");
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            //echo json_encode($result);
            if ($stmt->rowCount()>0) {
                $_SESSION['login_id']=$userid;
                header("location: index.php");
            } else {
                $error = "Username or Password is invalid";
            }
        }
}
?>