<?php
	require_once("connection.php");
	date_default_timezone_set("Asia/Kolkata");
	$time = date('H:i:s');
	
	$update = $conn->prepare("SET @update_id1:=0");
	$update->execute();
	$open_company = $conn->prepare("UPDATE company SET active_time=NULL,active_status='1',comp_csp=(comp_csp/2),comp_id=(SELECT @update_id1:=comp_id) WHERE active_status='0' AND active_time<='$time' LIMIT 1");
	$open_company->execute();
	$id =$conn->prepare("SELECT @update_id1");
	$id->execute();
	$row=$id->fetch();
	if($row[0]>0){
		$name = $conn->prepare("SELECT comp_name FROM company WHERE comp_id=$row[0]");
		$name->execute();
		$row = $name->fetch();
		echo $row[0];
		$news_add = $conn->prepare("INSERT INTO news VALUES(null,' $row[0] Circuit Breaker Reached Peak. Transaction for $row[0] will resume within 15 minute',time(SYSDATE()),'1',' $row[0] Transaction Close')");
		$news_add->execute();
	}
	
	
	$update = $conn->prepare("SET @update_id2:=0");
	$update->execute();
	$open_company = $conn->prepare("UPDATE company SET active_time=NULL,active_status='1',comp_csp=(comp_isp/2),comp_id=(SELECT @update_id2:=comp_id) WHERE active_status='2' AND active_time<='$time' LIMIT 1");
	$open_company->execute();
	$id =$conn->prepare("SELECT @update_id2");
	$id->execute();
	$row=$id->fetch();
	if($row[0]>0){
		$name = $conn->prepare("SELECT comp_name FROM company WHERE comp_id=$row[0]");
		$name->execute();
		$row = $name->fetch();
		$news_add = $conn->prepare("INSERT INTO news VALUES(null,' Transaction for $row[0] has resume.',time(SYSDATE()),'1',' $row[0] Transactions Open')");
		$news_add->execute();
	}
?>