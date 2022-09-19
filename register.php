<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Register Participant</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
</head>

<body class="signup-page orange darken-4">
    <div class="row">
        <div class="signup-box col s8 m4 offset-s1 offset-m4" style="padding-top: 30px;">
                <center><h2 style="color: white;"><b>Admin@Wallstreet</b></h2></center>
            <div class="card" style="padding-bottom: 20px;">
                <form name="Regi-Form" class="container" id="register" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <center>
                    <h4 style="padding: 20px 0px 10px 0px;">Wallstreet Registration</h4>
                    </center>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="icon_prefix" name="full_name" type="text" required>
                        <label for="icon_prefix">Name</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">phone</i>
                        <input id="icon_telephone" name="parti_mobile" type="tel" minlength="10" required>
                        <label for="icon_telephone">Mobile</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_balance</i>
                        <input id="icon_clg" name="parti_clg" type="text" required>
                        <label for="icon_clg">College</label>
                    </div>
                    <div id="submit1" style="padding: 10px 0px 10px 0px;">
                        <center>
                        <button class="btn btn-block btn-lg purple darken-3 waves-effect" type="submit" value="submit">Register</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    
    
</body>

<?php
	function generatePassword()
{
    $length = 6;
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[mt_rand(0, $max-1)];
    }
    return $token;
}
		
    $parti_name = $parti_mobile = $parti_clg = "";
    include_once ("connection.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $parti_name = test_input($_POST["full_name"]);
        $parti_mobile = test_input($_POST["parti_mobile"]);
        $parti_clg = test_input($_POST["parti_clg"]);
        $parti_psw = generatePassword();
        
        try
        {
            $stmt = $conn->prepare("INSERT INTO user (user_name,user_mob,user_clg,user_psw) VALUES (?,?,?,?)");
            $stmt->bindParam(1,$parti_name,PDO::PARAM_STR);
            $stmt->bindParam(2,$parti_mobile);
            $stmt->bindParam(3,$parti_clg,PDO::PARAM_STR);
            $stmt->bindParam(4,$parti_psw,PDO::PARAM_STR);
            if($stmt->execute()) 
            {
                echo "<script> alert('Registration Successfull') </script>";
            }
            else {
            	echo "<script> alert('Registration NOT Successfull') </script>";
            }
        }

        catch (PDOException $exception)
        {
            echo $exception->getMessage();
        }
    }
?>
</html>