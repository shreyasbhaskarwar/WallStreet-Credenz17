<?php
include_once("connection.php");
try{
$a=mt_rand(1,36);
	$stmt=$conn->query("select comp_name ,comp_csp from company where comp_id= $a ;");
	$stmt->execute();
	foreach($stmt as $row){
		echo '<div class="text">'. $row[0] .'</div>';
		echo '<div class="number">'. $row[1] .'</div>';
		break;
	}	
}
catch(Exception $e){
	echo 'Error Message: ';
}