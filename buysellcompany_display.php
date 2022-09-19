<?php
//include('session.php');
session_start();
include_once("connection.php");
if(!isset($_SESSION['login_id'])){
    header("location: sign-in.php");
}
    $stmt=$conn->prepare("Select comp_name from company where active_status=1 ORDER BY comp_name");
    $stmt->execute();
echo '<link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
        <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
        <script src="js/admin.js"></script>
        <script src="js/pages/forms/advanced-form-elements.js"></script>';

    echo ' <p style="font-size:13px;padding-left:15px;margin-bottom:5px;color:#9e9e9e">
        Company Name
    </p><select id="buy_list" name="bcname" class="form-control show-tick" data-live-search="true" required>';
    foreach($stmt as $row){
        echo "<option>".$row['comp_name']."</option>";
    }
    echo '</select>';
?>