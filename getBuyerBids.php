
<?php
session_start();
	require_once("connection.php");
	try{
		$id=$_SESSION["login_id"];

		$stmt=$conn->query("select buy_id,buyer_id,c.comp_name,buy_stocks,max_buyp from buyer_bids b,company c where b.comp_id=c.comp_id and buyer_id=$id order by buy_id desc;");
		$stmt->execute();
		foreach($stmt as $row){
		    ?>
						<tr><th> <input type='button' class="bbidbtn" value='Cancel' id='<?php echo $row[0]; ?>' onclick="delBuyBid(this.id);"> </th><td><?php echo $row[2]; ?></td><td><?php echo $row[3]; ?></td><td><?php echo $row[4]; ?></td> </tr>
            <?php
            }

	}catch(Exception $e){
		echo "Error buyers bid";	
	}
	
	//echo '';
?>
