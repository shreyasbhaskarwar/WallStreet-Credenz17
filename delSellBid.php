<?php
	require_once('connection.php');

	$sell_id = $_GET['sell_id'];

	$sql = "DELETE FROM seller_bids WHERE sell_id = :sell_id ;";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':sell_id', $sell_id);
	$stmt->execute();

	$count = $stmt->rowCount();
	if($count == 0)
		echo "0";
	else
		echo "1";

?>