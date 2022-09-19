<?php

require_once('connection.php');
session_start();
$buyer_id = $_SESSION['login_id'];
//$comp_id = $_GET['comp_id'];
$cname = $_POST['bcname'];
$buy_stocks = $_POST['nostocks'];
$max_buyp = $_POST['bprice'];

$total_amount = $max_buyp * $buy_stocks;
$transaction_fees = ceil($total_amount * 0.02);
$total_amount = $total_amount + $transaction_fees;

try{
	$sql = 'SELECT comp_csp, comp_id FROM company WHERE comp_name = :comp_name';
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':comp_name', $cname);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$result = $stmt->fetch();
	
	$comp_csp = $result['comp_csp'];
	$comp_id = $result['comp_id'];

	$max_buy_lowRange = $comp_csp - ceil(0.05 * $comp_csp);
	$max_buy_highRange = $comp_csp + ceil(0.05 * $comp_csp);
	// echo "MaxBuyp = ".$max_buyp."<br>";
	// echo "Max = ".$max_buy_highRange." Min = ".$max_buy_lowRange."<br>";
	//echo $buyer_id,$cname,$buy_stocks,$max_buyp;
    if($buy_stocks==""|| $max_buyp==""){
        echo "4"; //Fields cannot be empty
    }
    elseif($buy_stocks>100||$buy_stocks<0){
        echo "3"; //Buy stocks > 100
    }
    elseif($max_buyp > $max_buy_highRange || $max_buyp < $max_buy_lowRange){
		echo "0"; //FAILURE Buy Price not in range
	}
	else {
		$sql = 'SELECT total_cash FROM user WHERE user_id = :user_id';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':user_id', $buyer_id);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$result = $stmt->fetch();
		
		$curr_cash = $result['total_cash'];

		$new_cash = $curr_cash - $total_amount;

		if($new_cash >= 0){

			$sql = 'INSERT INTO buyer_bids(buyer_id, comp_id, buy_stocks, max_buyp) VALUES(:buyer_id,:comp_id,:buy_stocks,:max_buyp)';

			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':buyer_id', $buyer_id);
			$stmt->bindParam(':comp_id', $comp_id);
			$stmt->bindParam(':buy_stocks', $buy_stocks);
			$stmt->bindParam(':max_buyp', $max_buyp);

			$stmt->execute();

			$sql = "UPDATE user SET total_cash = :total_cash WHERE user_id = :user_id";
			
			$stmt = $conn->prepare($sql); 
			$stmt->bindParam(':total_cash', $new_cash);
			$stmt->bindParam(':user_id', $buyer_id);
			$stmt->execute();

			// echo "Remaining Cash: ".$new_cash;
			echo "2"; //Success
		}
		else{
			echo "1"; //Insufficient Funds
		}
	}
}catch(PDOException $e){
	$conn = null;
	die("Error: ".$e->getMessage());
}

// header("Location: transaction.php");
// exit;
?>