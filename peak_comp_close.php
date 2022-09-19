<?php
	require_once("connection.php");
	//$update_csp = $conn->prepare("UPDATE company SET comp_csp=comp_csp+50 WHERE comp_id='1'");
	//$update_csp->execute();
	//$select_csp = $conn->prepare("SELECT * FROM company WHERE comp_id='1'");
	//$select_csp->execute();
	//foreach($select_csp as $tmp_select_csp)
	//{
	//	echo $tmp_select_csp["comp_csp"];
	//}
	$update = $conn->prepare("SET @update_id:=0");
	$update->execute();
	$peak =$conn->prepare("UPDATE company SET active_status='0',active_time=time(addtime(SYSDATE(),'00:15:00')),comp_id=(SELECT @update_id:=comp_id) WHERE comp_csp>=(comp_isp*5) AND active_status='1' LIMIT 1");
	$peak->execute();
	$id =$conn->prepare("SELECT @update_id");
	$id->execute();
	$row=$id->fetch();
	if($row[0]>0){
	$name = $conn->prepare("SELECT comp_name FROM company WHERE comp_id=$row[0]");
	$name->execute();
	$row = $name->fetch();
	$news_add = $conn->prepare("INSERT INTO news VALUES(null,'Circuit Breaker Reached Peak. Transaction for $row[0] will resume within 15 minute',time(SYSDATE()),'1',' $row[0] Transaction Close')");
	$news_add->execute();
	}
	
	$update = $conn->prepare("SET @update_iid:=0");
	$update->execute();
	$peak =$conn->prepare("UPDATE company SET active_status='2',active_time=time(addtime(SYSDATE(),'00:15:00')),comp_id=(SELECT @update_iid:=comp_id) WHERE comp_csp<=(comp_isp*0.10) AND active_status='1' LIMIT 1");
	$peak->execute();
	$id =$conn->prepare("SELECT @update_iid");
	$id->execute();
	$row=$id->fetch();
	if($row[0]>0){
	$name = $conn->prepare("SELECT comp_name FROM company WHERE comp_id=$row[0]");
	$name->execute();
	$row = $name->fetch();
	$news_add = $conn->prepare("INSERT INTO news VALUES(null,' $row[0] Circuit Breaker Reached Peak. Transaction for $row[0] will resume within 15 minute',time(SYSDATE()),'1',' $row[0] Transactions Close')");
	$news_add->execute();
	}
?>