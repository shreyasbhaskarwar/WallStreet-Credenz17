<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<?php
require_once("connection.php");	

date_default_timezone_set("Asia/Kolkata");
		$time = date('H:i:s');
		$stmt = $conn->prepare("update news set news_status=1 where news_time <='".$time."' and news_status =0;");
		$stmt->execute();
		echo $time;
?>