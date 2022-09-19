<?php

require_once('connection.php');
session_start();
$seller_id = $_SESSION['login_id'];
$cname = $_POST['scname'];
$sell_stocks = $_POST['snostocks'];
$min_sellp = $_POST['sprice'];

try{
	$sql = 'SELECT comp_csp, comp_id FROM company WHERE comp_name = :comp_name';
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':comp_name', $cname);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$result = $stmt->fetch();
	
	$comp_csp = $result['comp_csp'];
	$comp_id = $result['comp_id'];

	$min_sell_lowRange = $comp_csp - ceil(0.05 * $comp_csp);
	$min_sell_highRange = $comp_csp + ceil(0.05 * $comp_csp);
	if($sell_stocks==""|| $min_sellp==""){
        echo "4"; //Fields cannot be empty
    }
    elseif($sell_stocks>30||$sell_stocks<0){
        echo "3"; //Buy stocks > 30
    }
    elseif($min_sellp > $min_sell_highRange || $min_sellp < $min_sell_lowRange){
		echo "0"; //FAILURE Sell Price not in range
	}
	else {
		$sql = 'SELECT no_stocks FROM shares WHERE comp_id = :comp_id AND user_id = :user_id';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':comp_id', $comp_id);
		$stmt->bindParam(':user_id', $seller_id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$result = $stmt->fetch();
		
		$curr_no_stocks = $result['no_stocks'];

		
		$sql = 'SELECT SUM(sell_stocks) AS totStocks FROM seller_bids WHERE seller_id = :seller_id AND comp_id = :comp_id';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':comp_id', $comp_id);
		$stmt->bindParam(':seller_id', $seller_id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$result = $stmt->fetch();

		$stocks_in_market = $result['totStocks'];

		if($sell_stocks + $stocks_in_market > $curr_no_stocks){
			echo "1"; //Error: Not Enough Stocks
		}
		else{

			$sql = 'INSERT INTO seller_bids(seller_id, comp_id, sell_stocks, min_sellp) VALUES(:seller_id, :comp_id, :sell_stocks, :min_sellp)';

			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':seller_id', $seller_id);
			$stmt->bindParam(':comp_id', $comp_id);
			$stmt->bindParam(':sell_stocks', $sell_stocks);
			$stmt->bindParam(':min_sellp', $min_sellp);
			$stmt->execute();

			echo "2"; //Success
		}
	}
}catch(PDOException $e){
	$conn = null;
	die("Error: ".$e->getMessage());
}
?>