<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Search Participant</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

    <style>
    * {
        margin: 0;
        padding: 0;
    }
    
    table {
        background-color: #fff;
        color: black;
    }
    
    table, td, th {
        border: 1px solid #000;
        text-align: center;
    }
    </style>
</head>

<body class="signup-page orange darken-4">
    <div class="row">
        <div class="signup-box col s8 m4 offset-s1 offset-m4" style="padding-top: 30px;">
                <center><h2 style="color: #fff;"><b>Admin@Wallstreet</b></h2></center>
            <div class="card" style="padding-bottom: 20px;">
                <form name="Regi-Form" class="container" id="register" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <center>
                    <h4 style="padding: 20px 0px 10px 0px;">Participant Search</h4>
                    </center>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="icon_prefix" name="parti_name" type="text">
                        <label for="icon_prefix">Participant's Name</label>
                    </div>
                    
                    <div id="submit1" style="padding: 10px 0px 10px 0px;">
                        <center>
                        <button class="btn btn-block btn-lg purple darken-3 waves-effect" type="submit" name="submit1">Search</button>
                        </center>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="icon_prefix" name="parti_mobile" type="text">
                        <label for="icon_prefix">Participant's Mobile</label>
                    </div>
                    <div id="submit2" style="padding: 10px 0px 10px 0px;">
                        <center>
                        <button class="btn btn-block btn-lg purple darken-3 waves-effect" type="submit" name="submit2">Search</button>
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

    <script type="text/javascript">
    </script>
</body>

<?php
    $parti_name = "";
    include_once ("connection.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if(isset($_POST['submit1']))
        {
        $parti_name = test_input($_POST["parti_name"]);
        try
        {
            $stmt = $conn->prepare("SELECT user_id,user_name,user_mob,user_clg,user_psw FROM user where user_name LIKE ?");
            $stmt->bindValue(1,"%$parti_name%",PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_NUM);
            if($stmt->rowCount() == 0)
            {
                echo "No results found<br>";
            }
            else
            {   echo "<table><tr><th>ID</th><th>NAME</th><th>MOBILE</th><th>COLLEGE</th><th>PASSWORD</th></tr>";
                foreach ($stmt as $row)
                {
                    echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";
                }
                echo "</table>";
            }
        }

        catch (PDOException $exception)
        {
            echo $exception->getMessage();
        }
        }
        if(isset($_POST['submit2']))
        {
            $parti_mobile = test_input($_POST["parti_mobile"]);
        try
        {
            $stmt = $conn->prepare("SELECT user_id,user_name,user_mob,user_clg,user_psw FROM user where user_mob=$parti_mobile");
            /*$stmt->bindValue(1,"$parti_mob");*/
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_NUM);
            if($stmt->rowCount() == 0)
            {
                echo "No results found<br>";
            }
            else
            {   echo "<table><tr><th>ID</th><th>NAME</th><th>MOBILE</th><th>COLLEGE</th><th>PASSWORD</th></tr>";
                foreach ($stmt as $row)
                {
                    echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";
                }
                echo "</table>";
            }
        }

        catch (PDOException $exception)
        {
            echo $exception->getMessage();
        }       
        }
    }
?>
</html>