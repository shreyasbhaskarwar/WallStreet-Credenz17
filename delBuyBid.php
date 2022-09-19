<?php
	require_once('connection.php');
    $buy_id=null;
	$buy_id = $_GET['buy_id'];

		$stmt1=$conn->prepare('select buyer_id,max_buyp,buy_stocks from buyer_bids where buy_id= :buy_id ;');
		$stmt1->bindParam(':buy_id', $buy_id);
		$stmt1->execute();
		$row = $stmt1->fetch();
	$sql = "DELETE FROM buyer_bids WHERE buy_id = :buy_id ;";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':buy_id', $buy_id);
	$stmt->execute();

	$count = $stmt->rowCount();
	if($count == 0)
		echo "0"; // Fail: No bid found
	else{
	
			$cash = $row[1]*$row[2] + ($row[1]*$row[2])*0.02;
			$stmt2 = $conn->prepare('update `user` set `total_cash` = `total_cash` + :cash where `user_id` ='. $row[0]);
			$stmt2->bindParam(':cash',$cash);
			$stmt2->execute();
		echo "1"; //Success: Bid removed
		}
?>