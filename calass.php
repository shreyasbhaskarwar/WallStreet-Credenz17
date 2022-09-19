<?php
	include_once("connection.php");
	$stmt1=$conn->prepare("select shares.user_id, SUM( shares.no_stocks * company.comp_csp ) from shares,company where company.comp_id=shares.comp_id group by shares.user_id");
	$stmt1->execute();
	foreach($stmt1 as $row1){
			$stmt2=$conn->prepare("select total_cash from user where user_id= $row1[0] ;");
			$stmt2->execute();
			foreach($stmt2 as $row2){
				$assets = $row2[0]*0.4 + $row1[1]*0.6;
				$stmt3=$conn->query("update user set total_assets= $assets where user_id= $row1[0] ;");
				$stmt3->execute();
			}
	}
?>
